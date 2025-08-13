<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bimbingan Riset</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .status-pending { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); }
        .status-review { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .status-konsultasi { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .status-ditolak { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .status-diterima { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    </style>
</head>
<body class="bg-gray-50">
    @yield('content')

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