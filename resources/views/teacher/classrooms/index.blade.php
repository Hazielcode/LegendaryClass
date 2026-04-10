    @extends('layouts.app')

    @push('styles')
    <style>
    .classroom-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(59, 130, 246, 0.1);
        transition: all 0.3s ease;
    }

    .classroom-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15), 0 0 30px rgba(59, 130, 246, 0.2);
    }

    .classroom-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .classroom-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 0 30px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .code-section {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.1) 100%);
        border: 2px solid rgba(245, 158, 11, 0.3);
    }

    .copy-button {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.2s ease;
    }

    .copy-button:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    .action-button {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.2s ease;
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        text-decoration: none;
        color: white;
    }

    .action-button.edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .action-button.edit:hover {
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .title-epic {
        font-family: 'Cinzel', serif;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
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

    .student-count {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .stat-positive {
        color: #059669;
        font-family: 'Cinzel', serif;
    }

    .stat-purple {
        color: #7c3aed;
        font-family: 'Cinzel', serif;
    }
    </style>
    @endpush

    @section('content')
    <div class="dashboard-bg">
        <div class="dashboard-content py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Título épico -->
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold title-epic mb-4" style="font-family: 'Cinzel Decorative', serif;">
                        🏰 MIS AULAS MÁGICAS 🏰
                    </h1>
                    <p class="text-2xl title-epic">Administra tus dominios épicos</p>
                    <div class="mt-6">
                        <a href="{{ route('teacher.classrooms.create') }}" 
                        class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-200" 
                        style="font-family: 'Cinzel', serif; text-transform: uppercase;">
                            ✨ Crear Nueva Aula Mágica
                        </a>
                    </div>
                </div>

                @if(isset($classrooms) && $classrooms->isEmpty())
                    <div class="classroom-section rounded-2xl p-16 text-center">
                        <div class="text-8xl mb-6">🏰</div>
                        <h3 class="text-4xl font-bold title-epic mb-4">¡Tu Reino Espera!</h3>
                        <p class="text-xl text-gray-600 mb-8" style="font-family: 'Playfair Display', serif;">
                            No tienes aulas creadas. ¡Crea tu primera aula mágica y comienza la aventura épica!
                        </p>
                        <a href="{{ route('teacher.classrooms.create') }}" 
                        class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-200"
                        style="font-family: 'Cinzel', serif; text-transform: uppercase;">
                            🏛️ Fundar Mi Primer Reino
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if(isset($classrooms))
                            @foreach($classrooms as $classroom)
                                <div class="classroom-card rounded-2xl p-8">
                                    
                                    <!-- Header del aula -->
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="text-4xl">🏰</div>
                                        <span class="student-count px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                            {{ isset($classroom->student_ids) ? count($classroom->student_ids) : 0 }} estudiantes
                                        </span>
                                    </div>

                                    <!-- Información del aula -->
                                    <h3 class="text-2xl font-bold title-epic mb-3">{{ $classroom->name ?? 'Aula Sin Nombre' }}</h3>
                                    <p class="text-gray-600 text-sm mb-6" style="font-family: 'Playfair Display', serif;">
                                        {{ $classroom->description ?? 'Aula mágica de aprendizaje donde los estudiantes se convierten en leyendas' }}
                                    </p>
                                    
                                    <!-- Código del aula -->
                                    <div class="code-section rounded-xl p-4 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="text-yellow-700 text-xs font-bold">CÓDIGO MÁGICO DE ACCESO</span>
                                                <div class="text-yellow-800 font-bold text-2xl title-epic">{{ $classroom->class_code ?? 'SIN-CODIGO' }}</div>
                                            </div>
                                            <button onclick="copyCode('{{ $classroom->class_code ?? '' }}')"
                                                    class="copy-button p-3 rounded-xl font-bold">
                                                📋
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Estadísticas épicas -->
                                    <div class="grid grid-cols-2 gap-6 mb-6">
    <div class="text-center">
        <div class="text-3xl font-bold stat-positive mb-1">{{ $classroom->behaviors()->where('type', 'positive')->count() }}</div>
        <div class="text-xs text-green-600 font-semibold">COMPORTAMIENTOS<br>POSITIVOS</div>
    </div>
    <div class="text-center">
        <div class="text-3xl font-bold stat-purple mb-1">{{ $classroom->rewards()->count() }}</div>
        <div class="text-xs text-purple-600 font-semibold">RECOMPENSAS<br>DISPONIBLES</div>
    </div>
</div>

                                    <!-- Acciones épicas -->
                                    <div class="flex gap-3">
                                        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
   class="action-button flex-1 text-center py-3 px-4 rounded-xl text-sm font-bold">
    🔍 EXPLORAR
</a>
                                        <a href="{{ route('teacher.classrooms.edit', $classroom) }}"
   class="action-button edit flex-1 text-center py-3 px-4 rounded-xl text-sm font-bold">
    ✏️ MODIFICAR
</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    function copyCode(code) {
        if (code) {
            navigator.clipboard.writeText(code).then(function() {
                alert('¡Código copiado: ' + code);
            }).catch(function() {
                prompt('Copia este código:', code);
            });
        }
    }

    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.classroom-card');
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
    @endpush