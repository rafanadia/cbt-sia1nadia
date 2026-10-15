<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian {{ $subject->name }} | CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">

<header class="bg-white border-b">
    <div class="mx-auto max-w-4xl p-4">
        <a href="{{ route('siswa.dashboard') }}"
           class="text-sm font-semibold text-blue-600">
            ← Kembali ke dashboard
        </a>
        <h1 class="mt-2 text-xl font-bold text-slate-800">
            {{ $subject->name }}
        </h1>
        <p class="text-sm text-slate-500">
            Total {{ $questions->count() }} soal
        </p>
    </div>
</header>

<main class="mx-auto max-w-4xl p-4 md:p-6">

    <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
        Periksa kembali jawaban sebelum mengumpulkan. Setelah dikumpulkan, jawaban tidak dapat diubah.
    </div>

    <form id="examForm"
          action="{{ route('siswa.exam.submit', $examResult) }}"
          method="POST">
        @csrf

        @foreach ($questions as $index => $question)
            <section class="mb-5 rounded-2xl border bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-start gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-700">
                        {{ $index + 1 }}
                    </span>

                    <div>
                        <p class="whitespace-pre-line font-semibold leading-7 text-slate-800">
                            {{ $question->title }}
                        </p>
                        <p class="mt-1 text-xs text-slate-400">
                            Bobot: {{ $question->score }} poin
                        </p>
                    </div>
                </div>

                <div class="space-y-3 pl-1 md:pl-12">
                    @foreach ($question->answers as $answer)
                        <label class="flex cursor-pointer items-start gap-3 rounded-lg border p-3 transition hover:border-blue-400 hover:bg-blue-50">
                            <input
                                type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $answer->option }}"
                                class="mt-1 h-4 w-4 accent-blue-600"
                            >

                            <span class="font-semibold text-slate-700">
                                {{ $answer->option }}.
                            </span>

                            <span class="text-slate-700">
                                {{ $answer->answer }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="sticky bottom-0 rounded-xl border bg-white p-4 shadow-lg">
            <p class="mb-3 text-sm text-slate-500">
                Pastikan semua jawaban sudah diperiksa.
            </p>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-600 px-5 py-3 font-bold text-white hover:bg-blue-700"
            >
                Kumpulkan Jawaban
            </button>
        </div>
    </form>
</main>

<script>
document.getElementById('examForm').addEventListener('submit', function (event) {
    if (!confirm('Yakin ingin mengumpulkan jawaban? Setelah dikumpulkan, ujian tidak dapat diulang untuk percobaan ini.')) {
        event.preventDefault();
    }
});
</script>

</body>
</html>