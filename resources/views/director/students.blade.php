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

    /* Tarjeta de estudiante */
    .student-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .student-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
        border-color: rgba(16, 185, 129, 0.4);
    }

    /* Indicador de nivel */
    .level-indicator {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: bold;
        position: absolute;
        top: 1rem;
        right: 1rem;
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
            
            {{-- Header de gestión de estudiantes --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold director-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                    ⚔️ GESTIÓN DE ESTUDIANTES ⚔️
                </h1>
                <p class="text-lg director-title">Administra los aventureros del reino</p>
                <div class="mt-4">
                    <a href="{{ route('director.dashboard') }}" class="director-button">
                        ← Volver al Panel Imperial
                    </a>
                </div>
            </div>

            {{-- Estadísticas de estudiantes --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">⚔️</div>
                    <div class="text-2xl font-bold director-title text-green-600">{{ $students->count() }}</div>
                    <div class="text-sm text-gray-600">Total Aventureros</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">⭐</div>
                    <div class="text-2xl font-bold director-title text-yellow-600">{{ $students->sum('total_points') }}</div>
                    <div class="text-sm text-gray-600">Puntos Totales</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">🏆</div>
                    <div class="text-2xl font-bold director-title text-purple-600">{{ $students->where('total_points', '>', 100)->count() }}</div>
                    <div class="text-sm text-gray-600">Nivel Alto</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">📈</div>
                    <div class="text-2xl font-bold director-title text-blue-600">{{ round($students->avg('current_level'), 1) }}</div>
                    <div class="text-sm text-gray-600">Nivel Promedio</div>
                </div>
            </div>

            {{-- Lista de estudiantes --}}
            <div class="director-card p-6">
                <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">⚔️</span>
                    Aventureros del Reino
                </h3>
                
                @if($students->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($students as $student)
                            <div class="student-card">
                                {{-- Indicador de nivel --}}
                                <div class="level-indicator">
                                    Nivel {{ $student->current_level ?? 1 }}
                                </div>
                                
                                {{-- Avatar del estudiante --}}
                                <div class="text-center mb-4">
                                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center text-2xl">
                                        {{ $student->character_icon ?? '⚔️' }}
                                    </div>
                                </div>
                                
                                {{-- Información del estudiante --}}
                                <div class="text-center">
                                    <h4 class="text-lg font-bold director-title mb-1">{{ $student->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $student->character_class ?? 'Aventurero' }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $student->email }}</p>
                                    
                                    {{-- Estadísticas del estudiante --}}
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-yellow-600">{{ $student->total_points ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Puntos</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-blue-600">{{ $student->current_level ?? 1 }}</div>
                                            <div class="text-xs text-gray-500">Nivel</div>
                                        </div>
                                    </div>
                                    
                                    {{-- Barra de progreso --}}
                                    <div class="mb-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            @php
                                                $points = $student->total_points ?? 0;
                                                $level = $student->current_level ?? 1;
                                                $currentLevelPoints = ($level - 1) * 100;
                                                $nextLevelPoints = $level * 100;
                                                $progress = $nextLevelPoints > $currentLevelPoints ? 
                                                           (($points - $currentLevelPoints) / ($nextLevelPoints - $currentLevelPoints)) * 100 : 100;
                                                $progress = max(0, min(100, $progress));
                                            @endphp
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Progreso al siguiente nivel
                                        </div>
                                    </div>
                                    
                                    {{-- Estado --}}
                                    <div class="mb-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $student->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $student->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                    
                                    {{-- Acciones --}}
                                    <div class="flex flex-col space-y-2">
                                        <button onclick="viewStudentDetails('{{ $student->_id }}')" 
                                                class="px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 transition">
                                            Ver Detalles
                                        </button>
                                        
                                        <form method="POST" action="{{ route('director.users.toggle-status', $student) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-3 py-1 {{ $student->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded text-xs transition w-full">
                                                {{ $student->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Estado vacío --}}
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">⚔️</div>
                        <h4 class="text-xl font-bold director-title mb-3">No hay estudiantes registrados</h4>
                        <p class="text-gray-600 mb-6">Aún no se han registrado estudiantes en el sistema.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- Modal para detalles del estudiante --}}
<div id="studentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold director-title">Detalles del Aventurero</h3>
            <button onclick="closeStudentModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div id="studentModalContent">
            {{-- Contenido dinámico --}}
        </div>
    </div>
</div>

<script>
    // Función para ver detalles del estudiante
    function viewStudentDetails(studentId) {
        // Por ahora solo mostramos información básica
        document.getElementById('studentModalContent').innerHTML = `
            <div class="text-center">
                <div class="text-4xl mb-4">⚔️</div>
                <p class="text-gray-600">Funcionalidad de detalles en desarrollo...</p>
                <p class="text-sm text-gray-500 mt-2">ID: ${studentId}</p>
            </div>
        `;
        document.getElementById('studentModal').classList.remove('hidden');
    }
    
    // Función para cerrar modal
    function closeStudentModal() {
        document.getElementById('studentModal').classList.add('hidden');
    }
    
    // Efectos visuales para las cards
    document.querySelectorAll('.student-card, .director-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection