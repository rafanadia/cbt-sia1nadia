<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Hasil Ujian | CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">

<header class="bg-white border-b">
    <div class="mx-auto flex max-w-4xl items-center justify-between p-4">
        <h1 class="text-xl font-bold text-blue-700">Detail Hasil Ujian</h1>
        <a href="{{ route('siswa.dashboard') }}"
           class="text-sm font-semibold text-blue-600">
            Dashboard
        </a>
    </div>
</header>

<main class="mx-auto max-w-4xl p-5 md:p-8">

    <section class="rounded-2xl bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Mata Pelajaran</p>
        <h2 class="mt-1 text-2xl font-bold text-slate-800">
            {{ $examResult->subject->name }}
        </h2>

        <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="rounded-xl bg-blue-50 p-4">
                <p class="text-xs text-blue-700">Nilai</p>
                <p class="mt-1 text-2xl font-bold text-blue-800">
                    {{ number_format((float) $examResult->score, 2) }}
                </p>
            </div>

            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-xs text-slate-500">Total Soal</p>
                <p class="mt-1 text-2xl font-bold">{{ $examResult->total_questions }}</p>
            </div>

            <div class="rounded-xl bg-green-50 p-4">
                <p class="text-xs text-green-700">Benar</p>
                <p class="mt-1 text-2xl font-bold text-green-800">{{ $examResult->correct_answers }}</p>
            </div>

            <div class="rounded-xl bg-red-50 p-4">
                <p class="text-xs text-red-700">Salah</p>
                <p class="mt-1 text-2xl font-bold text-red-800">{{ $examResult->wrong_answers }}</p>
            </div>
        </div>

        <p class="mt-5 text-sm text-slate-500">
            Selesai:
            {{ $examResult->completed_at?->format('d F Y, H:i') }}
        </p>
    </section>

    <h2 class="mb-4 mt-8 text-xl font-bold text-slate-800">
        Rincian Jawaban
    </h2>

    @foreach ($examResult->details as $index => $detail)
        <article class="mb-4 rounded-xl border bg-white p-5">
            <div class="flex items-start justify-between gap-3">
                <h3 class="font-semibold leading-7 text-slate-800">
                    {{ $index + 1 }}. {{ $detail->question_text }}
                </h3>

                <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold
                    {{ $detail->is_correct ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $detail->is_correct ? 'Benar' : 'Salah' }}
                </span>
            </div>

            <div class="mt-4 space-y-2 text-sm">
                <p>
                    <span class="text-slate-500">Jawaban kamu:</span>
                    <strong>{{ $detail->student_answer ?? 'Tidak dijawab' }}</strong>
                </p>

                <p>
                    <span class="text-slate-500">Jawaban benar:</span>
                    <strong class="text-green-700">{{ $detail->correct_answer }}</strong>
                </p>
            </div>
        </article>
    @endforeach

    <a href="{{ route('siswa.hasil') }}"
       class="mt-3 inline-block font-semibold text-blue-600 hover:underline">
        ← Kembali ke riwayat
    </a>

</main>
</body>
</html>