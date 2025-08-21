@extends('mentor.layout')

@section('title', 'Tambah Catatan Bimbingan')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

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
                <div id="hasil_bimbingan_editor" class="bg-white border border-gray-300 rounded-lg @error('hasil_bimbingan') border-red-500 @enderror" style="min-height: 150px;"></div>
                <textarea name="hasil_bimbingan" id="hasil_bimbingan" class="hidden">{{ old('hasil_bimbingan') }}</textarea>
                @error('hasil_bimbingan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tugas Perbaikan -->
            <div>
                <label for="tugas_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tasks mr-2"></i>Tugas Perbaikan
                </label>
                <div id="tugas_perbaikan_editor" class="bg-white border border-gray-300 rounded-lg @error('tugas_perbaikan') border-red-500 @enderror" style="min-height: 150px;"></div>
                <textarea name="tugas_perbaikan" id="tugas_perbaikan" class="hidden">{{ old('tugas_perbaikan') }}</textarea>
                @error('tugas_perbaikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Catatan Tambahan (Opsional)
                </label>
                <div id="catatan_tambahan_editor" class="bg-white border border-gray-300 rounded-lg @error('catatan_tambahan') border-red-500 @enderror" style="min-height: 120px;"></div>
                <textarea name="catatan_tambahan" id="catatan_tambahan" class="hidden">{{ old('catatan_tambahan') }}</textarea>
                @error('catatan_tambahan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-flag mr-2"></i>Status
                </label>
                <input type="text" 
                       name="status" 
                       id="status" 
                       value="{{ old('status', 'published') }}"
                       placeholder="Masukkan status bimbingan..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
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

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit to ensure DOM is fully loaded
    setTimeout(function() {
        // Quill editor configuration
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['link'],
            ['clean']
        ];

        let hasilEditor, tugasEditor, catatanEditor;

        // Check if elements exist before initializing
        if (document.getElementById('hasil_bimbingan_editor')) {
            // Initialize Hasil Bimbingan editor
            hasilEditor = new Quill('#hasil_bimbingan_editor', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Deskripsikan hasil dari sesi bimbingan ini...'
            });

            // Set initial content if there's old data
            const hasilOld = document.getElementById('hasil_bimbingan').value;
            if (hasilOld) {
                hasilEditor.root.innerHTML = hasilOld;
            }

            // Update hidden textarea when content changes
            hasilEditor.on('text-change', function() {
                document.getElementById('hasil_bimbingan').value = hasilEditor.root.innerHTML;
            });
        }

        if (document.getElementById('tugas_perbaikan_editor')) {
            // Initialize Tugas Perbaikan editor
            tugasEditor = new Quill('#tugas_perbaikan_editor', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Berikan tugas atau perbaikan yang harus dilakukan peserta...'
            });

            // Set initial content if there's old data
            const tugasOld = document.getElementById('tugas_perbaikan').value;
            if (tugasOld) {
                tugasEditor.root.innerHTML = tugasOld;
            }

            // Update hidden textarea when content changes
            tugasEditor.on('text-change', function() {
                document.getElementById('tugas_perbaikan').value = tugasEditor.root.innerHTML;
            });
        }

        if (document.getElementById('catatan_tambahan_editor')) {
            // Initialize Catatan Tambahan editor
            catatanEditor = new Quill('#catatan_tambahan_editor', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Catatan tambahan atau observasi lainnya...'
            });

            // Set initial content if there's old data
            const catatanOld = document.getElementById('catatan_tambahan').value;
            if (catatanOld) {
                catatanEditor.root.innerHTML = catatanOld;
            }

            // Update hidden textarea when content changes
            catatanEditor.on('text-change', function() {
                document.getElementById('catatan_tambahan').value = catatanEditor.root.innerHTML;
            });
        }

        // Update hidden textareas when form is submitted (backup)
        document.querySelector('form').addEventListener('submit', function() {
            if (hasilEditor) {
                document.getElementById('hasil_bimbingan').value = hasilEditor.root.innerHTML;
            }
            if (tugasEditor) {
                document.getElementById('tugas_perbaikan').value = tugasEditor.root.innerHTML;
            }
            if (catatanEditor) {
                document.getElementById('catatan_tambahan').value = catatanEditor.root.innerHTML;
            }
        });
    }, 100);
});
</script>
@endpush
@endsection