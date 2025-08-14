@extends('registration.layout')

@section('title', 'Langkah 2 - Data Riset')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Informasi Riset</h2>
        <p class="text-gray-600">Ceritakan tentang riset yang ingin Anda kembangkan</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 alert-auto-hide">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 alert-auto-hide">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register.step2.process') }}" class="space-y-6">
        @csrf
        
        <!-- Judul Riset -->
        <div>
            <label for="judul_riset" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lightbulb text-gray-400 mr-2"></i>Judul Riset
            </label>
            <input type="text" id="judul_riset" name="judul_riset" value="{{ old('judul_riset') }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                placeholder="Masukkan judul riset yang ingin dikembangkan">
        </div>

        <!-- Penjelasan -->
        <div>
            <label for="penjelasan" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-file-alt text-gray-400 mr-2"></i>Penjelasan Riset
            </label>
            <textarea id="penjelasan" name="penjelasan" rows="4" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-none"
                placeholder="Jelaskan secara singkat tentang riset yang ingin Anda kembangkan, tujuan, dan manfaatnya">{{ old('penjelasan') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Minat Keilmuan -->
            <div>
                <label for="minat_keilmuan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-brain text-gray-400 mr-2"></i>Minat Keilmuan
                </label>
                <select id="minat_keilmuan" name="minat_keilmuan" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    onchange="toggleCustomField('minat_keilmuan', 'custom_minat_keilmuan')">
                    <option value="">Pilih minat keilmuan</option>
                    <option value="Artificial Intelligence" {{ old('minat_keilmuan') == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>
                    <option value="Machine Learning" {{ old('minat_keilmuan') == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
                    <option value="Data Science" {{ old('minat_keilmuan') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    <option value="Web Development" {{ old('minat_keilmuan') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                    <option value="Mobile Development" {{ old('minat_keilmuan') == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                    <option value="Cybersecurity" {{ old('minat_keilmuan') == 'Cybersecurity' ? 'selected' : '' }}>Cybersecurity</option>
                    <option value="Internet of Things" {{ old('minat_keilmuan') == 'Internet of Things' ? 'selected' : '' }}>Internet of Things</option>
                    <option value="Blockchain" {{ old('minat_keilmuan') == 'Blockchain' ? 'selected' : '' }}>Blockchain</option>
                    <option value="Computer Vision" {{ old('minat_keilmuan') == 'Computer Vision' ? 'selected' : '' }}>Computer Vision</option>
                    <option value="Natural Language Processing" {{ old('minat_keilmuan') == 'Natural Language Processing' ? 'selected' : '' }}>Natural Language Processing</option>
                    <option value="Lainnya" {{ old('minat_keilmuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                
                <!-- Custom Minat Keilmuan Field -->
                <div id="custom_minat_keilmuan" class="mt-3 {{ old('minat_keilmuan') == 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" name="custom_minat_keilmuan" value="{{ old('custom_minat_keilmuan') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="Sebutkan minat keilmuan Anda">
                </div>
            </div>

            <!-- Basis Sistem -->
            <div>
                <label for="basis_sistem" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-cogs text-gray-400 mr-2"></i>Basis Sistem
                </label>
                <select id="basis_sistem" name="basis_sistem" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    onchange="toggleCustomField('basis_sistem', 'custom_basis_sistem')">
                    <option value="">Pilih basis sistem</option>
                    <option value="Web Application" {{ old('basis_sistem') == 'Web Application' ? 'selected' : '' }}>Web Application</option>
                    <option value="Mobile Application" {{ old('basis_sistem') == 'Mobile Application' ? 'selected' : '' }}>Mobile Application</option>
                    <option value="Desktop Application" {{ old('basis_sistem') == 'Desktop Application' ? 'selected' : '' }}>Desktop Application</option>
                    <option value="API/Backend System" {{ old('basis_sistem') == 'API/Backend System' ? 'selected' : '' }}>API/Backend System</option>
                    <option value="Machine Learning Model" {{ old('basis_sistem') == 'Machine Learning Model' ? 'selected' : '' }}>Machine Learning Model</option>
                    <option value="IoT System" {{ old('basis_sistem') == 'IoT System' ? 'selected' : '' }}>IoT System</option>
                    <option value="Embedded System" {{ old('basis_sistem') == 'Embedded System' ? 'selected' : '' }}>Embedded System</option>
                    <option value="Cloud Computing" {{ old('basis_sistem') == 'Cloud Computing' ? 'selected' : '' }}>Cloud Computing</option>
                    <option value="Lainnya" {{ old('basis_sistem') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                
                <!-- Custom Basis Sistem Field -->
                <div id="custom_basis_sistem" class="mt-3 {{ old('basis_sistem') == 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" name="custom_basis_sistem" value="{{ old('custom_basis_sistem') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                        placeholder="Sebutkan basis sistem Anda">
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('register.step1') }}" 
                class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105 transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            
            <button type="submit" 
                class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition duration-200 flex items-center">
                Selesaikan Pendaftaran
                <i class="fas fa-check ml-2"></i>
            </button>
        </div>
    </form>
</div>

<script>
function toggleCustomField(selectId, customFieldId) {
    const select = document.getElementById(selectId);
    const customField = document.getElementById(customFieldId);
    const customInput = customField.querySelector('input');
    
    if (select.value === 'Lainnya') {
        customField.classList.remove('hidden');
        customInput.required = true;
    } else {
        customField.classList.add('hidden');
        customInput.required = false;
        customInput.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomField('minat_keilmuan', 'custom_minat_keilmuan');
    toggleCustomField('basis_sistem', 'custom_basis_sistem');
});
</script>
@endsection