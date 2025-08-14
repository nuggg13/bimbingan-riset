@extends('admin.layout')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Jadwal</h1>
            <p class="mt-1 text-sm text-gray-600">Buat jadwal bimbingan riset baru</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <div class="text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Informasi Jadwal</h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-6">
                @csrf
                
                <!-- Pendaftaran Selection -->
                <div>
                    <label for="id_pendaftaran" class="block text-sm font-medium text-gray-700">Pendaftaran <span class="text-red-500">*</span></label>
                    <select name="id_pendaftaran" id="id_pendaftaran" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Pendaftaran</option>
                        @foreach($pendaftaran as $item)
                            <option value="{{ $item->id_pendaftaran }}" {{ old('id_pendaftaran') == $item->id_pendaftaran ? 'selected' : '' }}>
                                {{ $item->peserta->nama ?? 'N/A' }} - {{ Str::limit($item->judul_riset, 50) }}
                            </option>
                        @endforeach
                    </select>
                    @if($pendaftaran->isEmpty())
                        <p class="mt-2 text-sm text-gray-500">Tidak ada pendaftaran yang diterima dan belum memiliki jadwal.</p>
                    @endif
                </div>

                <!-- Mentor Selection -->
                <div>
                    <label for="id_mentor" class="block text-sm font-medium text-gray-700">Mentor <span class="text-red-500">*</span></label>
                    <select name="id_mentor" id="id_mentor" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id_mentor }}" {{ old('id_mentor') == $mentor->id_mentor ? 'selected' : '' }}>
                                {{ $mentor->nama }} - {{ $mentor->keahlian }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required min="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal Akhir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', '09:00') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="jam_akhir" class="block text-sm font-medium text-gray-700">Jam Akhir <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_akhir" id="jam_akhir" value="{{ old('jam_akhir', '17:00') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Status jadwal akan ditentukan otomatis berdasarkan tanggal yang dipilih</li>
                                    <li>Pastikan mentor yang dipilih sesuai dengan keahlian yang dibutuhkan</li>
                                    <li>Tanggal mulai tidak boleh kurang dari hari ini</li>
                                    <li>Tanggal akhir harus setelah tanggal mulai</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalAkhir = document.getElementById('tanggal_akhir');
    const jamMulai = document.getElementById('jam_mulai');
    const jamAkhir = document.getElementById('jam_akhir');

    // Update minimum date for tanggal_akhir when tanggal_mulai changes
    tanggalMulai.addEventListener('change', function() {
        if (this.value) {
            tanggalAkhir.min = this.value;
            
            // If tanggal_akhir is before tanggal_mulai, reset it
            if (tanggalAkhir.value && tanggalAkhir.value <= this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                tanggalAkhir.value = nextDay.toISOString().split('T')[0];
            }
        }
    });

    // Validate time range
    function validateTimeRange() {
        if (jamMulai.value && jamAkhir.value) {
            if (jamAkhir.value <= jamMulai.value) {
                jamAkhir.setCustomValidity('Jam akhir harus setelah jam mulai');
            } else {
                jamAkhir.setCustomValidity('');
            }
        }
    }

    jamMulai.addEventListener('change', validateTimeRange);
    jamAkhir.addEventListener('change', validateTimeRange);

    // Set default tanggal_akhir when tanggal_mulai is selected
    tanggalMulai.addEventListener('change', function() {
        if (this.value && !tanggalAkhir.value) {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + 1); // Default 1 month duration
            tanggalAkhir.value = endDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endpush
@endsection