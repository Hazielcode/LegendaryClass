<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LegendaryClass - Portal de Aventureros</title>
    
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
        
        /* Overlay SÚPER CLARO - casi transparente */
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
        
        /* Contenedor centrado más pequeño */
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
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            font-family: 'Cinzel', serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.3),
                0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .super-clear-button:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 20px rgba(59, 130, 246, 0.4),
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
        
        /* Detección de clase súper clara */
        .super-clear-class-detection {
            background: rgba(34, 197, 94, 0.08);
            border: 2px solid rgba(34, 197, 94, 0.2);
            border-radius: 12px;
            backdrop-filter: blur(5px);
        }
        
        /* Mensaje de error súper claro */
        .super-clear-error {
            background: rgba(239, 68, 68, 0.08);
            border: 2px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            backdrop-filter: blur(5px);
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
                <p class="super-clear-subtitle">⚔️ Portal de Aventureros Legendarios ⚔️</p>
            </div>
            
            <!-- Contenedor centrado -->
            <div class="centered-container">
                <div class="compact-panel">
                    
                    <!-- Header del panel -->
                    <div class="panel-header">
                        <h3 class="text-xl font-bold super-clear-label mb-2">🏰 Portal de Acceso</h3>
                        <p class="text-slate-600 text-sm super-clear-label">
                            Ingresa para comenzar tu aventura
                        </p>
                    </div>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-3 super-clear-status text-green-700 text-sm text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Mensaje de cuenta desactivada - CORREGIDO -->
                    @if($errors->has('email') && strpos($errors->first('email'), 'desactivada') !== false)
                        <div class="mb-4 p-3 super-clear-error">
                            <div class="flex items-center text-red-700">
                                <span class="text-lg mr-2">⚠️</span>
                                <div>
                                    <p class="font-medium text-sm">Acceso Denegado</p>
                                    <p class="text-xs mt-1">{{ $errors->first('email') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5" id="adventureForm">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 super-clear-label">
                                ⚡ Email
                            </label>
                            <div class="relative">
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username"
                                       placeholder="tu.email@aventura.com"
                                       class="super-clear-input w-full px-4 py-3 pr-10 text-sm" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 super-clear-label">
                                🗝️ Contraseña
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Tu contraseña..."
                                       class="super-clear-input w-full px-4 py-3 pr-10 text-sm" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Detección de clase -->
                        <div id="classDetection" class="super-clear-class-detection p-3 hidden">
                            <div class="flex items-center text-green-700">
                                <span class="text-lg mr-2 animate-pulse">🔮</span>
                                <div>
                                    <p class="text-sm font-medium">Clase detectada:</p>
                                    <p id="detectedClass" class="text-xs"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember"
                                   class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                            <label for="remember_me" class="ml-2 text-sm super-clear-label">
                                🔮 Recordarme
                            </label>
                        </div>

                        <!-- Botón -->
                        <button type="submit" 
                                id="adventure-button"
                                class="super-clear-button w-full py-3 px-4 text-white font-bold text-sm">
                            <span id="button-text">⚔️ INICIAR AVENTURA</span>
                        </button>

                        <!-- Enlaces -->
                        <div class="text-center space-y-3 pt-4">
                            @if (Route::has('password.request'))
                                <div>
                                    <a class="super-clear-link text-sm" href="{{ route('password.request') }}">
                                        🌟 ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                            
                            <div class="text-sm text-slate-600">
                                ¿Nuevo aquí? 
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="super-clear-link">
                                        ✨ Crear cuenta
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer fijo -->
        <div class="super-clear-footer">
            🏰 LegendaryClass v2.0 🏰
        </div>
    </div>

    <script>
        // Detectar clase basada en el email (MANTENIDO IGUAL)
        function detectAdventurerClass(email) {
            if (!email) return null;
            
            const emailLower = email.toLowerCase();
            
            if (emailLower.includes('director') || emailLower.includes('admin') || emailLower.includes('principal')) {
                return { class: 'Director', icon: '👑', color: 'text-purple-600' };
            } else if (emailLower.includes('maestro') || emailLower.includes('teacher') || emailLower.includes('profesor') || emailLower.includes('.edu')) {
                return { class: 'Maestro', icon: '🧙‍♂️', color: 'text-blue-600' };
            } else if (emailLower.includes('padre') || emailLower.includes('mama') || emailLower.includes('papa') || emailLower.includes('parent')) {
                return { class: 'Padre', icon: '🛡️', color: 'text-yellow-600' };
            } else {
                return { class: 'Alumno', icon: '⚔️', color: 'text-green-600' };
            }
        }

        // Detectar clase al escribir email (MANTENIDO IGUAL)
        document.getElementById('email').addEventListener('input', function(e) {
            const email = e.target.value;
            const classDetection = document.getElementById('classDetection');
            const detectedClass = document.getElementById('detectedClass');
            
            if (email.length > 5 && email.includes('@')) {
                const adventurerClass = detectAdventurerClass(email);
                
                if (adventurerClass) {
                    detectedClass.innerHTML = `${adventurerClass.icon} <span class="${adventurerClass.color} font-bold">${adventurerClass.class}</span>`;
                    classDetection.classList.remove('hidden');
                }
            } else {
                classDetection.classList.add('hidden');
            }
        });

        // Cambiar texto del botón al enviar (MANTENIDO IGUAL)
        document.getElementById('adventureForm').addEventListener('submit', function(e) {
            const buttonText = document.getElementById('button-text');
            const email = document.getElementById('email').value;
            const adventurerClass = detectAdventurerClass(email);
            
            if (adventurerClass) {
                buttonText.innerHTML = `${adventurerClass.icon} Entrando como ${adventurerClass.class}...`;
            }
        });
    </script>
</body>
</html>