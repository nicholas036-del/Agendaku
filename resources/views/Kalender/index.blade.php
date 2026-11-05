@extends('layouts.app')
@section('title', 'Kalender')
@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-xl">
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl font-bold">{{ $awal->translatedFormat('F Y') }}</h2>

            <div class="flex items-center gap-3 text-sm font-semibold">
                <a href="{{ route('kalender', ['bulan' => $sebelumnya->month, 'tahun' => $sebelumnya->year]) }}"
                   class="rounded-lg px-3 py-1.5 text-orange-500 hover:bg-orange-50">&larr; Sebelumnya</a>
                <a href="{{ route('kalender') }}"
                   class="rounded-lg bg-orange-500 px-3 py-1.5 text-white hover:bg-orange-600">Hari ini</a>
                <a href="{{ route('kalender', ['bulan' => $berikutnya->month, 'tahun' => $berikutnya->year]) }}"
                   class="rounded-lg px-3 py-1.5 text-orange-500 hover:bg-orange-50">Berikutnya &rarr;</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="grid min-w-[680px] grid-cols-7 gap-2">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <div class="pb-1 text-center text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $h }}</div>
                @endforeach

                @for ($i = 0; $i < $offset; $i++)
                    <div></div>
                @endfor

                @for ($d = 1; $d <= $jumlahHari; $d++)
                    @php
                        $hariIni = $awal->copy()->day($d)->isToday();
                        $daftar  = $agendaPerHari->get($d, collect());
                    @endphp

                    <div class="min-h-24 rounded-xl border p-2 text-xs
                                {{ $hariIni ? 'border-orange-400 bg-orange-50' : 'border-gray-100 bg-gray-50' }}">
                        <div class="mb-1 flex items-center justify-between">
                            <span class="font-bold {{ $hariIni ? 'text-orange-600' : 'text-gray-600' }}">{{ $d }}</span>
                        </div>

                        @foreach ($daftar as $a)
                            <a href="{{ route('agenda.edit', $a) }}"
                               class="mb-1 block truncate rounded-md px-1.5 py-0.5 font-medium
                                      {{ $a->selesai ? 'bg-green-100 text-green-700 line-through' : 'bg-orange-100 text-orange-700' }}">
                                {{ $a->judul }}
                            </a>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>

        <p class="mt-4 text-xs text-gray-400">
            Klik agenda untuk mengubah, atau pilih <span class="font-semibold text-orange-500">Tambah Agenda</span> di menu kiri.
        </p>
    </div>
@endsection