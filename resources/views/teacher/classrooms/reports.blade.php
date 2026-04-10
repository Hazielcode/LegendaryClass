@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    .epic-card {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.95) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(59, 130, 246, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .epic-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    .epic-button {
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

    .epic-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        text-decoration: none;
        color: white;
    }

    .epic-button.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .epic-button.green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .epic-button.purple {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .epic-button.purple:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        color: white;
    }

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

    .stat-card {
        background: linear-gradient(135deg, var(--bg-start) 0%, var(--bg-end) 100%);
        color: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .report-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .report-table th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 700;
        padding: 1rem;
        text-align: left;
    }

    .report-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .export-card {
        border: 2px solid rgba(16, 185, 129, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        transition: all 0.3s ease;
    }

    .export-card:hover {
        transform: translateY(-2px);
        border-color: rgba(16, 185, 129, 0.5);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="epic-card p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold epic-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                            📊 Reportes de {{ $classroom->name }}
                        </h1>
                        <p class="text-lg epic-title text-blue-600">{{ $classroom->subject }} • {{ $classroom->grade_level }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                           class="epic-button text-sm py-2 px-4">
                            ← Volver al Aula
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas generales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card" style="--bg-start: #3b82f6; --bg-end: #1d4ed8;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Estudiantes</p>
                            <p class="text-3xl font-bold">{{ $stats['total_students'] }}</p>
                        </div>
                        <div class="text-4xl">👥</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #10b981; --bg-end: #059669;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Comportamientos Positivos</p>
                            <p class="text-3xl font-bold">{{ $stats['positive_behaviors'] }}</p>
                        </div>
                        <div class="text-4xl">⭐</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #ef4444; --bg-end: #dc2626;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm">Comportamientos Negativos</p>
                            <p class="text-3xl font-bold">{{ $stats['negative_behaviors'] }}</p>
                        </div>
                        <div class="text-4xl">⚠️</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #f59e0b; --bg-end: #d97706;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Puntos Totales</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['total_points_awarded']) }}</p>
                        </div>
                        <div class="text-4xl">🏆</div>
                    </div>
                </div>
            </div>

            <!-- Botones de exportación -->
            <div class="epic-card p-6 mb-8">
                <h2 class="text-2xl font-bold epic-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📥</span>
                    Descargar Reportes en Excel
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="export-card">
                        <div class="text-center mb-4">
                            <div class="text-4xl mb-3">📋</div>
                            <h3 class="text-lg font-bold epic-title mb-2">Reporte de Estudiantes</h3>
                            <p class="text-sm text-gray-600 mb-4">Lista completa con puntos, niveles y logros de cada estudiante</p>
                        </div>
                        <a href="{{ route('teacher.classrooms.export-reports', ['classroom' => $classroom, 'type' => 'students']) }}" 
                           class="epic-button green w-full text-center py-3">
                            💾 Descargar Estudiantes
                        </a>
                    </div>

                    <div class="export-card">
                        <div class="text-center mb-4">
                            <div class="text-4xl mb-3">📊</div>
                            <h3 class="text-lg font-bold epic-title mb-2">Reporte de Comportamientos</h3>
                            <p class="text-sm text-gray-600 mb-4">Historial detallado de todos los comportamientos registrados</p>
                        </div>
                        <a href="{{ route('teacher.classrooms.export-reports', ['classroom' => $classroom, 'type' => 'behaviors']) }}" 
                           class="epic-button w-full text-center py-3">
                            💾 Descargar Comportamientos
                        </a>
                    </div>

                    <div class="export-card">
                        <div class="text-center mb-4">
                            <div class="text-4xl mb-3">📈</div>
                            <h3 class="text-lg font-bold epic-title mb-2">Reporte Completo</h3>
                            <p class="text-sm text-gray-600 mb-4">Análisis completo combinando estudiantes y comportamientos</p>
                        </div>
                        <a href="{{ route('teacher.classrooms.export-reports', ['classroom' => $classroom, 'type' => 'complete']) }}" 
                           class="epic-button purple w-full text-center py-3">
                            💾 Descargar Completo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Top estudiantes -->
            <div class="epic-card p-6 mb-8">
                <h2 class="text-2xl font-bold epic-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">🏆</span>
                    Top 10 Estudiantes
                </h2>
                <div class="report-table">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Estudiante</th>
                                <th>Puntos Totales</th>
                                <th>Nivel</th>
                                <th>Racha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topStudents as $index => $studentPoint)
                                @php
                                    $student = $students->where('_id', $studentPoint->student_id)->first();
                                @endphp
                                <tr class="{{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                    <td class="font-bold text-lg">
                                        @if($index === 0) 🥇
                                        @elseif($index === 1) 🥈
                                        @elseif($index === 2) 🥉
                                        @else {{ $index + 1 }}°
                                        @endif
                                    </td>
                                    <td class="font-semibold">{{ $student->name ?? 'Estudiante eliminado' }}</td>
                                    <td class="text-blue-600 font-bold text-lg">{{ number_format($studentPoint->total_points) }}</td>
                                    <td class="font-medium">Nivel {{ $studentPoint->level }}</td>
                                    <td class="text-green-600 font-medium">{{ $studentPoint->streak_days }} días</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-500">
                                        <div class="text-4xl mb-3">📊</div>
                                        <p>No hay datos de estudiantes disponibles</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Comportamientos recientes -->
            <div class="epic-card p-6">
                <h2 class="text-2xl font-bold epic-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📈</span>
                    Comportamientos Recientes (Últimos 20)
                </h2>
                <div class="report-table">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estudiante</th>
                                <th>Comportamiento</th>
                                <th>Puntos</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($behaviors->take(20) as $behavior)
                                <tr>
                                    <td class="text-sm font-medium">{{ $behavior->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="font-semibold">{{ $behavior->student->name ?? 'Estudiante eliminado' }}</td>
                                    <td class="text-gray-700">{{ $behavior->behavior->name ?? 'Comportamiento eliminado' }}</td>
                                    <td class="font-bold text-lg {{ $behavior->points_awarded > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $behavior->points_awarded > 0 ? '+' : '' }}{{ $behavior->points_awarded }}
                                    </td>
                                    <td class="text-sm text-gray-600 max-w-xs truncate">{{ $behavior->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-500">
                                        <div class="text-4xl mb-3">📝</div>
                                        <p>No hay comportamientos registrados</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                
                <!-- Resumen estadístico -->
                <div class="epic-card p-6">
                    <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
                        <span class="text-2xl mr-3">📊</span>
                        Resumen Estadístico
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="font-medium text-blue-800">Promedio de puntos por estudiante:</span>
                            <span class="font-bold text-blue-600">{{ number_format($stats['average_points_per_student'], 1) }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="font-medium text-green-800">Total comportamientos registrados:</span>
                            <span class="font-bold text-green-600">{{ $stats['total_behaviors'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                            <span class="font-medium text-purple-800">Ratio positivo/negativo:</span>
                            <span class="font-bold text-purple-600">
                                @if($stats['negative_behaviors'] > 0)
                                    {{ number_format($stats['positive_behaviors'] / $stats['negative_behaviors'], 2) }}:1
                                @else
                                    {{ $stats['positive_behaviors'] }}:0
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Información del aula -->
                <div class="epic-card p-6">
                    <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
                        <span class="text-2xl mr-3">🏫</span>
                        Información del Aula
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-semibold">{{ $classroom->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Materia:</span>
                            <span class="font-semibold">{{ $classroom->subject }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Grado:</span>
                            <span class="font-semibold">{{ $classroom->grade_level }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Año escolar:</span>
                            <span class="font-semibold">{{ $classroom->school_year ?? '2024-2025' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Código de acceso:</span>
                            <span class="font-bold text-yellow-600">{{ $classroom->class_code }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Fecha del reporte:</span>
                            <span class="font-semibold">{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Botón de regreso -->
            <div class="mt-8 text-center">
                <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                   class="epic-button text-lg py-3 px-8">
                    ← Regresar al Aula
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.epic-card, .stat-card, .export-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    // Efecto de hover en las tarjetas de exportación
    document.querySelectorAll('.export-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection