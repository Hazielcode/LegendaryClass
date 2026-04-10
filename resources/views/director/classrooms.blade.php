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

    /* Tarjeta de aula */
    .classroom-card {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 2px solid rgba(124, 58, 237, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .classroom-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.2);
        border-color: rgba(124, 58, 237, 0.4);
    }

    /* Código de aula */
    .classroom-code {
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
            
            {{-- Header de gestión de aulas --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold director-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                    🏰 GESTIÓN DE AULAS 🏰
                </h1>
                <p class="text-lg director-title">Administra los territorios del reino</p>
                <div class="mt-4">
                    <a href="{{ route('director.dashboard') }}" class="director-button">
                        ← Volver al Panel Imperial
                    </a>
                </div>
            </div>

            {{-- Estadísticas de aulas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">🏰</div>
                    <div class="text-2xl font-bold director-title text-purple-600">{{ $classrooms->count() }}</div>
                    <div class="text-sm text-gray-600">Total Aulas</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">✅</div>
                    <div class="text-2xl font-bold director-title text-green-600">{{ $classrooms->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Aulas Activas</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-2xl font-bold director-title text-blue-600">{{ $classrooms->sum('students_count') }}</div>
                    <div class="text-sm text-gray-600">Total Estudiantes</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">⭐</div>
                    <div class="text-2xl font-bold director-title text-yellow-600">{{ $classrooms->sum('behaviors_count') }}</div>
                    <div class="text-sm text-gray-600">Comportamientos</div>
                </div>
            </div>

            {{-- Lista de aulas --}}
            <div class="director-card p-6">
                <h3 class="text-2xl font-bold director-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">🏰</span>
                    Territorios del Reino
                </h3>
                
                @if($classrooms && $classrooms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($classrooms as $classroom)
                            <div class="classroom-card">
                                {{-- Código de aula --}}
                                <div class="classroom-code">
                                    {{ $classroom->code }}
                                </div>
                                
                                {{-- Icono del aula --}}
                                <div class="text-center mb-4">
                                    <div class="w-16 h-16 mx-auto bg-purple-100 rounded-full flex items-center justify-center text-2xl">
                                        🏰
                                    </div>
                                </div>
                                
                                {{-- Información del aula --}}
                                <div class="text-center">
                                    <h4 class="text-lg font-bold director-title mb-1">{{ $classroom->name }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $classroom->subject ?? 'Materia' }} - {{ $classroom->grade_level ?? 'Grado' }}</p>
                                    <p class="text-xs text-gray-500 mb-3">
                                        Maestro: {{ $classroom->teacher->name ?? 'Sin asignar' }}
                                    </p>
                                    
                                    {{-- Estadísticas del aula --}}
                                    <div class="grid grid-cols-3 gap-2 mb-4">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-blue-600">{{ $classroom->students_count ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Estudiantes</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-green-600">{{ $classroom->behaviors_count ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Comportamientos</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-yellow-600">{{ $classroom->rewards_count ?? 0 }}</div>
                                            <div class="text-xs text-gray-500">Recompensas</div>
                                        </div>
                                    </div>
                                    
                                    {{-- Estado --}}
                                    <div class="mb-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $classroom->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $classroom->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </div>
                                    
                                    {{-- Descripción --}}
                                    @if($classroom->description)
                                        <p class="text-xs text-gray-600 mb-4 italic">
                                            "{{ Str::limit($classroom->description, 60) }}"
                                        </p>
                                    @endif
                                    
                                    {{-- Acciones --}}
                                    <div class="flex flex-col space-y-2">
                                        <button onclick="viewClassroomDetails('{{ $classroom->_id }}')" 
                                                class="px-3 py-1 bg-purple-500 text-white rounded text-xs hover:bg-purple-600 transition">
                                            Ver Detalles
                                        </button>
                                        
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                                               class="px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600 transition text-center">
                                                Ingresar
                                            </a>
                                            <button onclick="alert('Reportes en desarrollo')" 
                                                    class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600 transition text-center">
                                                Reportes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Estado vacío --}}
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🏰</div>
                        <h4 class="text-xl font-bold director-title mb-3">No hay aulas registradas</h4>
                        <p class="text-gray-600 mb-6">Aún no se han creado aulas en el sistema.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- Modal para detalles del aula --}}
<div id="classroomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold director-title">Detalles del Territorio</h3>
            <button onclick="closeClassroomModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div id="classroomModalContent">
            {{-- Contenido dinámico --}}
        </div>
    </div>
</div>

<script>
    // Función para ver detalles del aula
    function viewClassroomDetails(classroomId) {
        // Por ahora solo mostramos información básica
        document.getElementById('classroomModalContent').innerHTML = `
            <div class="text-center">
                <div class="text-4xl mb-4">🏰</div>
                <p class="text-gray-600">Funcionalidad de detalles en desarrollo...</p>
                <p class="text-sm text-gray-500 mt-2">ID: ${classroomId}</p>
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Próximamente podrás ver:</p>
                    <ul class="text-xs text-gray-500 mt-2 space-y-1">
                        <li>• Lista completa de estudiantes</li>
                        <li>• Estadísticas detalladas</li>
                        <li>• Configuraciones del aula</li>
                        <li>• Actividad reciente</li>
                    </ul>
                </div>
            </div>
        `;
        document.getElementById('classroomModal').classList.remove('hidden');
    }
    
    // Función para cerrar modal
    function closeClassroomModal() {
        document.getElementById('classroomModal').classList.add('hidden');
    }
    
    // Efectos visuales para las cards
    document.querySelectorAll('.classroom-card, .director-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection