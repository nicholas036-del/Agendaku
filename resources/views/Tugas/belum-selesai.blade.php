@extends('layouts.app')
@section('title', 'Tugas Belum Selesai')
@section('content')
    <h1 class="mb-4 text-xl font-extrabold">Daftar Tugas Belum Selesai</h1>

    <div class="space-y-3">
        @forelse ($tugas as $t)
            <div class="flex items-center justify-between gap-3 rounded-xl border-2 border-black bg-white p-4 shadow-[3px_3px_0_0_#000]">
                <div>
                    <div class="font-bold">{{ $t->judul }}</div>
                    <div class="text-xs text-gray-500">
                        {{ $t->tanggal->translatedFormat('d F Y') }}
                        @if ($t->jam) &middot; {{ substr($t->jam, 0, 5) }} @endif
                    </div>
                    @if ($t->deskripsi)
                        <p class="mt-1 text-sm text-gray-600">{{ $t->deskripsi }}</p>
                    @endif
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <form method="POST" action="{{ route('agenda.toggle', $t) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg bg-green-500 px-3 py-1.5 text-xs font-bold text-white">Selesai</button>
                    </form>
                    <a href="{{ route('agenda.edit', $t) }}" class="rounded-lg bg-gray-200 px-3 py-1.5 text-xs font-bold">Ubah</a>
                </div>
            </div>
        @empty
            <div class="rounded-xl border-2 border-dashed border-gray-400 bg-white p-8 text-center text-gray-500">
                Semua tugas sudah selesai. Kerja bagus!
            </div>
        @endforelse
    </div>
@endsection