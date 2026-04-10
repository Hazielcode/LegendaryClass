@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    /* Cards súper claras para maestros */
    .teacher-card {
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
            0 0 20px rgba(59, 130, 246, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .teacher-card:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.15),
            0 0 30px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }
    
    .teacher-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    /* Botones de maestro */
    .teacher-button {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .teacher-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        text-decoration: none;
        color: white;
    }

    .teacher-button.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .teacher-button.green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .teacher-button.purple {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .teacher-button.purple:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        color: white;
    }

    .teacher-button.yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .teacher-button.yellow:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    /* Estadísticas de maestro */
    .teacher-stat {
        background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 0.9) 0%,
            rgba(255, 255, 255, 0.7) 100%
        );
        border: 2px solid rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .teacher-stat:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-family: 'Cinzel', serif;
        font-weight: 800;
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        color: #6b7280;
        font-weight: 600;
    }

    /* Actividades recientes */
    .activity-item {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-left: 4px solid #3b82f6;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }

    /* Fondo del dashboard */
    .dashboard-bg {
        background: url('/fondo.png') center/cover;
        min-height: 100vh;
        position: relative;
    }

    .dashboard-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
        z-index: 1;
    }

    .dashboard-content {
        position: relative;
        z-index: 2;
    }
</style>

<div class="dashboard-bg">
    <div class="dashboard-content py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título del maestro -->
            <div class="text-center mb-12">
                <h1 class="text-6xl font-bold teacher-title mb-4" style="font-family: 'Cinzel Decorative', serif;">
                    🧙‍♂️ MAESTRO SABIO 🧙‍♂️
                </h1>
                <h2 class="text-4xl font-bold teacher-title mb-4" style="color: #d97706;">
                    {{ strtoupper(auth()->user()->name) }}
                </h2>
                <p class="text-2xl teacher-title">Centro de Control Mágico</p>
            </div>

            <!-- Estadísticas del maestro -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="teacher-stat">
                    <div class="text-5xl mb-4">🏰</div>
                    <div class="stat-number text-blue-600">{{ auth()->user()->classrooms()->count() ?? 0 }}</div>
                    <div class="stat-label">Aulas Mágicas</div>
                </div>
                
                <div class="teacher-stat">
                    <div class="text-5xl mb-4">⚔️</div>
                    <div class="stat-number text-green-600">{{ auth()->user()->getAccessibleStudents()->count() ?? 0 }}</div>
                    <div class="stat-label">Aventureros</div>
                </div>
                
                <div class="teacher-stat">
                    <div class="text-5xl mb-4">⭐</div>
                    <div class="stat-number text-yellow-600">{{ auth()->user()->awardedBehaviors()->count() ?? 0 }}</div>
                    <div class="stat-label">Comportamientos</div>
                </div>
                
                <div class="teacher-stat">
                    <div class="text-5xl mb-4">🎁</div>
                    <div class="stat-number text-purple-600">0</div>
                    <div class="stat-label">Recompensas</div>
                </div>
            </div>

            <!-- Panel de gestión principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                
                <!-- Gestión de aulas -->
                <div class="teacher-card p-8">
                    <h3 class="text-2xl font-bold teacher-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏰</span>
                        Mis Dominios Mágicos
                    </h3>
                    <p class="text-gray-600 mb-6">Administra tus aulas y supervisa a tus aventureros estudiantes.</p>
                    <div class="space-y-4">
                        <a href="{{ route('teacher.classrooms.index') }}" class="teacher-button w-full text-center block">
                            🏛️ Ver Todas las Aulas
                        </a>
                        <a href="{{ route('teacher.classrooms.create') }}" class="teacher-button green w-full text-center block">
                            ➕ Crear Nueva Aula
                        </a>
                        <div class="text-sm text-gray-500 text-center mt-4">
                            {{ auth()->user()->classrooms()->count() ?? 0 }} aulas activas
                        </div>
                    </div>
                </div>

                <!-- Gestión de comportamientos -->
                <div class="teacher-card p-8">
                    <h3 class="text-2xl font-bold teacher-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">⭐</span>
                        Sistema de Recompensas
                    </h3>
                    <p class="text-gray-600 mb-6">Otorga puntos y reconocimientos a tus estudiantes aventureros.</p>
                    <div class="space-y-4">
                        <a href="{{ route('teacher.behaviors.index') }}" class="teacher-button purple w-full text-center block">
                            📝 Gestionar Comportamientos
                        </a>
                        <a href="{{ route('teacher.rewards.index') }}" class="teacher-button yellow w-full text-center block">
                            🎁 Gestionar Recompensas
                        </a>
                        <div class="text-sm text-gray-500 text-center mt-4">
                            {{ auth()->user()->awardedBehaviors()->count() ?? 0 }} comportamientos otorgados
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="teacher-card p-8 mb-8">
                <h3 class="text-2xl font-bold teacher-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">⚡</span>
                    Acciones Rápidas del Maestro
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('teacher.student-behaviors.index') }}" class="teacher-button w-full text-center py-4">
                        📊 Ver Reportes
                    </a>
                    
                    <a href="{{ route('classrooms.join.form') }}" class="teacher-button green w-full text-center py-4">
                        🚪 Unirse a Aula
                    </a>
                    
                    <a href="{{ route('profile.show') }}" class="teacher-button purple w-full text-center py-4">
                        👤 Mi Perfil
                    </a>
                    
                    <a href="{{ route('teacher.behaviors.create') }}" class="teacher-button yellow w-full text-center py-4">
                        ⭐ Nuevo Comportamiento
                    </a>
                </div>
            </div>

            <!-- Actividades recientes -->
            <div class="teacher-card p-8">
                <h3 class="text-2xl font-bold teacher-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📈</span>
                    Actividades Recientes de mis Aventureros
                </h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse(auth()->user()->awardedBehaviors()->latest()->limit(10)->get() as $behavior)
                        <div class="activity-item flex items-center">
                            <div class="text-2xl mr-4">
                                @if(($behavior->points_awarded ?? 0) > 0)
                                    ⭐
                                @else
                                    ⚠️
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold teacher-title">
                                    {{ $behavior->student->name ?? 'Estudiante' }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $behavior->behavior->name ?? 'Comportamiento' }}
                                    @if($behavior->classroom)
                                        en {{ $behavior->classroom->name }}
                                    @endif
                                </div>
                                <div class="text-xs text-blue-600">
                                    {{ $behavior->created_at ? $behavior->created_at->diffForHumans() : 'Recientemente' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold {{ ($behavior->points_awarded ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ($behavior->points_awarded ?? 0) > 0 ? '+' : '' }}{{ $behavior->points_awarded ?? 0 }}
                                </div>
                                <div class="text-xs text-gray-500">puntos</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📈</div>
                            <h4 class="text-xl font-bold teacher-title mb-3">¡Comienza tu aventura!</h4>
                            <p class="text-gray-600 mb-6">No hay actividades recientes. Crea tu primera aula y comienza a otorgar puntos.</p>
                            <a href="{{ route('classrooms.create') }}" class="teacher-button green">
                                🏰 Crear Mi Primera Aula
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Efectos visuales para las cards
    document.querySelectorAll('.teacher-card, .teacher-stat').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animación de entrada para las estadísticas
    function animateStats() {
        document.querySelectorAll('.teacher-stat').forEach((stat, index) => {
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
@endsection