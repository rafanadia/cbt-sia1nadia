<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Ujian | CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">

<header class="bg-white border-b">
    <div class="mx-auto flex max-w-5xl items-center justify-between p-4">
        <h1 class="text-xl font-bold text-blue-700">Riwayat Ujian</h1>
        <a href="{{ route('siswa.dashboard') }}"
           class="text-sm font-semibold text-blue-600">
            Dashboard
        </a>
    </div>
</header>

<main class="mx-auto max-w-5xl p-5 md:p-8">
    <h2 class="mb-2 text-2xl font-bold text-slate-800">
        Hasil Ujian Saya
    </h2>
    <p class="mb-6 text-sm text-slate-500">
        Daftar ujian yang sudah kamu selesaikan.
    </p>

    <div class="overflow-x-auto rounded-xl border bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="p-4">Mata Pelajaran</th>
                    <th class="p-4">Jumlah Soal</th>
                    <th class="p-4">Benar</th>
                    <th class="p-4">Salah</th>
                    <th class="p-4">Nilai</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $result)
                    <tr class="border-t">
                        <td class="p-4 font-medium">{{ $result->subject->name }}</td>
                        <td class="p-4">{{ $result->total_questions }}</td>
                        <td class="p-4 text-green-700">{{ $result->correct_answers }}</td>
                        <td class="p-4 text-red-600">{{ $result->wrong_answers }}</td>
                        <td class="p-4 font-bold">{{ number_format((float) $result->score, 2) }}</td>
                        <td class="p-4">{{ $result->completed_at?->format('d-m-Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('siswa.hasil.detail', $result) }}"
                               class="font-semibold text-blue-600 hover:underline">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-slate-500">
                            Kamu belum menyelesaikan ujian apa pun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

</body>
</html>