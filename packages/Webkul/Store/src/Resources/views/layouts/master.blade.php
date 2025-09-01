{{-- resources/themes/store/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'ar' }}" dir="{{ core()->getCurrentLocale()->direction ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Title --}}
    <title>@yield('page_title', 'متجر') - {{ core()->getCurrentChannel()->name ?? 'Store' }}</title>
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', core()->getCurrentChannel()->description ?? 'متجر إلكتروني رائع')">
    <meta name="keywords" content="@yield('meta_keywords', 'متجر, تسوق, منتجات')">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

    
    {{-- Additional Meta --}}
    @yield('meta')
    
    {{-- Favicon --}}
    @if (core()->getCurrentChannel()->favicon_url ?? false)
        <link rel="icon" sizes="16x16" href="{{ core()->getCurrentChannel()->favicon_url }}" />
    @endif

    @bagistoVite('resources/themes/store/assets/js/app.js')

    {{-- Custom CSS --}}
    <style>
        .store-theme {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .store-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .store-hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            background-position: center;
            color: white;
            min-height: 400px;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .feature-icon {
            transition: transform 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: scale(1.05);
        }
    </style>
    
    {{-- Additional Head Content --}}
    @yield('head')
</head>

<body class="store-theme @yield('body_class')">
    <div id="app">
        {{-- Header --}}
        @include('store::layouts.header')
        
        {{-- Navigation --}}
        @include('store::layouts.navigation')
        
        {{-- Main Content --}}
        <main role="main">
            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                    <div class="container">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                    <div class="container">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif
            
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show m-0" role="alert">
                    <div class="container">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif
            
            {{-- Page Content --}}
            @yield('content')
        </main>
        
        {{-- Footer --}}
        @include('store::layouts.footer')
    </div>

    {{-- JavaScript Assets --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Custom JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Store Theme Loaded Successfully');
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
    
    {{-- Additional Footer Content --}}
    @yield('footer')
</body>
</html>