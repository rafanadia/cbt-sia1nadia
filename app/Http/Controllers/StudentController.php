<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\ExamResult;
use App\Models\ExamResultDetail;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    private function checkStudent()
    {
        if (!Auth::check()) {
            return redirect()->route('siswa.login');
        }

        if (Auth::user()->is_staff) {
            return redirect('/admin');
        }

        return null;
    }

    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->is_staff) {
                return redirect('/admin');
            }

            return redirect()->route('siswa.dashboard');
        }

        return view('siswa.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([
            $field => $data['login'],
            'password' => $data['password'],
            'is_staff' => false,
        ])) {
            $request->session()->regenerate();

            return redirect()->route('siswa.dashboard');
        }

        return back()
            ->withErrors([
                'login' => 'Username/email atau password salah.',
            ])
            ->onlyInput('login');
    }

    public function dashboard()
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        $subjects = Subject::where('is_active', true)
            ->orderBy('name')
            ->get();

        $results = ExamResult::with('subject')
            ->where('user_id', Auth::id())
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('subjects', 'results'));
    }

    public function startExam(Subject $subject)
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        abort_unless($subject->is_active, 404);

        $questions = Question::where('subject_id', $subject->id)
            ->where('is_active', true)
            ->with(['answers' => fn ($query) => $query->where('is_active', true)])
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('error', 'Belum ada soal aktif untuk mata pelajaran ini.');
        }

        foreach ($questions as $question) {
            if ($question->answers->count() < 2) {
                return redirect()
                    ->route('siswa.dashboard')
                    ->with('error', 'Ada soal yang belum memiliki pilihan jawaban yang cukup.');
            }
        }

        // Gunakan ujian yang belum selesai jika siswa kembali ke ujian yang sama.
        $examResult = ExamResult::where('user_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->whereNull('completed_at')
            ->latest('id')
            ->first();

        if (!$examResult) {
            $examResult = ExamResult::create([
                'user_id' => Auth::id(),
                'subject_id' => $subject->id,
                'total_questions' => $questions->count(),
                'correct_answers' => 0,
                'wrong_answers' => 0,
                'score' => 0,
                'started_at' => now(),
            ]);
        }

        return redirect()->route('siswa.exam.show', $examResult);
    }

    public function showExam(ExamResult $examResult)
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        abort_unless($examResult->user_id === Auth::id(), 403);

        if ($examResult->completed_at) {
            return redirect()->route('siswa.hasil.detail', $examResult);
        }

        $subject = Subject::findOrFail($examResult->subject_id);

        abort_unless($subject->is_active, 404);

        $questions = Question::where('subject_id', $subject->id)
            ->where('is_active', true)
            ->with(['answers' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('option')])
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('error', 'Belum ada soal aktif untuk mata pelajaran ini.');
        }

        return view('siswa.exam', compact('examResult', 'subject', 'questions'));
    }

    public function submitExam(Request $request, ExamResult $examResult)
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        abort_unless($examResult->user_id === Auth::id(), 403);

        if ($examResult->completed_at) {
            return redirect()->route('siswa.hasil.detail', $examResult);
        }

        $data = $request->validate([
            'answers' => ['nullable', 'array'],
            'answers.*' => ['nullable', 'string', 'in:A,B,C,D'],
        ]);

        $answers = $data['answers'] ?? [];

        DB::transaction(function () use ($examResult, $answers) {
            $result = ExamResult::whereKey($examResult->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($result->completed_at) {
                return;
            }

            $questions = Question::where('subject_id', $result->subject_id)
                ->where('is_active', true)
                ->with(['answers' => fn ($query) => $query->where('is_active', true)])
                ->get();

            $totalQuestions = $questions->count();
            $correctCount = 0;
            $wrongCount = 0;
            $totalPossibleScore = 0;
            $earnedScore = 0;

            if ($totalQuestions === 0) {
                abort(422, 'Tidak ada soal aktif untuk ujian ini.');
            }

            foreach ($questions as $question) {
                $totalPossibleScore += max(0, (float) $question->score);

                $selected = $answers[$question->id] ?? null;

                // Jawaban harus benar-benar tersedia pada soal tersebut.
                $validOption = $question->answers->contains(
                    fn ($answer) => $answer->option === $selected
                );

                if (!$validOption) {
                    $selected = null;
                }

                $isCorrect = $selected !== null
                    && $selected === $question->correct_answer;

                if ($isCorrect) {
                    $correctCount++;
                    $earnedScore += max(0, (float) $question->score);
                } else {
                    $wrongCount++;
                }

                ExamResultDetail::create([
                    'exam_result_id' => $result->id,
                    'question_id' => $question->id,
                    'question_text' => $question->title,
                    'student_answer' => $selected,
                    'correct_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect,
                ]);
            }

            $finalScore = $totalPossibleScore > 0
                ? round(($earnedScore / $totalPossibleScore) * 100, 2)
                : 0;

            $result->update([
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctCount,
                'wrong_answers' => $wrongCount,
                'score' => $finalScore,
                'completed_at' => now(),
            ]);
        });

        return redirect()->route('siswa.hasil.detail', $examResult);
    }

    public function history()
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        $results = ExamResult::with('subject')
            ->where('user_id', Auth::id())
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->get();

        return view('siswa.hasil', compact('results'));
    }

    public function showResult(ExamResult $examResult)
    {
        if ($redirect = $this->checkStudent()) {
            return $redirect;
        }

        abort_unless($examResult->user_id === Auth::id(), 403);
        abort_unless($examResult->completed_at, 404);

        $examResult->load(['subject', 'details']);

        return view('siswa.hasil-detail', compact('examResult'));
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('siswa.login');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('siswa.login');
    }
}