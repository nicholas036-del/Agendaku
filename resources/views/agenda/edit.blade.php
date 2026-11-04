@extends('layouts.app')
@section('title', 'Ubah Agenda')
@section('content')
    <div class="max-w-md rounded-2xl border-2 border-black bg-white p-6 shadow-[5px_5px_0_0_#000]">
        <h1 class="mb-4 text-xl font-extrabold">Ubah Agenda</h1>

        <form method="POST" action="{{ route('agenda.update', $agenda) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @include('agenda._form')

            <button type="submit"
                    class="w-full rounded-lg border-2 border-black bg-[#ff6b3d] p-2.5 font-bold text-white shadow-[3px_3px_0_0_#000]">
                Simpan Perubahan
            </button>
        </form>

        <form method="POST" action="{{ route('agenda.destroy', $agenda) }}" class="mt-3"
              onsubmit="return confirm('Hapus agenda ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full text-sm font-semibold text-red-600 hover:underline">Hapus agenda</button>
        </form>
    </div>
@endsection