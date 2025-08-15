@extends('mentor.layout')

@section('title', 'Tambah Catatan Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('mentor.catatan-bimbingan.index') }}" class="text-green-600 hover:text-green-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tambah Catatan Bimbingan</h1>
                    <p class="text-gray-600 mt-1">Buat catatan bimbingan baru untuk peserta Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('mentor.catatan-bimbingan.store') }}" class="space-y-6">
            @csrf

            <!-- Peserta Selection -->
            <div>
                <label for="id_peserta" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2"></i>Pilih Peserta
                </label>
                <select name="id_peserta" id="id_peserta" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('id_peserta') border-red-500 @enderror">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($peserta as $p)
                        <option value="{{ $p->id_peserta }}" {{ old('id_peserta') == $p->id_peserta ? 'selected' : '' }}>
                            {{ $p->nama }} - {{ $p->instansi }}
                            @if($p->pendaftaran)
                                ({{ $p->pendaftaran->judul_riset }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('id_peserta')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Bimbingan -->
            <div>
                <label for="tanggal_bimbingan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar mr-2"></i>Tanggal Bimbingan
                </label>
                <input type="date" 
                       name="tanggal_bimbingan" 
                       id="tanggal_bimbingan" 
                       value="{{ old('tanggal_bimbingan', date('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('tanggal_bimbingan') border-red-500 @enderror">
                @error('tanggal_bimbingan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hasil Bimbingan -->
            <div>
                <label for="hasil_bimbingan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clipboard-check mr-2"></i>Hasil Bimbingan
                </label>
                <textarea name="hasil_bimbingan" 
                          id="hasil_bimbingan" 
                          rows="4"
                          placeholder="Deskripsikan hasil dari sesi bimbingan ini..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('hasil_bimbingan') border-red-500 @enderror">{{ old('hasil_bimbingan') }}</textarea>
                @error('hasil_bimbingan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tugas Perbaikan -->
            <div>
                <label for="tugas_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tasks mr-2"></i>Tugas Perbaikan
                </label>
                <textarea name="tugas_perbaikan" 
                          id="tugas_perbaikan" 
                          rows="4"
                          placeholder="Berikan tugas atau perbaikan yang harus dilakukan peserta..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('tugas_perbaikan') border-red-500 @enderror">{{ old('tugas_perbaikan') }}</textarea>
                @error('tugas_perbaikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Catatan Tambahan (Opsional)
                </label>
                <textarea name="catatan_tambahan" 
                          id="catatan_tambahan" 
                          rows="3"
                          placeholder="Catatan tambahan atau observasi lainnya..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('catatan_tambahan') border-red-500 @enderror">{{ old('catatan_tambahan') }}</textarea>
                @error('catatan_tambahan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-flag mr-2"></i>Status
                </label>
                <select name="status" id="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                    <option value="reviewed" {{ old('status') == 'reviewed' ? 'selected' : '' }}>Direview</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('mentor.catatan-bimbingan.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg text-sm font-medium transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection