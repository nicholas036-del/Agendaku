@extends('layouts.app')
@section('title', 'Tambah Agenda')
@section('content')
    <div class="max-w-md rounded-2xl border-2 border-black bg-white p-6 shadow-[5px_5px_0_0_#000]">
        <h1 class="mb-4 text-xl font-extrabold">Tambah Agenda Baru</h1>

        <form method="POST" action="{{ route('agenda.store') }}" class="space-y-4">
            @csrf
            @include('agenda._form')

            <button type="submit"
                    class="w-full rounded-lg border-2 border-black bg-[#ff6b3d] p-2.5 font-bold text-white shadow-[3px_3px_0_0_#000]">
                Simpan Agenda
            </button>
        </form>
    </div>
@endsection