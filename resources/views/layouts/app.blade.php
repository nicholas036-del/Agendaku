<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - AgendaKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); }
    </style>
</head>
<body class="min-h-screen text-gray-800">
@php
    $user = auth()->user();

    $dekat = $user->agendas()
        ->where('selesai', false)
        ->whereBetween('tanggal', [today(), today()->addDays(3)])
        ->orderBy('tanggal')
        ->first();

    $menu = [
        ['route' => 'kalender',      'label' => 'Kalender', 'icon' => 'fa-solid fa-calendar-days'],
        ['route' => 'tugas.belum',   'label' => 'Tugas Belum Selesai', 'icon' => 'fa-solid fa-list-check'],
        ['route' => 'agenda.create', 'label' => 'Tambah Agenda', 'icon' => 'fa-solid fa-circle-plus'],
    ];
@endphp

<div class="flex min-h-screen flex-col md:flex-row">
    {{-- Sidebar --}}
    <aside class="flex w-full flex-col bg-white p-5 shadow-xl md:w-64">
        <div class="mb-8 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500 text-xl font-bold text-white shadow-md shadow-orange-200">A</div>
            <div>
                <h1 class="text-xl font-bold">Agendaku</h1>
                <p class="-mt-1 text-xs text-gray-400">Class & Life Sync</p>
            </div>
        </div>

        <nav class="flex flex-1 flex-row gap-2 overflow-x-auto md:flex-col">
            @foreach ($menu as $m)
                <a href="{{ route($m['route']) }}"
                   class="flex items-center gap-3 whitespace-nowrap rounded-xl px-4 py-2.5 text-sm font-semibold transition
                          {{ request()->routeIs($m['route']) ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'text-gray-600 hover:bg-orange-50' }}">
                    <i class="{{ $m['icon'] }} w-5 text-center"></i>
                    <span>{{ $m['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-6 rounded-xl border border-gray-200 p-3 bg-gray-50/50">
            <div class="text-sm font-bold">{{ $user->name }}</div>
            <div class="mb-3 truncate text-xs text-gray-400">{{ $user->email }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-orange-500 py-2 text-sm font-semibold text-white transition hover:bg-orange-600 shadow-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Konten --}}
    <main class="flex-1 p-4 md:p-8">
        @if ($dekat)
            <div class="mb-4 flex items-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3 text-sm text-orange-800 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-orange-500"></i>
                <div>
                    <span class="font-bold">Pengingat deadline:</span>
                    {{ $dekat->judul }} ({{ $dekat->tanggal->translatedFormat('d F Y') }})
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>