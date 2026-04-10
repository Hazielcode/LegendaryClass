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

    .behavior-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .behavior-table th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 700;
        padding: 1rem;
        text-align: left;
    }

    .behavior-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
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
                            📊 Comportamientos de Estudiantes
                        </h1>
                        @if($classroom)
                            <p class="text-lg epic-title text-blue-600">{{ $classroom->name }} • {{ $classroom->subject }}</p>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($classroom)
                            <a href="{{ route('teacher.classrooms.reports', $classroom) }}" 
                               class="epic-button text-sm py-2 px-4">
                                📈 Ver Reportes Completos
                            </a>
                            <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                               class="epic-button text-sm py-2 px-4">
                                ← Volver al Aula
                            </a>
                        @else
                            <a href="{{ route('teacher.classrooms.index') }}" 
                               class="epic-button text-sm py-2 px-4">
                                ← Volver a Mis Aulas
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabla de comportamientos -->
            <div class="epic-card p-6">
                <h2 class="text-2xl font-bold epic-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📝</span>
                    Historial de Comportamientos
                </h2>
                
                @if($studentBehaviors->count() > 0)
                    <div class="behavior-table mb-6">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Estudiante</th>
                                    <th>Comportamiento</th>
                                    <th>Puntos</th>
                                    <th>Profesor</th>
                                    <th>Notas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentBehaviors as $behavior)
                                    <tr>
                                        <td class="text-sm font-medium">
                                            {{ $behavior->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="font-semibold">
                                            {{ $behavior->student->name ?? 'Estudiante eliminado' }}
                                        </td>
                                        <td class="text-gray-700">
                                            {{ $behavior->behavior->name ?? 'Comportamiento eliminado' }}
                                        </td>
                                        <td class="font-bold text-lg {{ $behavior->points_awarded > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $behavior->points_awarded > 0 ? '+' : '' }}{{ $behavior->points_awarded }}
                                        </td>
                                        <td class="text-sm">
                                            {{ $behavior->teacher->name ?? 'Profesor eliminado' }}
                                        </td>
                                        <td class="text-sm text-gray-600 max-w-xs truncate">
                                            {{ $behavior->notes ?? '-' }}
                                        </td>
                                        <td>
                                            @if(auth()->user()->role === 'teacher' && $behavior->awarded_by === auth()->id())
                                                <button onclick="deleteBehavior('{{ $behavior->id }}')" 
                                                        class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                    🗑️ Eliminar
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="flex justify-center">
                        {{ $studentBehaviors->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📊</div>
                        <h3 class="text-xl font-bold epic-title mb-3">No hay comportamientos registrados</h3>
                        <p class="text-gray-600 mb-6">Aún no se han registrado comportamientos para este aula.</p>
                        @if($classroom)
                            <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                               class="epic-button">
                                Ir al Aula para Registrar Comportamientos
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    // Función para eliminar comportamiento
    function deleteBehavior(behaviorId) {
        if (confirm('¿Estás seguro de que quieres eliminar este comportamiento? Los puntos serán revertidos.')) {
            fetch(`/teacher/student-behaviors/${behaviorId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el comportamiento');
            });
        }
    }

    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.epic-card');
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
</script>
@endsection