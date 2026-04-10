<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LegendaryClass - Recuperar Contraseña</title>
    
    <!-- Fonts épicas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Merriweather:wght@300;400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap');
        
        /* Fondo principal */
        .epic-background {
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        /* Overlay súper claro */
        .super-clear-overlay {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.85) 0%,
                rgba(255, 255, 255, 0.75) 25%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0.75) 75%,
                rgba(255, 255, 255, 0.85) 100%
            );
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        
        /* Título súper visible */
        .super-clear-title {
            font-family: 'Cinzel Decorative', serif;
            font-weight: 900;
            font-size: clamp(3rem, 7vw, 6rem);
            background: linear-gradient(45deg, #b45309, #d97706, #f59e0b, #fbbf24);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
            text-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.1),
                0 4px 8px rgba(184, 83, 9, 0.15);
            filter: drop-shadow(0 0 10px rgba(217, 119, 6, 0.3));
        }
        
        /* Subtítulo súper visible */
        .super-clear-subtitle {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: clamp(1.2rem, 3vw, 2rem);
            color: #374151;
            text-align: center;
            text-shadow: 
                0 1px 2px rgba(255, 255, 255, 0.8),
                0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.05em;
            margin-bottom: 3rem;
        }
        
        /* Contenedor centrado */
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }
        
        /* Panel centrado y compacto */
        .compact-panel {
            backdrop-filter: blur(15px);
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 50%,
                rgba(255, 255, 255, 0.95) 100%
            );
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.1),
                0 0 20px rgba(147, 51, 234, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 1);
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Input súper claro */
        .super-clear-input {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(203, 213, 225, 0.6);
            border-radius: 10px;
            color: #1e293b;
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .super-clear-input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.8);
            box-shadow: 
                0 0 15px rgba(59, 130, 246, 0.2),
                0 2px 8px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 1);
        }
        
        .super-clear-input::placeholder {
            color: rgba(100, 116, 139, 0.6);
            font-style: italic;
        }
        
        /* Botón súper claro */
        .super-clear-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            font-family: 'Cinzel', serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(16, 185, 129, 0.3),
                0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .super-clear-button:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 20px rgba(16, 185, 129, 0.4),
                0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Labels súper claros */
        .super-clear-label {
            font-family: 'Cinzel', serif;
            font-weight: 600;
            color: #1f2937;
            text-shadow: none;
        }
        
        /* Enlaces súper claros */
        .super-clear-link {
            font-family: 'Cinzel', serif;
            color: #374151;
            text-decoration: underline;
            text-decoration-color: rgba(59, 130, 246, 0.6);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .super-clear-link:hover {
            color: #1f2937;
            text-decoration-color: rgba(59, 130, 246, 0.9);
        }
        
        /* Status message súper claro */
        .super-clear-status {
            background: rgba(34, 197, 94, 0.08);
            border: 2px solid rgba(34, 197, 94, 0.2);
            border-radius: 12px;
        }
        
        /* Header del panel */
        .panel-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(203, 213, 225, 0.3);
        }
        
        /* Footer súper claro */
        .super-clear-footer {
            position: fixed;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            color: #6b7280;
            font-size: 0.75rem;
            text-align: center;
            font-family: 'Cinzel', serif;
            background: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .super-clear-title {
                font-size: clamp(2rem, 6vw, 4rem);
            }
            
            .super-clear-subtitle {
                font-size: clamp(1rem, 3vw, 1.5rem);
                margin-bottom: 2rem;
            }
            
            .compact-panel {
                max-width: 350px;
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .centered-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- Fondo épico -->
    <div class="epic-background">
        <!-- Overlay súper claro -->
        <div class="super-clear-overlay"></div>
        
        <!-- Contenido centrado -->
        <div class="relative z-10">
            
            <!-- Título principal en la parte superior -->
            <div class="text-center pt-8 pb-4">
                <h1 class="super-clear-title">LEGENDARYCLASS</h1>
                <p class="super-clear-subtitle">🔮 Recuperación de Contraseña 🔮</p>
            </div>
            
            <!-- Contenedor centrado -->
            <div class="centered-container">
                <div class="compact-panel">
                    
                    <!-- Header del panel -->
                    <div class="panel-header">
                        <h3 class="text-xl font-bold super-clear-label mb-2">🗝️ Contraseña Perdida</h3>
                        <p class="text-slate-600 text-sm super-clear-label">
                            Te enviaremos un enlace para recuperar tu acceso
                        </p>
                    </div>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-4 super-clear-status text-green-700 text-sm text-center">
                            <div class="flex items-center justify-center">
                                <span class="text-lg mr-2">✨</span>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 super-clear-label">
                                📧 Email del Aventurero
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="tu.email@aventura.com"
                                   class="super-clear-input w-full px-4 py-3 text-sm" />
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botón -->
                        <button type="submit" 
                                class="super-clear-button w-full py-3 px-4 text-white font-bold text-sm">
                            🔮 Enviar Enlace de Recuperación
                        </button>

                        <!-- Enlaces -->
                        <div class="text-center space-y-3 pt-4">
                            <div class="text-sm text-slate-600">
                                ¿Recordaste tu contraseña? 
                                <a href="{{ route('login') }}" class="super-clear-link">
                                    ⚔️ Iniciar Sesión
                                </a>
                            </div>
                            
                            @if (Route::has('register'))
                                <div class="text-sm text-slate-600">
                                    ¿Nuevo aventurero? 
                                    <a href="{{ route('register') }}" class="super-clear-link">
                                        ✨ Crear cuenta
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer fijo -->
        <div class="super-clear-footer">
            🏰 LegendaryClass - Recuperación v2.0 🏰
        </div>
    </div>
</body>
</html>