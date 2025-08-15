<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mentor - Bimbingan Riset</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Login Mentor</h1>
                <p class="text-gray-600">Masuk ke panel mentor Bimbingan Riset</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('mentor.login.process') }}" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('email') border-red-500 @enderror" 
                           placeholder="mentor@example.com"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('password') border-red-500 @enderror" 
                           placeholder="••••••••"
                           required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-8 text-center space-y-2">
                <div class="text-sm text-gray-600">
                    <a href="{{ route('admin.login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-user-shield mr-1"></i>Login sebagai Admin
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    <a href="{{ route('peserta.login') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                        <i class="fas fa-user-graduate mr-1"></i>Login sebagai Peserta
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    <a href="{{ route('register.step1') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        <i class="fas fa-user-plus mr-1"></i>Daftar sebagai Peserta
                    </a>
                </div>
            </div>
        </div>

        <!-- Demo Credentials -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-4">
            <h3 class="text-sm font-semibold text-gray-800 mb-2">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>Demo Credentials
            </h3>
            <div class="text-xs text-gray-600 space-y-1">
                <p><strong>Email:</strong> ozi@gmail.com</p>
                <p><strong>Password:</strong> password</p>
            </div>
        </div>
    </div>
</body>
</html>