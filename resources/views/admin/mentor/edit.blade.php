@extends('admin.layout')

@section('title', 'Edit Mentor - Admin')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.mentor.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Mentor
        </a>
    </div>
    <div class="mt-4">
        <h2 class="text-2xl font-bold text-gray-900">Edit Mentor</h2>
        <p class="text-gray-600">Edit data mentor: <strong>{{ $mentor->nama }}</strong></p>
    </div>
</div>

@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
            <span class="font-medium">Terjadi kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-user-edit mr-2 text-blue-600"></i>
            Form Edit Mentor
        </h3>
    </div>
    
    <form method="POST" action="{{ route('admin.mentor.update', $mentor->id_mentor) }}" class="px-6 py-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Nama -->
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   value="{{ old('nama', $mentor->nama) }}" 
                   required
                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-300 @enderror"
                   placeholder="Masukkan nama lengkap mentor">
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   value="{{ old('email', $mentor->email) }}" 
                   required
                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror"
                   placeholder="mentor@example.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password Baru
            </label>
            <div class="relative">
                <input type="password" 
                       name="password" 
                       id="password" 
                       minlength="6"
                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror pr-10"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                <button type="button" 
                        onclick="togglePassword('password')" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye" id="password-eye"></i>
                </button>
            </div>
            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter jika diisi.</p>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor WhatsApp -->
        <div>
            <label for="nomor_wa" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor WhatsApp
            </label>
            <input type="text" 
                   name="nomor_wa" 
                   id="nomor_wa" 
                   value="{{ old('nomor_wa', $mentor->nomor_wa) }}" 
                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('nomor_wa') border-red-300 @enderror"
                   placeholder="08123456789 atau +628123456789">
            <p class="mt-1 text-sm text-gray-500">Format: 08123456789 atau +628123456789 (opsional)</p>
            @error('nomor_wa')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Keahlian -->
        <div>
            <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-2">
                Keahlian <span class="text-red-500">*</span>
            </label>
            <textarea name="keahlian" 
                      id="keahlian" 
                      rows="4" 
                      required
                      class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('keahlian') border-red-300 @enderror"
                      placeholder="Deskripsikan keahlian mentor, misalnya: Machine Learning, Data Science, Web Development, Mobile Development, dll.">{{ old('keahlian', $mentor->keahlian) }}</textarea>
            <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
            @error('keahlian')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Info Terakhir Diubah -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Informasi Terakhir</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Dibuat:</span>
                    {{ $mentor->created_at ? $mentor->created_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
                <div>
                    <span class="font-medium">Terakhir diubah:</span>
                    {{ $mentor->updated_at ? $mentor->updated_at->format('d/m/Y H:i') : 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.mentor.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <a href="{{ route('admin.mentor.show', $mentor->id_mentor) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Detail
                </a>
            </div>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                Update Mentor
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Character counter for keahlian
document.addEventListener('DOMContentLoaded', function() {
    const keahlianField = document.getElementById('keahlian');
    if (keahlianField) {
        const maxLength = 500;
        const counter = document.createElement('div');
        counter.className = 'text-sm text-gray-500 mt-1';
        
        function updateCounter() {
            const length = keahlianField.value.length;
            counter.textContent = `${length}/${maxLength} karakter`;
            
            if (length > maxLength) {
                counter.className = 'text-sm text-red-500 mt-1';
            } else if (length > maxLength * 0.9) {
                counter.className = 'text-sm text-yellow-500 mt-1';
            } else {
                counter.className = 'text-sm text-gray-500 mt-1';
            }
        }
        
        // Initial count
        updateCounter();
        keahlianField.parentNode.appendChild(counter);
        
        keahlianField.addEventListener('input', updateCounter);
    }
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...';
        submitBtn.disabled = true;
        
        // Re-enable if form validation fails
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }, 5000);
    });
});
</script>
@endpush