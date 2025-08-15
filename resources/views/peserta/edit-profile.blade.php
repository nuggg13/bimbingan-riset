@extends('peserta.layout')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-blue-600 text-white py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <a href="{{ route('peserta.dashboard') }}" class="mr-4 hover:text-blue-200 transition duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold">Edit Profil</h1>
                    <p class="text-blue-100 mt-2">Perbarui informasi profil Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-semibold">Terjadi kesalahan:</span>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Edit Profile Form -->
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user-edit text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Informasi Profil</h2>
                    <p class="text-gray-600">Perbarui data pribadi dan informasi kontak Anda</p>
                </div>
            </div>

            <form method="POST" action="{{ route('peserta.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-blue-600"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $peserta->nama) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('nama') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1 text-blue-600"></i>
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $peserta->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror"
                               placeholder="Masukkan alamat email"
                               required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label for="nomor_wa" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-whatsapp mr-1 text-green-600"></i>
                            Nomor WhatsApp
                        </label>
                        <input type="text" 
                               id="nomor_wa" 
                               name="nomor_wa" 
                               value="{{ old('nomor_wa', $peserta->nomor_wa) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('nomor_wa') border-red-500 @enderror"
                               placeholder="Contoh: 08123456789"
                               required>
                        @error('nomor_wa')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Format: 08xxxxxxxxxx atau +62xxxxxxxxxx</p>
                    </div>

                    <!-- Instansi -->
                    <div>
                        <label for="instansi" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-university mr-1 text-blue-600"></i>
                            Instansi
                        </label>
                        <input type="text" 
                               id="instansi" 
                               name="instansi" 
                               value="{{ old('instansi', $peserta->instansi) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('instansi') border-red-500 @enderror"
                               placeholder="Nama universitas/institusi"
                               required>
                        @error('instansi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fakultas -->
                    <div class="md:col-span-2">
                        <label for="fakultas" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-graduation-cap mr-1 text-blue-600"></i>
                            Fakultas/Jurusan
                        </label>
                        <input type="text" 
                               id="fakultas" 
                               name="fakultas" 
                               value="{{ old('fakultas', $peserta->fakultas) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('fakultas') border-red-500 @enderror"
                               placeholder="Nama fakultas atau jurusan"
                               required>
                        @error('fakultas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>
                        Ubah Password (Opsional)
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="Masukkan password baru">
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('peserta.dashboard') }}" 
                       class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center text-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Profile Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-8">
            <h3 class="text-lg font-semibold text-blue-800 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Informasi Penting
            </h3>
            <div class="space-y-2 text-sm text-blue-700">
                <p><i class="fas fa-check mr-2"></i>Pastikan email yang digunakan masih aktif untuk menerima notifikasi</p>
                <p><i class="fas fa-check mr-2"></i>Nomor WhatsApp akan digunakan untuk komunikasi dengan mentor</p>
                <p><i class="fas fa-check mr-2"></i>Password minimal 8 karakter untuk keamanan akun</p>
                <p><i class="fas fa-check mr-2"></i>Data yang diubah akan langsung tersimpan setelah menekan tombol simpan</p>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-format WhatsApp number
document.getElementById('nomor_wa').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    
    // Format Indonesian phone number
    if (value.startsWith('62')) {
        value = '+' + value;
    } else if (value.startsWith('0')) {
        // Keep as is for 08xx format
    } else if (value.length > 0) {
        value = '0' + value;
    }
    
    e.target.value = value;
});

// Password strength indicator
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = getPasswordStrength(password);
    
    // You can add visual feedback here if needed
});

function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endsection