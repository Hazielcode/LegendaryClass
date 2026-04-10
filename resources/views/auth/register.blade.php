<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LegendaryClass - Únete a la Leyenda</title>
    
    <!-- Fonts épicas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
            font-size: clamp(2.5rem, 6vw, 5rem);
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
            font-size: clamp(1rem, 2.5vw, 1.5rem);
            color: #374151;
            text-align: center;
            text-shadow: 
                0 1px 2px rgba(255, 255, 255, 0.8),
                0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.05em;
            margin-bottom: 2rem;
        }
        
        /* Contenedor centrado con scroll */
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 2rem 1rem;
            padding-top: 1rem;
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
            max-width: 450px;
            margin: 0 auto;
            padding: 2rem;
            margin-top: 1rem;
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
        
        /* Select súper claro */
        .super-clear-select {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(203, 213, 225, 0.6);
            border-radius: 10px;
            color: #1e293b;
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .super-clear-select:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.8);
            box-shadow: 
                0 0 15px rgba(59, 130, 246, 0.2),
                0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .super-clear-select option {
            background: #f8fafc;
            color: #1e293b;
            font-weight: 500;
            padding: 8px;
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
        
        /* Campo de código de maestro */
        .teacher-code-field {
            background: rgba(59, 130, 246, 0.08);
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        
        /* Header del panel */
        .panel-header {
            text-align: center;
            margin-bottom: 1.5rem;
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
                font-size: clamp(1.8rem, 5vw, 3rem);
            }
            
            .super-clear-subtitle {
                font-size: clamp(0.9rem, 2.5vw, 1.2rem);
                margin-bottom: 1.5rem;
            }
            
            .compact-panel {
                max-width: 380px;
                padding: 1.5rem;
                margin: 0.5rem;
            }
            
            .centered-container {
                padding: 1rem 0.5rem;
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
            <div class="text-center pt-6 pb-2">
                <h1 class="super-clear-title">LEGENDARYCLASS</h1>
                <p class="super-clear-subtitle">⚔️ Únete a la Leyenda Educativa ⚔️</p>
            </div>
            
            <!-- Contenedor centrado -->
            <div class="centered-container">
                <div class="compact-panel">
                    
                    <!-- Header del panel -->
                    <div class="panel-header">
                        <h3 class="text-xl font-bold super-clear-label mb-2">✨ Crear Cuenta Legendaria</h3>
                        <p class="text-slate-600 text-sm super-clear-label">
                            Completa los datos para comenzar tu aventura
                        </p>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
                        @csrf

                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 super-clear-label">
                                👤 Nombre del Aventurero
                            </label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   placeholder="Tu nombre épico"
                                   class="super-clear-input w-full px-3 py-2.5 text-sm" />
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 super-clear-label">
                                📧 Email Mágico
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username"
                                   placeholder="tu.email@aventura.com"
                                   class="super-clear-input w-full px-3 py-2.5 text-sm" />
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Aventurero -->
                        <div>
                            <label for="role" class="block text-sm font-medium mb-2 super-clear-label">
                                ⚔️ Tipo de Aventurero
                            </label>
                            <select id="role" 
                                    name="role" 
                                    required
                                    class="super-clear-select w-full px-3 py-2.5 text-sm">
                                <option value="" disabled selected>Selecciona tu clase...</option>
                                <option value="student">⚔️ Alumno Aventurero</option>
                                <option value="teacher">🧙‍♂️ Maestro Sabio</option>
                                <option value="parent">🛡️ Padre Guardián</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código de Maestro (oculto por defecto) -->
                        <div id="teacherCodeField" class="teacher-code-field p-4 hidden">
                            <label for="teacher_code" class="block text-sm font-medium mb-2 super-clear-label">
                                🔑 Código de Maestro
                            </label>
                            <input id="teacher_code" 
                                   name="teacher_code" 
                                   type="text" 
                                   placeholder="Ingresa el código secreto de maestro"
                                   class="super-clear-input w-full px-3 py-2.5 text-sm" />
                            <p class="mt-1 text-xs text-blue-600">
                                🔮 Solicita este código al director de tu institución
                            </p>
                            @error('teacher_code')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
    <x-input-label for="role" :value="__('Tipo de Usuario')" />
    <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="student" selected>Estudiante</option>
        <option value="teacher">Profesor</option>
        <option value="parent">Padre de Familia</option>
        <!-- No incluir director/admin por seguridad -->
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 super-clear-label">
                                🗝️ Palabra Mágica
                            </label>
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Crea tu palabra secreta..."
                                   class="super-clear-input w-full px-3 py-2.5 text-sm" />
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-2 super-clear-label">
                                🔒 Confirmar Palabra Mágica
                            </label>
                            <input id="password_confirmation" 
                                   name="password_confirmation" 
                                   type="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Repite tu palabra secreta..."
                                   class="super-clear-input w-full px-3 py-2.5 text-sm" />
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botón -->
                        <button type="submit" 
                                class="super-clear-button w-full py-3 px-4 text-white font-bold text-sm">
                            ✨ Comenzar Aventura Legendaria
                        </button>

                        <!-- Enlaces -->
                        <div class="text-center space-y-2 pt-3">
                            <div class="text-sm text-slate-600">
                                ¿Ya eres un aventurero? 
                                <a href="{{ route('login') }}" class="super-clear-link">
                                    ⚔️ Iniciar Sesión
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer fijo -->
        <div class="super-clear-footer">
            🏰 LegendaryClass - Registro v2.0 🏰
        </div>
    </div>

    <script>
        // Mostrar/ocultar campo de código de maestro
        document.getElementById('role').addEventListener('change', function(e) {
            const teacherCodeField = document.getElementById('teacherCodeField');
            const teacherCodeInput = document.getElementById('teacher_code');
            
            if (e.target.value === 'teacher') {
                teacherCodeField.classList.remove('hidden');
                teacherCodeInput.required = true;
                
                // Efecto visual suave
                setTimeout(() => {
                    teacherCodeField.style.opacity = '0';
                    teacherCodeField.style.transform = 'translateY(-10px)';
                    teacherCodeField.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        teacherCodeField.style.opacity = '1';
                        teacherCodeField.style.transform = 'translateY(0)';
                    }, 50);
                }, 10);
                
            } else {
                teacherCodeField.classList.add('hidden');
                teacherCodeInput.required = false;
                teacherCodeInput.value = '';
            }
            
            // Efecto visual en el select
            e.target.style.borderColor = 'rgba(16, 185, 129, 0.7)';
            setTimeout(() => {
                e.target.style.borderColor = 'rgba(203, 213, 225, 0.6)';
            }, 1000);
        });

        // Validación del código de maestro
        document.getElementById('teacher_code').addEventListener('input', function(e) {
            const code = e.target.value.toUpperCase();
            const validCodes = ['MAESTRO2024', 'TEACHER123', 'EDUCATOR2024', 'LEGENDARY']; // Códigos válidos
            
            if (validCodes.includes(code)) {
                e.target.style.borderColor = 'rgba(34, 197, 94, 0.8)';
                e.target.style.background = 'rgba(34, 197, 94, 0.1)';
            } else if (code.length > 3) {
                e.target.style.borderColor = 'rgba(239, 68, 68, 0.6)';
                e.target.style.background = 'rgba(239, 68, 68, 0.1)';
            } else {
                e.target.style.borderColor = 'rgba(59, 130, 246, 0.8)';
                e.target.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Validación del formulario antes de enviar
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const role = document.getElementById('role').value;
            const teacherCode = document.getElementById('teacher_code').value;
            
            if (role === 'teacher' && !teacherCode) {
                e.preventDefault();
                alert('🔑 Se requiere el código de maestro para registrarse como profesor');
                document.getElementById('teacher_code').focus();
                return false;
            }
            
            if (role === 'teacher') {
                const validCodes = ['MAESTRO2024', 'TEACHER123', 'EDUCATOR2024', 'LEGENDARY'];
                if (!validCodes.includes(teacherCode.toUpperCase())) {
                    e.preventDefault();
                    alert('🚫 Código de maestro inválido. Contacta al director para obtener el código correcto.');
                    document.getElementById('teacher_code').focus();
                    return false;
                }
            }
        });

        // Efecto al escribir en los campos
        const inputs = document.querySelectorAll('.super-clear-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = 'rgba(59, 130, 246, 0.8)';
            });
            
            input.addEventListener('blur', function() {
                this.style.borderColor = 'rgba(203, 213, 225, 0.6)';
            });
        });
    </script>
</body>
</html>