{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerthh - @yield('title', 'Admin Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        html, body { min-height: 100%; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; background-color: transparent; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 1px;
            height: 1px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #a5d0d9, #b0e4d3);
            border-radius: 10px;
        }
        
        /* Card Hover Effects */
        .dashboard-card {
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Table Row Hover */
        .table-row-hover:hover {
            background: linear-gradient(135deg, #ecfdf5, #e0f2fe);
        }
        
        /* Sidebar Active Link */
        .sidebar-link.active {
            background: linear-gradient(135deg, #06b6d4, #10b981);
            color: white;
        }
        
        .sidebar-link.active i {
            color: white;
        }

        /* Mobile padding adjustments */
        @media (max-width: 1023px) {
            body {
                padding-left: env(safe-area-inset-left);
                padding-right: env(safe-area-inset-right);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-cyan-50 via-white to-emerald-50">
    
    <div class="flex min-h-screen lg:h-screen">
        
        {{-- Sidebar --}}
        @include('layout.sidebar')
        
        {{-- Main Content Area --}}
        <main class="flex-1 overflow-y-auto lg:overflow-y-auto">
            
            {{-- Header --}}
            @include('layout.header')
            
            {{-- Page Content --}}
            <div class="p-4 sm:p-6">
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
