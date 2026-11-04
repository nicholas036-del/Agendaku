<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);

        $awal = Carbon::create($tahun, $bulan, 1);
        $offset = $awal->dayOfWeekIso - 1; // Senin = 0
        $jumlahHari = $awal->daysInMonth;

        $agendaPerHari = $request->user()->agendas()
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('jam')
            ->get()
            ->groupBy(fn ($a) => $a->tanggal->day);

        return view('kalender.index', [
            'awal'          => $awal,
            'offset'        => $offset,
            'jumlahHari'    => $jumlahHari,
            'agendaPerHari' => $agendaPerHari,
            'sebelumnya'    => $awal->copy()->subMonth(),
            'berikutnya'    => $awal->copy()->addMonth(),
        ]);
    }
}