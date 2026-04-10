<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'LegendaryClass') }} - Portal de Aventureros Legendarios</title>
    <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="//unpkg.com/alpinejs" defer></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        body {
            font-family: 'Playfair Display', serif;
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.85) 0%,
                rgba(255, 255, 255, 0.75) 25%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0.75) 75%,
                rgba(255, 255, 255, 0.85) 100%
            );
            z-index: 0;
            pointer-events: none;
        }
        
        /* Todo el contenido por encima del overlay */
        .app-content {
            position: relative;
            z-index: 1;
        }
        
        /* Contenido principal AJUSTADO A BARRA COMPACTA */
        main {
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 64px);
            padding-top: 0.25rem;
        }
        
        /* ASEGURAR QUE EL CONTENIDO SE VEA */
        .max-w-7xl {
            position: relative;
            z-index: 3;
        }
        
        /* Mensajes de éxito súper claros */
        .success-message {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.1));
            border: 2px solid rgba(34, 197, 94, 0.4);
            border-radius: 16px;
            backdrop-filter: blur(15px);
            color: #15803d;
            font-family: 'Cinzel', serif;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            box-shadow: 
                0 8px 25px rgba(34, 197, 94, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        /* Mensajes de error súper claros */
        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.1));
            border: 2px solid rgba(239, 68, 68, 0.4);
            border-radius: 16px;
            backdrop-filter: blur(15px);
            color: #dc2626;
            font-family: 'Cinzel', serif;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            box-shadow: 
                0 8px 25px rgba(239, 68, 68, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        /* Header súper claro */
        .epic-header {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0.9) 100%
            );
            border-bottom: 3px solid rgba(251, 191, 36, 0.3);
            backdrop-filter: blur(20px);
            box-shadow: 
                0 4px 25px rgba(0, 0, 0, 0.1),
                0 0 20px rgba(217, 119, 6, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            z-index: 10;
        }
        
        .epic-header h2 {
            font-family: 'Cinzel', serif;
            background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(184, 83, 9, 0.1);
            font-weight: 800;
        }
        
        /* NAVEGACIÓN SÚPER CLARA */
        .legendary-nav {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 50%,
                rgba(255, 255, 255, 0.95) 100%
            );
            backdrop-filter: blur(25px);
            border-bottom: 3px solid rgba(184, 83, 9, 0.3);
            box-shadow: 
                0 4px 25px rgba(0, 0, 0, 0.1),
                0 0 20px rgba(217, 119, 6, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            z-index: 50;
        }
        
        .legendary-logo {
            font-family: 'Cinzel Decorative', serif;
            font-weight: 900;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(184, 83, 9, 0.1);
            letter-spacing: 0.05em;
        }
        
        .nav-link {
            font-family: 'Cinzel', serif;
            font-weight: 600;
            color: #374151 !important;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            padding: 0.5rem 1rem;
            text-decoration: none;
        }
        
        .nav-link:hover {
            color: #b45309 !important;
            border-bottom-color: rgba(217, 119, 6, 0.5);
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8), 0 0 8px rgba(217, 119, 6, 0.3);
        }
        
        .nav-link.active {
            color: #b45309 !important;
            border-bottom-color: #d97706;
            background: rgba(217, 119, 6, 0.1);
            border-radius: 8px 8px 0 0;
        }
        
        /* DROPDOWN SÚPER CLARO Y POR DELANTE */
        .dropdown-button {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 100%
            );
            border: 2px solid rgba(203, 213, 225, 0.6);
            border-radius: 12px;
            color: #374151;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            z-index: 60;
            backdrop-filter: blur(15px);
            box-shadow: 
                0 4px 15px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        .dropdown-button:hover {
            border-color: rgba(217, 119, 6, 0.5);
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 1) 0%,
                rgba(255, 255, 255, 0.95) 100%
            );
            box-shadow: 
                0 8px 25px rgba(217, 119, 6, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 1);
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 320px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.98) 0%,
                rgba(255, 255, 255, 0.95) 100%
            );
            backdrop-filter: blur(25px);
            border: 2px solid rgba(217, 119, 6, 0.3);
            border-radius: 20px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 40px rgba(217, 119, 6, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            padding: 1.5rem;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(203, 213, 225, 0.3);
            margin-bottom: 1rem;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-family: 'Cinzel', serif;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(
                135deg,
                rgba(217, 119, 6, 0.1) 0%,
                rgba(245, 158, 11, 0.05) 100%
            );
            color: #b45309;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(217, 119, 6, 0.1);
        }
        
        /* Mobile styles */
        .mobile-menu {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.98) 0%,
                rgba(255, 255, 255, 0.95) 100%
            );
            backdrop-filter: blur(25px);
            border-top: 2px solid rgba(217, 119, 6, 0.3);
            z-index: 40;
        }
        
        .mobile-nav-link {
            display: block;
            padding: 1rem;
            color: #374151;
            text-decoration: none;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            border-bottom: 1px solid rgba(203, 213, 225, 0.2);
            transition: all 0.3s ease;
        }
        
        .mobile-nav-link:hover {
            background: linear-gradient(
                135deg,
                rgba(217, 119, 6, 0.1) 0%,
                rgba(245, 158, 11, 0.05) 100%
            );
            color: #b45309;
        }
    </style>
</head>
<body class="font-sans antialiased">
    
    <div class="app-content min-h-screen">
        @include('layouts.navigation')
        
        @isset($header)
            <header class="epic-header shadow-2xl">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="success-message px-6 py-4 relative" role="alert">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">🎉</span>
                            <div>
                                <span class="font-bold text-lg">¡Éxito Legendario!</span>
                                <p class="mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="error-message px-6 py-4 relative" role="alert">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">⚠️</span>
                            <div>
                                <span class="font-bold text-lg">¡Alerta de Aventurero!</span>
                                <p class="mt-1">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    
    <!-- Scripts épicos -->
    <script>
        // Asegurar que Alpine.js funcione correctamente
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js cargado correctamente');
        });
        
        // Agregar efectos de partículas al hacer scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('body::before');
            if (parallax) {
                const speed = scrolled * 0.1;
            }
        });
        
        // Efecto de entrada para mensajes
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach((message, index) => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    message.style.transition = 'all 0.5s ease';
                    message.style.opacity = '1';
                    message.style.transform = 'translateY(0)';
                }, index * 200);
                
                // Auto-ocultar después de 5 segundos
                setTimeout(() => {
                    message.style.transition = 'all 0.5s ease';
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        if (message.parentNode) {
                            message.parentNode.removeChild(message);
                        }
                    }, 500);
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>