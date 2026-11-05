@extends('layouts.app')
@section('title', 'Ubah Agenda')
@section('content')
    <div class="max-w-lg rounded-2xl bg-white p-8 shadow-xl">
        <h2 class="mb-6 text-2xl font-bold">Ubah Agenda</h2>

        <form method="POST" action="{{ route('agenda.update', $agenda) }}" class="space-y-5">
            @csrf
            @method('PUT')
            @include('agenda._form')

            <button type="submit"
                    class="w-full rounded-xl bg-orange-500 py-3.5 font-semibold text-white shadow-md shadow-orange-200 transition hover:bg-orange-600">
                Simpan Perubahan
            </button>
        </form>

        <form method="POST" action="{{ route('agenda.destroy', $agenda) }}" class="mt-4"
              onsubmit="return confirm('Hapus agenda ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full text-sm font-semibold text-red-600 hover:underline">
                Hapus agenda
            </button>
        </form>
    </div>
@endsection