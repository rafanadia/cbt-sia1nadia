<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center text-slate-800">
            Login Siswa
        </h1>
        <p class="text-center text-slate-500 mt-2 mb-6">
            Masuk untuk mengikuti ujian dan melihat hasilmu.
        </p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('siswa.login.submit') }}" method="POST">
            @csrf

            <label class="block text-sm font-medium mb-2">
                Username atau email
            </label>
            <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                required
                autofocus
                class="w-full border rounded-lg p-3 mb-4"
                placeholder="Masukkan username atau email"
            >

            <label class="block text-sm font-medium mb-2">
                Password
            </label>
            <input
                type="password"
                name="password"
                required
                class="w-full border rounded-lg p-3 mb-6"
                placeholder="Masukkan password"
            >

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold p-3 rounded-lg"
            >
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
