<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Agendaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-[#faf8f3] p-4 text-gray-900">
    <div class="w-full max-w-sm rounded-2xl border-2 border-black bg-white p-8 shadow-[5px_5px_0_0_#000]">
        <div class="mb-6 flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#ff6b3d] font-bold text-white">A</div>
            <div class="leading-tight">
                <div class="font-bold">Agendaku</div>
                <div class="text-xs text-[#ff6b3d]">Catat agenda sekolahmu</div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>