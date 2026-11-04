<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Agendaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#faf8f3] text-gray-900">
@php
    $user = auth()->user();
    $dekat = $user->agendas()
        ->where('selesai', false)
        ->whereBetween('tanggal', [today(), today()->addDays(3)])
        ->orderBy('tanggal')
        ->first();

    $menu = [
        ['route' => 'kalender',     'label' => 'Kalender'],
        ['route' => 'tugas.belum',  'label' => 'Tugas Belum Selesai'],
        ['route' => 'agenda.create','label' => 'Tambah Agenda'],
    ];
@endphp

<div class="flex min-h-screen flex-col md:flex-row">
    <aside class="flex w-full flex-col border-b-2 border-black bg-white p-4 md:w-60 md:border-b-0 md:border-r-2">
        <div class="mb-6 flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#ff6b3d] font-bold text-white">A</div>
            <div class="leading-tight">
                <div class="font-bold">Agendaku</div>
                <div class="text-xs text-[#ff6b3d]">Agenda sekolah</div>
            </div>
        </div>

        <nav class="flex flex-1 flex-row gap-2 md:flex-col">
            @foreach ($menu as $m)
                <a href="{{ route($m['route']) }}"
                   class="rounded-lg px-3 py-2 text-sm font-semibold
                          {{ request()->routeIs($m['route']) ? 'bg-[#ff6b3d] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $m['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-4 rounded-lg border-2 border-black p-3">
            <div class="text-sm font-bold">{{ $user->name }}</div>
            <div class="mb-2 text-xs text-gray-500">{{ '@'.$user->username }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full rounded-lg bg-[#ff6b3d] py-1.5 text-sm font-bold text-white hover:opacity-90">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-4 md:p-6">
        @if ($dekat)
            <div class="mb-4 rounded-xl border-2 border-black bg-orange-50 p-3 text-sm shadow-[3px_3px_0_0_#000]">
                <span class="font-bold">Peringatan deadline dekat:</span>
                {{ $dekat->judul }} ({{ $dekat->tanggal->translatedFormat('d F Y') }})
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded-xl border-2 border-black bg-green-100 p-3 text-sm">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>