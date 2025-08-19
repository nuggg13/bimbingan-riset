@extends('admin.layout')

@section('title', 'Edit Jadwal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Jadwal</h1>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi jadwal bimbingan riset</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.jadwal.show', $jadwal->id_jadwal) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Informasi Jadwal</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Peserta Info (Read-only) -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Peserta</h4>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $jadwal->pendaftaran->peserta->nama ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($jadwal->pendaftaran->judul_riset ?? 'N/A', 50) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Mentor Selection -->
                        <div>
                            <label for="id_mentor" class="block text-sm font-medium text-gray-700">Mentor <span class="text-red-500">*</span></label>
                            <select name="id_mentor" id="id_mentor" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Mentor</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id_mentor }}" {{ (old('id_mentor', $jadwal->id_mentor) == $mentor->id_mentor) ? 'selected' : '' }}>
                                        {{ $mentor->nama }} - {{ $mentor->keahlian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $jadwal->tanggal_mulai ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_mulai)->format('Y-m-d') : null) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal Akhir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir', $jadwal->tanggal_akhir ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_akhir)->format('Y-m-d') : null) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Time Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai <span class="text-red-500">*</span></label>
                                <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai ? \Illuminate\Support\Carbon::parse($jadwal->jam_mulai)->format('H:i') : null) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="jam_akhir" class="block text-sm font-medium text-gray-700">Jam Akhir <span class="text-red-500">*</span></label>
                                <input type="time" name="jam_akhir" id="jam_akhir" value="{{ old('jam_akhir', $jadwal->jam_akhir ? \Illuminate\Support\Carbon::parse($jadwal->jam_akhir)->format('H:i') : null) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="scheduled" {{ old('status', $jadwal->status) == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="ongoing" {{ old('status', $jadwal->status) == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                <option value="completed" {{ old('status', $jadwal->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ old('status', $jadwal->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
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
                                            <li>Peserta tidak dapat diubah setelah jadwal dibuat</li>
                                            <li>Pastikan mentor yang dipilih sesuai dengan keahlian yang dibutuhkan</li>
                                            <li>Tanggal akhir harus setelah tanggal mulai</li>
                                            <li>Status akan mempengaruhi tampilan di dashboard</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.jadwal.show', $jadwal->id_jadwal) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Info -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Saat Ini</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID Jadwal</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->id_jadwal }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status Saat Ini</dt>
                            <dd class="mt-1">
                                @php
                                    $statusClasses = [
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'ongoing' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusLabels = [
                                        'scheduled' => 'Terjadwal',
                                        'ongoing' => 'Berlangsung',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$jadwal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$jadwal->status] ?? $jadwal->status }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Mentor Saat Ini</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->mentor->nama ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($jadwal->tanggal_akhir)) + 1 }} hari
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diubah</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->updated_at->format('d F Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.jadwal.show', $jadwal->id_jadwal) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium inline-flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Detail
                    </a>
                    <button onclick="deleteJadwal('{{ $jadwal->id_jadwal }}')" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Jadwal
                    </button>
                </div>
            </div>

            <!-- Mentor Info -->
            @if($jadwal->mentor)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Mentor Saat Ini</h3>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 rounded-full bg-green-100 flex items-center justify-center mb-3">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $jadwal->mentor->nama }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $jadwal->mentor->keahlian }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-500 mb-4">Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
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

    // Set initial minimum date for tanggal_akhir
    if (tanggalMulai.value) {
        tanggalAkhir.min = tanggalMulai.value;
    }

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

    // Initial validation
    validateTimeRange();
});

function deleteJadwal(jadwalId) {
    document.getElementById('deleteForm').action = `/admin/jadwal/${jadwalId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush
@endsection