<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bimbingan Riset</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .step-completed {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        .step-inactive {
            background: #e5e7eb;
            color: #6b7280;
        }
        .form-slide {
            min-height: 500px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Pendaftaran Bimbingan Riset</h1>
                <p class="text-gray-600">Bergabunglah dengan program bimbingan riset terbaik</p>
            </div>

            <!-- Progress Indicator -->
            <div class="flex justify-center items-center space-x-4 mb-8">
                <div class="flex items-center">
                    <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold @if(request()->routeIs('register.step1')) step-active @elseif(in_array(request()->route()->getName(), ['register.step2', 'register.success'])) step-completed @else step-inactive @endif">
                        @if(in_array(request()->route()->getName(), ['register.step2', 'register.success']))
                            <i class="fas fa-check"></i>
                        @else
                            1
                        @endif
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700">Data Diri</span>
                </div>
                
                <div class="w-16 h-1 bg-gray-300 rounded">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded transition-all duration-500 @if(in_array(request()->route()->getName(), ['register.step2', 'register.success'])) w-full @else w-0 @endif"></div>
                </div>
                
                <div class="flex items-center">
                    <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold @if(request()->routeIs('register.step2')) step-active @elseif(request()->routeIs('register.success')) step-completed @else step-inactive @endif">
                        @if(request()->routeIs('register.success'))
                            <i class="fas fa-check"></i>
                        @else
                            2
                        @endif
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700">Data Riset</span>
                </div>
                
                <div class="w-16 h-1 bg-gray-300 rounded">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded transition-all duration-500 @if(request()->routeIs('register.success')) w-full @else w-0 @endif"></div>
                </div>
                
                <div class="flex items-center">
                    <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold @if(request()->routeIs('register.success')) step-completed @else step-inactive @endif">
                        @if(request()->routeIs('register.success'))
                            <i class="fas fa-check"></i>
                        @else
                            3
                        @endif
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700">Selesai</span>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                <div class="form-slide p-8">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; 2025 Bimbingan Riset. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>