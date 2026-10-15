<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">

<header class="bg-white border-b">
    <div class="max-w-6xl mx-auto p-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-blue-700">CBT Siswa</h1>
            <p class="text-xs text-slate-500">Computer Based Test</p>
        </div>

        <form action="{{ route('siswa.logout') }}" method="POST">
            @csrf
            <button class="text-red-600 font-medium">Keluar</button>
        </form>
    </div>
</header>

<main class="max-w-6xl mx-auto p-5 md:p-8">

    @if (session('error'))
        <div class="mb-5 rounded-lg bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <section class="mb-8 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
        <p class="text-blue-100">Selamat datang</p>
        <h2 class="mt-2 text-2xl font-bold">
            Halo, {{ auth()->user()->name }}!
        </h2>
        <p class="mt-2 text-sm text-blue-100">
            Pilih mata pelajaran untuk memulai ujian.
        </p>
    </section>

    <div class="mb-4 flex items-center justify-between gap-3">
        <h2 class="text-xl font-bold text-slate-800">Mata Pelajaran</h2>
        <a href="{{ route('siswa.hasil') }}"
           class="text-sm font-semibold text-blue-600 hover:underline">
            Riwayat nilai →
        </a>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($subjects as $subject)
            <article class="rounded-2xl border bg-white p-5 shadow-sm">
                <div class="mb-3 text-3xl">📚</div>

                <h3 class="text-lg font-bold text-slate-800">
                    {{ $subject->name }}
                </h3>

                <p class="mt-2 min-h-10 text-sm text-slate-500">
                    {{ $subject->description ?: 'Mata pelajaran tersedia.' }}
                </p>

                <a href="{{ route('siswa.exam.start', $subject) }}"
                   class="mt-5 block rounded-lg bg-blue-600 px-4 py-3 text-center font-semibold text-white hover:bg-blue-700">
                    Mulai / Lanjutkan Ujian
                </a>
            </article>
        @empty
            <div class="rounded-xl border border-dashed bg-white p-8 text-center text-slate-500 sm:col-span-2 lg:col-span-3">
                Belum ada mata pelajaran aktif. Silakan hubungi admin.
            </div>
        @endforelse
    </div>

    <section class="mt-10">
        <h2 class="mb-4 text-xl font-bold text-slate-800">Hasil Ujian Terakhir</h2>

        <div class="overflow-x-auto rounded-xl border bg-white">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Nilai</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $result)
                        <tr class="border-t">
                            <td class="p-4">{{ $result->subject->name }}</td>
                            <td class="p-4 font-bold">{{ number_format((float) $result->score, 2) }}</td>
                            <td class="p-4">
                                {{ $result->completed_at?->format('d-m-Y H:i') }}
                            </td>
                            <td class="p-4">
                                <a class="font-semibold text-blue-600 hover:underline"
                                   href="{{ route('siswa.hasil.detail', $result) }}">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-5 text-center text-slate-500">
                                Belum ada ujian yang selesai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>
</body>
</html>