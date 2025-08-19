@extends('admin.layout')

@section('title', 'Detail Jadwal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Jadwal</h1>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap jadwal bimbingan riset</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>
                Edit Jadwal
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Jadwal</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID Jadwal</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->id_jadwal }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
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
                            <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Hari</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($jadwal->hari)
                                    @php
                                        $hariArray = explode(',', $jadwal->hari);
                                        $hariFormatted = array_map(function($hari) { return ucfirst(trim($hari)); }, $hariArray);
                                    @endphp
                                    {{ implode(', ', $hariFormatted) }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Akhir</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($jadwal->tanggal_akhir)->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jam Mulai</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->jam_mulai }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jam Akhir</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->jam_akhir }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($jadwal->tanggal_akhir)) + 1 }} hari
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->created_at->format('d F Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Peserta Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Peserta</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-medium text-gray-900">{{ $jadwal->pendaftaran->peserta->nama ?? 'N/A' }}</h4>
                            <dl class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->peserta->fakultas ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Instansi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->peserta->instansi ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($jadwal->pendaftaran->peserta->nomor_wa)
                                            <a href="https://wa.me/{{ $jadwal->pendaftaran->peserta->nomor_wa }}" target="_blank" class="text-green-600 hover:text-green-800">
                                                {{ $jadwal->pendaftaran->peserta->nomor_wa }}
                                                <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->peserta->email ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Riset</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Judul Riset</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->judul_riset ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Minat Keilmuan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->minat_keilmuan ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Basis Sistem</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->basis_sistem ?? 'N/A' }}</dd>
                        </div>
                        @if($jadwal->pendaftaran->deskripsi_riset)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deskripsi Riset</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $jadwal->pendaftaran->deskripsi_riset }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Mentor Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Mentor</h3>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="mx-auto h-20 w-20 rounded-full bg-green-100 flex items-center justify-center mb-4">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $jadwal->mentor->nama ?? 'N/A' }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $jadwal->mentor->keahlian ?? 'N/A' }}</p>
                        
                        @if($jadwal->mentor->email)
                        <div class="mt-4">
                            <a href="mailto:{{ $jadwal->mentor->email }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                                <i class="fas fa-envelope mr-2"></i>
                                Kirim Email
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <button onclick="updateStatus('{{ $jadwal->id_jadwal }}', '{{ $jadwal->status }}')" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Update Status
                    </button>
                    <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium inline-flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Jadwal
                    </a>
                    <button onclick="deleteJadwal('{{ $jadwal->id_jadwal }}')" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Jadwal
                    </button>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-plus text-white text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Jadwal dibuat</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $jadwal->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if($jadwal->updated_at != $jadwal->created_at)
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-edit text-white text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Jadwal diperbarui</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $jadwal->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            @php
                                                $statusIcons = [
                                                    'scheduled' => 'fas fa-clock text-blue-500',
                                                    'ongoing' => 'fas fa-play text-green-500',
                                                    'completed' => 'fas fa-check text-purple-500',
                                                    'cancelled' => 'fas fa-times text-red-500'
                                                ];
                                            @endphp
                                            <span class="h-8 w-8 rounded-full bg-white flex items-center justify-center ring-8 ring-white border-2 border-gray-300">
                                                <i class="{{ $statusIcons[$jadwal->status] ?? 'fas fa-question text-gray-500' }} text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Status: {{ $statusLabels[$jadwal->status] ?? $jadwal->status }}</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                Sekarang
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status Jadwal</h3>
            <form id="statusForm">
                <div class="mb-4">
                    <label for="newStatus" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select id="newStatus" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="scheduled">Terjadwal</option>
                        <option value="ongoing">Berlangsung</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </form>
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
let currentJadwalId = null;

function updateStatus(jadwalId, currentStatus) {
    currentJadwalId = jadwalId;
    document.getElementById('newStatus').value = currentStatus;
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    currentJadwalId = null;
}

function deleteJadwal(jadwalId) {
    currentJadwalId = jadwalId;
    document.getElementById('deleteForm').action = `/admin/jadwal/${jadwalId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentJadwalId = null;
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentJadwalId) return;
    
    const formData = new FormData(this);
    
    fetch(`/admin/jadwal/${currentJadwalId}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeStatusModal();
            if (data.reload) {
                location.reload();
            }
        } else {
            alert(data.error || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate status');
    });
});

// Close modals when clicking outside
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush
@endsection