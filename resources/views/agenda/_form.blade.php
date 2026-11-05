@php $a = $agenda ?? null; @endphp

<div>
    <label for="judul" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Judul</label>
    <input id="judul" type="text" name="judul" value="{{ old('judul', $a?->judul) }}"
           placeholder="Contoh: Tugas Matematika"
           class="w-full rounded-xl border border-gray-200 px-4 py-3 transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-orange-400"
           required>
    @error('judul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="deskripsi" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Catatan tambahan (opsional)"
              class="w-full rounded-xl border border-gray-200 px-4 py-3 transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('deskripsi', $a?->deskripsi) }}</textarea>
    @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="tanggal" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal</label>
        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $a?->tanggal?->format('Y-m-d')) }}"
               class="w-full rounded-xl border border-gray-200 px-4 py-3 transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-orange-400"
               required>
        @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="jam" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Jam</label>
        <input id="jam" type="time" name="jam" value="{{ old('jam', $a?->jam ? substr($a->jam, 0, 5) : '') }}"
               class="w-full rounded-xl border border-gray-200 px-4 py-3 transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-orange-400">
        @error('jam') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>