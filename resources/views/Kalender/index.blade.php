@extends('layouts.app')
@section('title', 'Kalender')
@section('content')
    <div class="rounded-2xl border-2 border-black bg-white p-5 shadow-[5px_5px_0_0_#000]">
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-xl font-extrabold">{{ $awal->translatedFormat('F Y') }}</h1>
            <div class="flex gap-3 text-sm font-semibold text-[#ff6b3d]">
                <a href="{{ route('kalender', ['bulan' => $sebelumnya->month, 'tahun' => $sebelumnya->year]) }}">&larr; Sebelumnya</a>
                <a href="{{ route('kalender') }}">Hari ini</a>
                <a href="{{ route('kalender', ['bulan' => $berikutnya->month, 'tahun' => $berikutnya->year]) }}">Berikutnya &rarr;</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="grid min-w-[640px] grid-cols-7 gap-2">
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <div class="text-center text-xs font-bold text-gray-500">{{ $h }}</div>
                @endforeach

                @for ($i = 0; $i < $offset; $i++)
                    <div></div>
                @endfor

                @for ($d = 1; $d <= $jumlahHari; $d++)
                    @php
                        $hariIni = $awal->copy()->day($d)->isToday();
                        $daftar = $agendaPerHari->get($d, collect());
                    @endphp
                    <div class="min-h-24 rounded-lg border-2 p-1.5 text-xs
                                {{ $hariIni ? 'border-[#ff6b3d] bg-orange-50' : 'border-gray-200 bg-gray-50' }}">
                        <div class="mb-1 font-bold">{{ $d }}</div>
                        @foreach ($daftar as $a)
                            <a href="{{ route('agenda.edit', $a) }}"
                               class="mb-1 block truncate rounded px-1 py-0.5
                                      {{ $a->selesai ? 'bg-green-100 text-green-800 line-through' : 'bg-blue-100 text-blue-800' }}">
                                {{ $a->judul }}
                            </a>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection