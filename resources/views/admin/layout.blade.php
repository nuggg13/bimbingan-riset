<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Bimbingan Riset')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                <div class="ml-3">
                    <p class="text-sm text-gray-500 leading-tight">Panel Admin</p>
                    <h1 class="text-lg font-semibold text-gray-800 leading-tight">Bimbingan Riset</h1>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                    <i class="fas fa-home w-5 mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                    <i class="fas fa-file-signature w-5 mr-3"></i> Pendaftaran
                </a>
                <a href="{{ route('admin.mentor.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.mentor.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                    <i class="fas fa-chalkboard-teacher w-5 mr-3"></i> Mentor
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.jadwal.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i> Jadwal
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-200">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar (mobile) -->
            <div class="md:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                    <span class="ml-2 font-semibold">Admin</span>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-700">Dashboard</a>
                </div>
            </div>

            <!-- Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>


