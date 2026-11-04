@php $a = $agenda ?? null; @endphp

<div>
    <label for="judul" class="mb-1 block text-xs font-bold uppercase">Judul</label>
    <input id="judul" type="text" name="judul" value="{{ old('judul', $a?->judul) }}" required
           class="w-full rounded-lg border-2 border-gray-300 bg-gray-50 p-2.5 text-sm focus:border-black focus:outline-none">
    @error('judul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="deskripsi" class="mb-1 block text-xs font-bold uppercase">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"
              class="w-full rounded-lg border-2 border-gray-300 bg-gray-50 p-2.5 text-sm focus:border-black focus:outline-none">{{ old('deskripsi', $a?->deskripsi) }}</textarea>
    @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label for="tanggal" class="mb-1 block text-xs font-bold uppercase">Tanggal</label>
        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $a?->tanggal?->format('Y-m-d')) }}" required
               class="w-full rounded-lg border-2 border-gray-300 bg-gray-50 p-2.5 text-sm focus:border-black focus:outline-none">
        @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="jam" class="mb-1 block text-xs font-bold uppercase">Jam</label>
        <input id="jam" type="time" name="jam" value="{{ old('jam', $a?->jam ? substr($a->jam, 0, 5) : '') }}"
               class="w-full rounded-lg border-2 border-gray-300 bg-gray-50 p-2.5 text-sm focus:border-black focus:outline-none">
        @error('jam') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>