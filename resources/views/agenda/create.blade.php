@extends('layouts.app')
@section('title', 'Tambah Agenda')
@section('content')
    <div class="max-w-lg rounded-2xl bg-white p-8 shadow-xl">
        <h2 class="mb-1 text-2xl font-bold">Tambah Agenda Baru</h2>
        <p class="mb-6 text-sm text-gray-500">Catat tugas atau kegiatan supaya tidak terlewat.</p>

        <form method="POST" action="{{ route('agenda.store') }}" class="space-y-5">
            @csrf
            @include('agenda._form')

            <button type="submit"
                    class="w-full rounded-xl bg-orange-500 py-3.5 font-semibold text-white shadow-md shadow-orange-200 transition hover:bg-orange-600">
                Simpan Agenda
            </button>
        </form>
    </div>
@endsection