<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AgendaKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        {{-- Logo --}}
        <div class="flex items-center justify-center gap-2 mb-6">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                A
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Agendaku</h1>
                <p class="text-xs text-gray-400 -mt-1">Catatan harian</p>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-1">Buat Akun Baru</h2>
        <p class="text-center text-gray-500 text-sm mb-8">Daftar gratis, hanya butuh satu menit</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Username</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       placeholder="Pilih username" autocomplete="username"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                       required autofocus>
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="nama@email.com" autocomplete="email"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                       required>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Password</label>
                <input id="password" type="password" name="password"
                       placeholder="Minimal 6 karakter" autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                       required>
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Ulangi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       placeholder="Ketik ulang password" autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3.5 rounded-xl transition shadow-md shadow-orange-200">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-orange-500 font-medium hover:underline">Masuk</a>
        </p>
    </div>

</body>
</html>