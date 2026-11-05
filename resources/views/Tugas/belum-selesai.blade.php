@extends('layouts.app')
@section('title', 'Tugas Belum Selesai')
@section('content')
    <h2 class="mb-5 text-2xl font-bold">Daftar Tugas Belum Selesai</h2>

    <div class="space-y-3">
        @forelse ($tugas as $t)
            <div class="flex items-center justify-between gap-4 rounded-2xl bg-white p-5 shadow-md">
                <div class="min-w-0">
                    <div class="truncate font-bold">{{ $t->judul }}</div>
                    <div class="text-xs text-gray-400">
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
                        <button type="submit"
                                class="rounded-lg bg-orange-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-orange-600">
                            Selesai
                        </button>
                    </form>
                    <a href="{{ route('agenda.edit', $t) }}"
                       class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-200">
                        Ubah
                    </a>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border-2 border-dashed border-orange-200 bg-white p-10 text-center text-gray-500">
                Semua tugas sudah selesai. Kerja bagus!
            </div>
        @endforelse
    </div>
@endsection