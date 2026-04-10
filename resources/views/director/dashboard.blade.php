{{-- resources/views/director/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    /* Estilos para tarjetas del director */
    .director-card {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.95) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(124, 58, 237, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .director-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15), 0 0 30px rgba(124, 58, 237, 0.2);
        border-color: rgba(124, 58, 237, 0.4);
    }
    
    /* Títulos del director */
    .director-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    /* Botones del director */
    .director-button {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
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
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .director-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
        text-decoration: none;
        color: white;
    }

    /* Variantes de botones */
    .director-button.blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); }
    .director-button.blue:hover { background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4); color: white; }
    .director-button.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); }
    .director-button.green:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); color: white; }
    .director-button.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); }
    .director-button.orange:hover { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4); color: white; }
    .director-button.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); }
    .director-button.red:hover { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4); color: white; }

    /* Estadísticas compactas */
    .compact-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .compact-stat-card {
        background: linear-gradient(135deg, var(--bg-start) 0%, var(--bg-end) 100%);
        color: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .compact-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .compact-stat-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .compact-stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0.25rem 0 0 0;
    }

    .compact-stat-label {
        font-size: 0.75rem;
        opacity: 0.9;
        margin: 0;
    }

    .compact-stat-icon {
        font-size: 1.5rem;
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
    <div class="dashboard-content py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Título del director --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold director-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                    👑 PANEL IMPERIAL 👑
                </h1>
                <h2 class="text-2xl font-bold director-title mb-2" style="color: #7c3aed;">
                    {{ strtoupper(auth()->user()->name) }}
                </h2>
                <p class="text-lg director-title">Dashboard del Director{{ auth()->user()->gender === 'female' ? 'a' : '' }}</p>
                
                {{-- Información de debug si está disponible --}}
                @if(isset($debug_info) && $debug_info)
                    <div class="mt-4 p-2 bg-green-100 border border-green-400 rounded text-sm">
                        <strong>🎯 Sistema Activo:</strong> {{ $debug_info['controller_active'] ?? 'OK' }} | 
                        <strong>Usuario:</strong> {{ $debug_info['user_name'] ?? 'N/A' }} | 
                        <strong>Rol:</strong> {{ $debug_info['user_role'] ?? 'N/A' }}
                    </div>
                @endif
            </div>

            {{-- Estadísticas principales compactas --}}
            <div class="compact-stats">
                <div class="compact-stat-card" style="--bg-start: #3b82f6; --bg-end: #2563eb;">
                    <div class="compact-stat-content">
                        <div>
                            <p class="compact-stat-label">Total Maestros</p>
                            <p class="compact-stat-number">{{ $stats['total_teachers'] ?? 0 }}</p>
                        </div>
                        <div class="compact-stat-icon">🧙‍♂️</div>
                    </div>
                </div>

                <div class="compact-stat-card" style="--bg-start: #10b981; --bg-end: #059669;">
                    <div class="compact-stat-content">
                        <div>
                            <p class="compact-stat-label">Total Estudiantes</p>
                            <p class="compact-stat-number">{{ $stats['total_students'] ?? 0 }}</p>
                        </div>
                        <div class="compact-stat-icon">⚔️</div>
                    </div>
                </div>

                <div class="compact-stat-card" style="--bg-start: #f59e0b; --bg-end: #d97706;">
                    <div class="compact-stat-content">
                        <div>
                            <p class="compact-stat-label">Total Padres</p>
                            <p class="compact-stat-number">{{ $stats['total_parents'] ?? 0 }}</p>
                        </div>
                        <div class="compact-stat-icon">🛡️</div>
                    </div>
                </div>

                <div class="compact-stat-card" style="--bg-start: #8b5cf6; --bg-end: #7c3aed;">
                    <div class="compact-stat-content">
                        <div>
                            <p class="compact-stat-label">Total Aulas</p>
                            <p class="compact-stat-number">{{ $stats['total_classrooms'] ?? 0 }}</p>
                        </div>
                        <div class="compact-stat-icon">🏰</div>
                    </div>
                </div>
            </div>

            {{-- Panel de estadísticas detalladas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                {{-- Actividad del Reino --}}
                <div class="director-card p-6">
                    <h3 class="text-xl font-bold director-title mb-4 flex items-center">
                        <span class="text-2xl mr-3">📊</span>
                        Actividad del Reino
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg border border-green-200">
                            <span class="text-green-700 font-medium text-sm">Comportamientos Positivos</span>
                            <span class="text-lg font-bold text-green-600">{{ $stats['total_behaviors_awarded'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <span class="text-blue-700 font-medium text-sm">Recompensas Canjeadas</span>
                            <span class="text-lg font-bold text-blue-600">{{ $stats['total_rewards_redeemed'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <span class="text-purple-700 font-medium text-sm">Puntos Otorgados</span>
                            <span class="text-lg font-bold text-purple-600">{{ $stats['total_points_awarded'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                {{-- Estado del Reino --}}
                <div class="director-card p-6">
                    <h3 class="text-xl font-bold director-title mb-4 flex items-center">
                        <span class="text-2xl mr-3">🏆</span>
                        Estado del Reino
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <span class="text-yellow-700 font-medium text-sm">Aulas Activas</span>
                            <span class="text-lg font-bold text-yellow-600">{{ $stats['active_classrooms'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                            <span class="text-indigo-700 font-medium text-sm">Este Mes - Comportamientos</span>
                            <span class="text-lg font-bold text-indigo-600">{{ $monthly_stats['behaviors_this_month'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-pink-50 rounded-lg border border-pink-200">
                            <span class="text-pink-700 font-medium text-sm">Este Mes - Nuevos Estudiantes</span>
                            <span class="text-lg font-bold text-pink-600">{{ $monthly_stats['new_students_this_month'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Comandos Imperiales --}}
            <div class="director-card p-6 mb-8">
                <h3 class="text-xl font-bold director-title mb-6 flex items-center">
                    <span class="text-2xl mr-3">⚡</span>
                    Comandos Imperiales
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    {{-- Gestión de Maestros --}}
                    <a href="{{ route('director.teachers') }}" class="director-button blue w-full text-center py-4">
                        <div class="text-xl mb-2">🧙‍♂️</div>
                        <div class="font-bold text-sm">Gestionar Maestros</div>
                        <div class="text-xs opacity-75">Administrar profesores del reino</div>
                    </a>

                    {{-- Gestión de Estudiantes --}}
                    <a href="{{ route('director.students') }}" class="director-button green w-full text-center py-4">
                        <div class="text-xl mb-2">⚔️</div>
                        <div class="font-bold text-sm">Gestionar Estudiantes</div>
                        <div class="text-xs opacity-75">Supervisar aventureros</div>
                    </a>

                    {{-- Gestión de Aulas --}}
                    <a href="{{ route('director.classrooms') }}" class="director-button w-full text-center py-4">
                        <div class="text-xl mb-2">🏰</div>
                        <div class="font-bold text-sm">Gestionar Aulas</div>
                        <div class="text-xs opacity-75">Administrar territorios</div>
                    </a>

                    {{-- Ver Reportes --}}
                    <a href="{{ route('director.reports') }}" class="director-button orange w-full text-center py-4">
                        <div class="text-xl mb-2">📊</div>
                        <div class="font-bold text-sm">Ver Reportes</div>
                        <div class="text-xs opacity-75">Estadísticas del reino</div>
                    </a>

                </div>
            </div>

            {{-- Actividades Recientes --}}
            @if(isset($recent_activities) && $recent_activities->count() > 0)
            <div class="director-card p-6">
                <h3 class="text-xl font-bold director-title mb-6 flex items-center">
                    <span class="text-2xl mr-3">📈</span>
                    Actividades Recientes del Reino
                </h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($recent_activities as $activity)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-2xl mr-4">
                                @if($activity->points_awarded > 0)
                                    ⭐
                                @else
                                    ⚠️
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm">
                                    {{ $activity->student->name ?? 'Estudiante' }}
                                </div>
                                <div class="text-xs text-gray-600">
                                    {{ $activity->behavior->name ?? 'Comportamiento' }}
                                    @if($activity->classroom)
                                        en {{ $activity->classroom->name }}
                                    @endif
                                </div>
                                <div class="text-xs text-blue-600">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold {{ $activity->points_awarded > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $activity->points_awarded > 0 ? '+' : '' }}{{ $activity->points_awarded }}
                                </div>
                                <div class="text-xs text-gray-500">puntos</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    // Efectos visuales para las cards
    document.querySelectorAll('.director-card, .compact-stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animación de entrada para las estadísticas
    function animateStats() {
        document.querySelectorAll('.compact-stat-card').forEach((stat, index) => {
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