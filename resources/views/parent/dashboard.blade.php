{{-- 
UBICACIÓN: resources/views/parent/dashboard.blade.php 
ACCIÓN: CREAR NUEVO O REEMPLAZAR
--}}

<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 -mx-6 -mt-6 px-6 pt-6 pb-4">
            <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600" style="font-family: 'Cinzel', serif;">
                🛡️ GUARDIÁN {{ strtoupper(auth()->user()->name) }} - PROTECTOR DE AVENTUREROS
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
        
        /* Fondo épico para padres */
        .guardian-background {
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        .guardian-overlay {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.88) 0%,
                rgba(245, 158, 11, 0.05) 25%,
                rgba(255, 255, 255, 0.85) 50%,
                rgba(245, 158, 11, 0.05) 75%,
                rgba(255, 255, 255, 0.88) 100%
            );
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        
        /* Cards de guardián súper claras */
        .guardian-card {
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
                0 0 20px rgba(245, 158, 11, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .guardian-card:hover {
            transform: translateY(-4px);
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.15),
                0 0 30px rgba(245, 158, 11, 0.2);
            border-color: rgba(245, 158, 11, 0.4);
        }
        
        .guardian-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #1f2937;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
        }

        /* Avatar del hijo */
        .child-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(245, 158, 11, 0.6);
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.9), 
                rgba(245, 158, 11, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 1rem;
            position: relative;
            box-shadow: 
                0 4px 15px rgba(245, 158, 11, 0.2),
                inset 0 2px 4px rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .child-level {
            position: absolute;
            bottom: -3px;
            right: -3px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-family: 'Cinzel', serif;
            border: 2px solid rgba(255, 255, 255, 0.9);
            font-size: 0.7rem;
        }

        /* Progreso del hijo */
        .child-progress {
            background: rgba(229, 231, 235, 0.8);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .child-progress-fill {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        /* Botones de guardián */
        .guardian-button {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-family: 'Cinzel', serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .guardian-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }

        .guardian-button.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .guardian-button.green:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .guardian-button.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .guardian-button.blue:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        /* Card de hijo */
        .child-card {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.8) 100%
            );
            border: 2px solid rgba(245, 158, 11, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .child-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2);
            border-color: rgba(245, 158, 11, 0.5);
        }

        /* Estadísticas del hijo */
        .child-stat {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(245, 158, 11, 0.2);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .child-stat:hover {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .child-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .child-level {
                width: 20px;
                height: 20px;
                font-size: 0.6rem;
            }
            
            .guardian-card {
                margin: 0.5rem;
                padding: 1rem;
            }
        }
    </style>

    <div class="guardian-background">
        <!-- Overlay guardián -->
        <div class="guardian-overlay"></div>
        
        <!-- Contenido principal -->
        <div class="relative z-10 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-6">
                
                <!-- Título del guardián -->
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold guardian-title mb-4" style="font-family: 'Cinzel Decorative', serif;">
                        🛡️ GUARDIÁN PROTECTOR 🛡️
                    </h1>
                    <p class="text-2xl guardian-title">Vigilante de los Pequeños Aventureros</p>
                </div>

                <!-- Panel de vinculación si no tiene hijos -->
                @if(empty($children) || count($children) == 0)
                    <div class="guardian-card p-12 mb-8 text-center">
                        <div class="text-8xl mb-6">👨‍👩‍👧‍👦</div>
                        <h2 class="text-3xl font-bold guardian-title mb-4">¡Conecta con tus Pequeños Aventureros!</h2>
                        <p class="text-gray-600 mb-8 text-lg">
                            Para comenzar a seguir el progreso de tus hijos, necesitas vincular sus cuentas con la tuya.
                        </p>
                        
                        <!-- Formulario de vinculación -->
                        <div class="max-w-md mx-auto">
                            <form action="{{ route('parent.link-child') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-left font-semibold guardian-title mb-2">
                                        📧 Email del Aventurero
                                    </label>
                                    <input type="email" 
                                           name="child_email" 
                                           required
                                           placeholder="email.del.hijo@ejemplo.com"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-yellow-500 focus:outline-none">
                                </div>
                                <button type="submit" class="guardian-button w-full">
                                    🔗 Vincular Pequeño Aventurero
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Lista de hijos aventureros -->
                @if(!empty($children) && count($children) > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                        @foreach($children as $child)
                            <div class="guardian-card p-8">
                                <div class="flex items-center mb-6">
                                    <div class="child-avatar">
                                        {{ $child->character_icon ?? '⚔️' }}
                                        <div class="child-level">{{ $child->level ?? 1 }}</div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold guardian-title">{{ $child->name }}</h3>
                                        <p class="text-gray-600">{{ $child->character_class ?? 'Aventurero' }}</p>
                                        <div class="child-progress">
                                            <div class="child-progress-fill" 
                                                 style="width: {{ min(100, (($child->experience_points ?? 0) / (($child->level ?? 1) * 100)) * 100) }}%"></div>
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $child->experience_points ?? 0 }} / {{ ($child->level ?? 1) * 100 }} XP
                                        </div>
                                    </div>
                                </div>

                                <!-- Estadísticas del hijo -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                                    <div class="child-stat">
                                        <div class="text-2xl mb-1">🏆</div>
                                        <div class="font-bold text-lg">{{ $child->achievements_count ?? 0 }}</div>
                                        <div class="text-xs text-gray-600">Logros</div>
                                    </div>
                                    <div class="child-stat">
                                        <div class="text-2xl mb-1">⭐</div>
                                        <div class="font-bold text-lg">{{ $child->positive_points ?? 0 }}</div>
                                        <div class="text-xs text-gray-600">Puntos +</div>
                                    </div>
                                    <div class="child-stat">
                                        <div class="text-2xl mb-1">🗡️</div>
                                        <div class="font-bold text-lg">{{ $child->quests_completed ?? 0 }}</div>
                                        <div class="text-xs text-gray-600">Misiones</div>
                                    </div>
                                    <div class="child-stat">
                                        <div class="text-2xl mb-1">🎁</div>
                                        <div class="font-bold text-lg">{{ $child->rewards_earned ?? 0 }}</div>
                                        <div class="text-xs text-gray-600">Premios</div>
                                    </div>
                                </div>

                                <!-- Acciones para el hijo -->
                                <div class="flex space-x-3">
                                    <a href="{{ route('parent.child.progress', $child->id) }}" 
                                       class="guardian-button blue flex-1 text-center">
                                        📊 Ver Progreso
                                    </a>
                                    <a href="{{ route('parent.child.progress', $child->id) }}" 
                                       class="guardian-button green flex-1 text-center">
                                        💬 Comunicar
                                    </a>
                                </div>

                                <!-- Botón para desvincular (con confirmación) -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <form action="{{ route('parent.unlink-child', $child->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de que quieres desvincular a {{ $child->name }}?')"
                                          class="text-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm text-red-600 hover:text-red-800 underline">
                                            🔗 Desvincular aventurero
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Panel de vinculación adicional -->
                @if(!empty($children) && count($children) > 0)
                    <div class="guardian-card p-8 mb-8">
                        <h3 class="text-2xl font-bold guardian-title mb-6 flex items-center">
                            <span class="text-3xl mr-3">➕</span>
                            Agregar Otro Pequeño Aventurero
                        </h3>
                        <div class="max-w-md">
                            <form action="{{ route('parent.link-child') }}" method="POST" class="flex space-x-4">
                                @csrf
                                <input type="email" 
                                       name="child_email" 
                                       required
                                       placeholder="email.del.hijo@ejemplo.com"
                                       class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-yellow-500 focus:outline-none">
                                <button type="submit" class="guardian-button">
                                    🔗 Vincular
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Resumen de todas las aulas -->
                @if(!empty($classrooms) && count($classrooms) > 0)
                    <div class="guardian-card p-8 mb-8">
                        <h3 class="text-2xl font-bold guardian-title mb-6 flex items-center">
                            <span class="text-3xl mr-3">🏰</span>
                            Dominios de los Aventureros
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($classrooms as $classroom)
                                <div class="child-card">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="font-bold guardian-title">{{ $classroom->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $classroom->teacher->name ?? 'Sin maestro' }}</p>
                                        </div>
                                        <div class="text-2xl">🏰</div>
                                    </div>
                                    <div class="text-sm text-gray-500 mb-3">
                                        {{ $classroom->students_count ?? 0 }} aventureros en total
                                    </div>
                                    <a href="{{ route('parent.classroom.view', $classroom->id) }}" 
                                       class="guardian-button blue w-full text-center text-sm py-2">
                                        Ver Aula
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Comunicación con maestros -->
                @if(!empty($children) && count($children) > 0)
                    <div class="guardian-card p-8 mb-8">
                        <h3 class="text-2xl font-bold guardian-title mb-6 flex items-center">
                            <span class="text-3xl mr-3">📬</span>
                            Comunicación con Maestros Sabios
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="child-card">
                                <h4 class="font-bold guardian-title mb-3">📨 Enviar Mensaje</h4>
                                <p class="text-gray-600 mb-4">Comunícate directamente con los maestros de tus hijos.</p>
                                <button class="guardian-button green w-full">
                                    ✉️ Nuevo Mensaje
                                </button>
                            </div>
                            <div class="child-card">
                                <h4 class="font-bold guardian-title mb-3">📋 Reportes Semanales</h4>
                                <p class="text-gray-600 mb-4">Recibe reportes automáticos del progreso de tus hijos.</p>
                                <button class="guardian-button blue w-full">
                                    📊 Ver Reportes
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Consejos para padres -->
                <div class="guardian-card p-8">
                    <h3 class="text-2xl font-bold guardian-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">💡</span>
                        Consejos para Guardianes Legendarios
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="child-card text-center">
                            <div class="text-4xl mb-3">🌟</div>
                            <h4 class="font-bold guardian-title mb-2">Celebra los Logros</h4>
                            <p class="text-sm text-gray-600">Reconoce y celebra cada logro de tu pequeño aventurero, por pequeño que sea.</p>
                        </div>
                        <div class="child-card text-center">
                            <div class="text-4xl mb-3">🤝</div>
                            <h4 class="font-bold guardian-title mb-2">Colabora con Maestros</h4>
                            <p class="text-sm text-gray-600">Mantén comunicación regular con los maestros para apoyar mejor a tu hijo.</p>
                        </div>
                        <div class="child-card text-center">
                            <div class="text-4xl mb-3">📚</div>
                            <h4 class="font-bold guardian-title mb-2">Fomenta la Lectura</h4>
                            <p class="text-sm text-gray-600">La lectura en casa complementa perfectamente la aventura educativa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Actualizar progreso en tiempo real
        function updateChildrenProgress() {
            // Simular actualización de datos
            document.querySelectorAll('.child-progress-fill').forEach(progressBar => {
                // Añadir efecto de pulso cuando se actualiza
                progressBar.style.opacity = '0.7';
                setTimeout(() => {
                    progressBar.style.opacity = '1';
                }, 300);
            });
        }

        // Actualizar cada 60 segundos
        setInterval(updateChildrenProgress, 60000);

        // Efectos visuales para las cards
        document.querySelectorAll('.guardian-card, .child-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Animación de entrada para las estadísticas
        function animateStats() {
            document.querySelectorAll('.child-stat').forEach((stat, index) => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    stat.style.transition = 'all 0.5s ease';
                    stat.style.opacity = '1';
                    stat.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Ejecutar animación al cargar
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(animateStats, 500);
        });
    </script>
</x-app-layout>