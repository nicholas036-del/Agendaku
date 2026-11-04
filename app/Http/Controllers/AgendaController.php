<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->agendas()->create($this->validated($request));

        return redirect()->route('kalender')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Request $request, Agenda $agenda)
    {
        $this->pastikanMilik($request, $agenda);

        return view('agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $this->pastikanMilik($request, $agenda);
        $agenda->update($this->validated($request));

        return redirect()->route('tugas.belum')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Request $request, Agenda $agenda): RedirectResponse
    {
        $this->pastikanMilik($request, $agenda);
        $agenda->delete();

        return back()->with('success', 'Agenda dihapus.');
    }

    public function toggle(Request $request, Agenda $agenda): RedirectResponse
    {
        $this->pastikanMilik($request, $agenda);
        $agenda->update(['selesai' => ! $agenda->selesai]);

        return back()->with('success', 'Status agenda diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul'     => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'tanggal'   => ['required', 'date'],
            'jam'       => ['nullable', 'date_format:H:i'],
        ]);
    }

    private function pastikanMilik(Request $request, Agenda $agenda): void
    {
        abort_unless($agenda->user_id === $request->user()->id, 403);
    }
}