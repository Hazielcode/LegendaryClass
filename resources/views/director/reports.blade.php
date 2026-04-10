@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    /* Estilos del director reutilizados */
    .director-card {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.95) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(124, 58, 237, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
    }
    
    .director-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

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

    /* Gráfico simple */
    .chart-container {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
    }

    /* Top estudiantes */
    .top-student-item {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .top-student-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
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
            
            {{-- Header de reportes --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold director-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                    📊 REPORTES DEL REINO 📊
                </h1>
                <p class="text-lg director-title">Estadísticas y análisis del sistema educativo</p>
                <div class="mt-4">
                    <a href="{{ route('director.dashboard') }}" class="director-button">
                        ← Volver al Panel Imperial
                    </a>
                </div>
            </div>

            {{-- Estadísticas mensuales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">⭐</div>
                    <div class="text-2xl font-bold director-title text-green-600">{{ $monthly_stats['behaviors_this_month'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Comportamientos Este Mes</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">🎁</div>
                    <div class="text-2xl font-bold director-title text-blue-600">{{ $monthly_stats['rewards_this_month'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Recompensas Este Mes</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-2xl font-bold director-title text-purple-600">{{ $monthly_stats['new_students_this_month'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Nuevos Estudiantes</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">🏆</div>
                    <div class="text-2xl font-bold director-title text-yellow-600">{{ $monthly_stats['points_awarded_this_month'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Puntos Otorgados</div>
                </div>
            </div>

            {{-- Panel de análisis --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                {{-- Top Aventureros --}}
                <div class="director-card p-6">
                    <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏆</span>
                        Top Aventureros
                    </h3>
                    
                    @if(isset($top_students) && $top_students->count() > 0)
                        <div class="space-y-3">
                            @foreach($top_students->take(10) as $index => $student)
                                <div class="top-student-item flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : ($index === 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 ml-3">
                                        <div class="font-semibold text-sm">{{ $student->name }}</div>
                                        <div class="text-xs text-gray-600">
                                            {{ $student->character_class ?? 'Aventurero' }} - Nivel {{ $student->level ?? 1 }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-green-600">{{ $student->total_points ?? 0 }}</div>
                                        <div class="text-xs text-gray-500">puntos</div>
                                    </div>
                                    <div class="ml-2 text-lg">
                                        @if($index === 0)
                                            🥇
                                        @elseif($index === 1)
                                            🥈
                                        @elseif($index === 2)
                                            🥉
                                        @else
                                            {{ $student->character_icon ?? '⚔️' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">🏆</div>
                            <p class="text-gray-600">No hay datos de estudiantes disponibles</p>
                        </div>
                    @endif
                </div>

                {{-- Análisis de Comportamientos --}}
                <div class="director-card p-6">
                    <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">📈</span>
                        Análisis de Comportamientos
                    </h3>
                    
                    @if(isset($behavior_trends) && $behavior_trends->count() > 0)
                        <div class="space-y-4">
                            @foreach($behavior_trends->take(8) as $behavior)
                                <div class="flex items-center">
                                    <div class="text-2xl mr-3">{{ $behavior->icon ?? '⭐' }}</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-sm">{{ $behavior->name }}</div>
                                        <div class="text-xs text-gray-600">
                                            {{ $behavior->type === 'positive' ? 'Positivo' : 'Negativo' }} • 
                                            {{ $behavior->points > 0 ? '+' : '' }}{{ $behavior->points }} puntos
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold {{ $behavior->type === 'positive' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $behavior->student_behaviors_count ?? 0 }}
                                        </div>
                                        <div class="text-xs text-gray-500">usos</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">📈</div>
                            <p class="text-gray-600">No hay datos de comportamientos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Gráfico de actividad mensual --}}
            <div class="director-card p-6 mb-8">
                <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📊</span>
                    Actividad Mensual del Reino
                </h3>
                
                <div class="chart-container">
                    <div class="text-center py-8">
                        <div class="text-4xl mb-4">📊</div>
                        <h4 class="text-lg font-bold director-title mb-3">Gráfico en Desarrollo</h4>
                        <p class="text-gray-600 mb-4">Próximamente verás gráficos interactivos con:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="space-y-2">
                                <div>• Progreso diario de puntos</div>
                                <div>• Comportamientos por semana</div>
                                <div>• Actividad por aula</div>
                            </div>
                            <div class="space-y-2">
                                <div>• Recompensas canjeadas</div>
                                <div>• Estudiantes más activos</div>
                                <div>• Tendencias de participación</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Acciones de reportes --}}
            <div class="director-card p-6">
                <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📋</span>
                    Acciones de Reportes
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button onclick="exportReport('monthly')" 
                            class="director-button w-full text-center py-4">
                        <div class="text-xl mb-2">📊</div>
                        <div class="font-bold text-sm">Reporte Mensual</div>
                        <div class="text-xs opacity-75">Exportar estadísticas del mes</div>
                    </button>
                    
                    <button onclick="exportReport('students')" 
                            class="director-button w-full text-center py-4">
                        <div class="text-xl mb-2">⚔️</div>
                        <div class="font-bold text-sm">Reporte de Estudiantes</div>
                        <div class="text-xs opacity-75">Lista detallada de aventureros</div>
                    </button>
                    
                    <button onclick="exportReport('behaviors')" 
                            class="director-button w-full text-center py-4">
                        <div class="text-xl mb-2">⭐</div>
                        <div class="font-bold text-sm">Reporte de Comportamientos</div>
                        <div class="text-xs opacity-75">Análisis de actividades</div>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Función para exportar reportes
    function exportReport(type) {
        alert(`Funcionalidad de exportación de reporte "${type}" en desarrollo.\n\nPróximamente podrás exportar reportes en formato PDF y Excel.`);
    }
    
    // Efectos visuales para las cards
    document.querySelectorAll('.director-card, .top-student-item').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animación de entrada para los top estudiantes
    function animateTopStudents() {
        document.querySelectorAll('.top-student-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, index * 100);
        });
    }

    // Ejecutar animación al cargar
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(animateTopStudents, 500);
    });
</script>
@endsection