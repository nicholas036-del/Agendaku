<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function belumSelesai(Request $request)
    {
        $tugas = $request->user()->agendas()
            ->where('selesai', false)
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        return view('tugas.belum-selesai', compact('tugas'));
    }
}