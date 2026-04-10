@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    .epic-card {
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
    
    .epic-card:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.15),
            0 0 30px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
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

    .epic-button.yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .epic-button.yellow:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .epic-button.red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .epic-button.red:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
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

    .stat-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .student-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .student-card:hover {
        transform: translateY(-2px);
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }

    .code-display {
        background: linear-gradient(135deg, 
            rgba(245, 158, 11, 0.15) 0%, 
            rgba(217, 119, 6, 0.1) 50%, 
            rgba(245, 158, 11, 0.15) 100%);
        border: 3px solid rgba(245, 158, 11, 0.4);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .code-display::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, 
            transparent 30%, 
            rgba(255, 255, 255, 0.1) 50%, 
            transparent 70%);
        animation: shimmer 3s infinite;
        pointer-events: none;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    #classroomCode {
        animation: pulse 2s infinite alternate;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.05); }
    }

    .activity-item {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-left: 4px solid #10b981;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }

    /* Estilos para el modal */
    .modal {
        backdrop-filter: blur(8px);
    }

    .modal-content {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .form-input {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    /* Animaciones para botones épicos */
    .epic-button:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .epic-button:active {
        transform: translateY(0) scale(0.98);
    }

    /* Animación de copia exitosa */
    .copy-success {
        animation: copyBounce 0.6s ease-in-out;
    }

    @keyframes copyBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    /* Animación de spin para loading */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header del aula -->
            <div class="epic-card p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold epic-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                            🏰 {{ $classroom->name }}
                        </h1>
                        <p class="text-lg epic-title text-blue-600">{{ $classroom->subject }} • {{ $classroom->grade_level }}</p>
                        @if($classroom->description)
                            <p class="text-gray-600 mt-2">{{ $classroom->description }}</p>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('teacher.behaviors.create', ['classroom' => $classroom->id]) }}" 
                           class="epic-button green text-sm py-2 px-4">
                            ⭐ Crear Comportamiento
                        </a>
                        <a href="{{ route('teacher.rewards.create', ['classroom' => $classroom->id]) }}" 
                           class="epic-button purple text-sm py-2 px-4">
                            🎁 Crear Recompensa
                        </a>
                        <a href="{{ route('teacher.classrooms.edit', $classroom) }}" 
                           class="epic-button yellow text-sm py-2 px-4">
                            ⚙️ Modificar Aula
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas épicas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card" style="--bg-start: #3b82f6; --bg-end: #1d4ed8;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Aventureros</p>
                            <p class="text-3xl font-bold">{{ isset($students) ? $students->count() : count($classroom->student_ids ?? []) }}</p>
                        </div>
                        <div class="text-4xl">⚔️</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #10b981; --bg-end: #059669;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Comportamientos</p>
                            <p class="text-3xl font-bold">{{ isset($behaviors) ? $behaviors->count() : 0 }}</p>
                        </div>
                        <div class="text-4xl">⭐</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #7c3aed; --bg-end: #5b21b6;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Recompensas</p>
                            <p class="text-3xl font-bold">{{ isset($rewards) ? $rewards->count() : 0 }}</p>
                        </div>
                        <div class="text-4xl">🎁</div>
                    </div>
                </div>

                <div class="stat-card" style="--bg-start: #f59e0b; --bg-end: #d97706;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Año Escolar</p>
                            <p class="text-lg font-bold">{{ $classroom->school_year ?? '2024-2025' }}</p>
                        </div>
                        <div class="text-4xl">📚</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Lista de estudiantes -->
                <div class="lg:col-span-2">
                    <div class="epic-card p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold epic-title flex items-center">
                                <span class="text-3xl mr-3">⚔️</span>
                                Aventureros del Reino
                            </h2>
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                {{ isset($students) ? $students->count() : count($classroom->student_ids ?? []) }}
                            </span>
                        </div>
                        
                        @if(isset($students) && $students->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($students as $student)
                                    <div class="student-card">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ substr($student->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold epic-title">{{ $student->name }}</p>
                                                    <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                                    @php
                                                        $studentPoint = collect($student->studentPoints ?? [])->where('classroom_id', $classroom->id)->first();
                                                        $points = $studentPoint['total_points'] ?? 0;
                                                        $level = $studentPoint['level'] ?? 1;
                                                    @endphp
                                                    <p class="text-xs text-blue-600">Nivel {{ $level }} • {{ $points }} puntos</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-blue-600">{{ $points }}</div>
                                                <div class="text-xs text-gray-500">puntos</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">⚔️</div>
                                <h3 class="text-xl font-bold epic-title mb-3">No hay aventureros aún</h3>
                                <p class="text-gray-600 mb-6">Los estudiantes pueden unirse usando el código del aula o puedes importarlos desde Excel.</p>
                                <div class="flex gap-4 justify-center">
                                    <a href="{{ route('teacher.classrooms.import-students-form', $classroom) }}" 
                                       class="epic-button yellow">
                                        📤 Importar Estudiantes
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Panel lateral -->
                <div class="space-y-6">
                    
                    <!-- Código del aula ÉPICO -->
                    <div class="epic-card p-6">
                        <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
                            <span class="text-2xl mr-3">🔑</span>
                            Código de Acceso
                        </h3>
                        
                        <div class="code-display relative">
                            <!-- Código principal -->
                            <div class="text-center mb-4">
                                <div class="text-5xl font-black text-yellow-800 epic-title mb-3 tracking-widest" 
                                     id="classroomCode" 
                                     style="font-family: 'Courier New', monospace; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                                    {{ $classroom->class_code ?? 'LOADING' }}
                                </div>
                                <div class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-4 py-2 rounded-full text-sm font-bold inline-block mb-4">
                                    🎯 Comparte este código con tus estudiantes
                                </div>
                            </div>
                            
                            <!-- Instrucciones visuales -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-2">📱</div>
                                    <p class="text-sm font-semibold text-blue-800">Los estudiantes ingresan el código</p>
                                    <p class="text-xs text-blue-600">En la página de unirse al aula</p>
                                </div>
                                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-2">⚡</div>
                                    <p class="text-sm font-semibold text-green-800">Acceso inmediato</p>
                                    <p class="text-xs text-green-600">Se unen automáticamente al aula</p>
                                </div>
                            </div>
                            
                            <!-- Botones de acción mejorados -->
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <button onclick="copyCode('{{ $classroom->class_code }}')" 
                                        class="epic-button green flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold transition-all duration-300 hover:scale-105"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                    <span class="text-lg">📋</span>
                                    <span>Copiar Código</span>
                                </button>
                                
                                <button onclick="regenerateCode()" 
                                        class="epic-button purple flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold transition-all duration-300 hover:scale-105"
                                        style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);">
                                    <span class="text-lg">🔄</span>
                                    <span>Nuevo Código</span>
                                </button>
                                
                                <button onclick="shareCode()" 
                                        class="epic-button yellow flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold transition-all duration-300 hover:scale-105"
                                        style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                    <span class="text-lg">📤</span>
                                    <span>Compartir</span>
                                </button>
                            </div>
                            
                            <!-- Información adicional -->
                            <div class="mt-4 text-center">
                                <p class="text-xs text-gray-600 italic">
                                    💡 Tip: Puedes regenerar el código si necesitas mayor seguridad
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="epic-card p-6">
                        <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
                            <span class="text-2xl mr-3">⚡</span>
                            Acciones Rápidas
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('teacher.classrooms.reports', $classroom) }}" 
                               class="epic-button w-full text-center text-sm py-3">
                                📊 Ver Reportes
                            </a>
                            <a href="{{ route('teacher.behaviors.index') }}" 
   class="epic-button green w-full text-center text-sm py-3">
    ⭐ Gestionar Comportamientos
</a>
                            <a href="{{ route('teacher.rewards.index', ['classroom' => $classroom->id]) }}" 
                               class="epic-button purple w-full text-center text-sm py-3">
                                🎁 Gestionar Recompensas
                            </a>
                            
                            <!-- NUEVOS BOTONES -->
                            <a href="{{ route('teacher.classrooms.import-students-form', $classroom) }}" 
                               class="epic-button yellow w-full text-center text-sm py-3">
                                📤 Importar Estudiantes
                            </a>
                            
                            <button onclick="openPointsModal()" 
                                    class="epic-button red w-full text-center text-sm py-3">
                                ⚖️ Ajustar Puntos
                            </button>
                        </div>
                    </div>

                    <!-- Actividad reciente -->
                    <div class="epic-card p-6">
                        <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
                            <span class="text-2xl mr-3">📈</span>
                            Actividad Reciente
                        </h3>
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @if(isset($recentActivities) && $recentActivities->count() > 0)
                                @foreach($recentActivities as $activity)
                                    <div class="activity-item">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="text-2xl">
                                                    @if(($activity->points_awarded ?? 0) > 0)
                                                        ⭐
                                                    @else
                                                        ⚠️
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-sm">{{ $activity->student->name ?? 'Estudiante' }}</p>
                                                    <p class="text-xs text-gray-600">{{ $activity->behavior->name ?? 'Comportamiento' }}</p>
                                                    <p class="text-xs text-blue-600">{{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Reciente' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold {{ ($activity->points_awarded ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ ($activity->points_awarded ?? 0) > 0 ? '+' : '' }}{{ $activity->points_awarded ?? 0 }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <div class="text-4xl mb-3">📈</div>
                                    <p class="text-sm text-gray-600">No hay actividad reciente</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Botón de regreso -->
            <div class="mt-8 text-center">
                <a href="{{ route('teacher.classrooms.index') }}" 
                   class="epic-button yellow text-lg py-3 px-8">
                    ← Regresar a Mis Aulas
                </a>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PARA AJUSTAR PUNTOS -->
<div id="pointsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 modal">
    <div class="modal-content p-6 m-4 max-w-md w-full">
        <h3 class="text-xl font-bold epic-title mb-4 flex items-center">
            <span class="text-2xl mr-3">⚖️</span>
            Ajustar Puntos Manualmente
        </h3>
        
        <form id="adjustPointsForm">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 epic-title">Estudiante:</label>
                <select id="studentSelect" name="student_id" class="form-input w-full" required>
                    <option value="">Seleccionar estudiante...</option>
                    @if(isset($students))
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 epic-title">Puntos (+/-):</label>
                <input type="number" 
                       id="pointsInput" 
                       name="points" 
                       class="form-input w-full" 
                       min="-1000" 
                       max="1000" 
                       placeholder="Ej: +10 o -5"
                       required>
                <p class="text-xs text-gray-600 mt-1">Número positivo para sumar, negativo para restar</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 epic-title">Razón (opcional):</label>
                <textarea id="reasonInput" 
                          name="reason" 
                          class="form-input w-full" 
                          rows="3" 
                          placeholder="Motivo del ajuste de puntos..."></textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" 
                        class="epic-button green flex-1 text-center py-3">
                    ✅ Ajustar Puntos
                </button>
                <button type="button" 
                        onclick="closePointsModal()" 
                        class="epic-button flex-1 text-center py-3">
                    ❌ Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.epic-card, .stat-card');
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

    // Función mejorada para copiar código
    function copyCode(code) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(code).then(function() {
                // Animación visual del código
                const codeElement = document.getElementById('classroomCode');
                codeElement.classList.add('copy-success');
                
                // Feedback en el botón
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<span class="text-lg">✅</span><span>¡Copiado!</span>';
                button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                
                // Mostrar notificación épica
                showEpicNotification('🎉 ¡Código copiado con éxito!', 'success', code);
                
                // Restaurar después de 2 segundos
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.style.background = '';
                    codeElement.classList.remove('copy-success');
                }, 2000);
            }).catch(function() {
                fallbackCopy(code);
            });
        } else {
            fallbackCopy(code);
        }
    }

    // Función de respaldo para copiar
    function fallbackCopy(code) {
        const textArea = document.createElement('textarea');
        textArea.value = code;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showEpicNotification('📋 Código copiado: ' + code, 'success');
    }

    // Función mejorada para regenerar código
    function regenerateCode() {
        if (confirm('🔄 ¿Regenerar el código de acceso?\n\n⚠️ El código actual dejará de funcionar y tendrás que compartir el nuevo con tus estudiantes.')) {
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            
            // Mostrar estado de carga
            button.innerHTML = '<span class="text-lg animate-spin">⏳</span><span>Generando...</span>';
            button.disabled = true;
            
            fetch("{{ route('teacher.classrooms.regenerate-code', $classroom) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el código con animación
                    const codeElement = document.getElementById('classroomCode');
                    codeElement.style.transform = 'scale(0)';
                    
                    setTimeout(() => {
                        codeElement.textContent = data.new_code;
                        codeElement.style.transform = 'scale(1)';
                        codeElement.style.transition = 'transform 0.3s ease';
                    }, 200);
                    
                    showEpicNotification('🎉 ¡Nuevo código generado!', 'success', data.new_code);
                } else {
                    showEpicNotification('❌ Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showEpicNotification('❌ Error al generar nuevo código', 'error');
            })
            .finally(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
            });
        }
    }

    // Función para compartir código
    function shareCode() {
        const code = document.getElementById('classroomCode').textContent;
        const shareText = `🎓 ¡Únete a mi aula!\n\n🔑 Código: ${code}\n🏫 Aula: {{ $classroom->name }}\n📚 Materia: {{ $classroom->subject }}\n\n💻 Ingresa el código en la plataforma para unirte.`;
        
        if (navigator.share) {
            navigator.share({
                title: 'Código de Acceso - {{ $classroom->name }}',
                text: shareText
            }).catch(console.error);
        } else {
            // Fallback: copiar texto para compartir
            copyCode(shareText);
            showEpicNotification('📤 Texto para compartir copiado al portapapeles', 'info');
        }
    }

    // Notificación épica mejorada
    function showEpicNotification(message, type = 'info', extraInfo = '') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-2xl transform transition-all duration-500 translate-x-full max-w-sm`;
        
        let bgColor, icon;
        switch(type) {
            case 'success':
                bgColor = 'bg-gradient-to-r from-green-500 to-emerald-600';
                icon = '✅';
                break;
            case 'error':
                bgColor = 'bg-gradient-to-r from-red-500 to-rose-600';
                icon = '❌';
                break;
            default:
                bgColor = 'bg-gradient-to-r from-blue-500 to-indigo-600';
                icon = 'ℹ️';
        }
        
        notification.className += ' ' + bgColor + ' text-white';
        
        notification.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="text-2xl">${icon}</div>
                <div class="flex-1">
                    <p class="font-bold text-sm">${message}</p>
                    ${extraInfo ? `<p class="text-xs opacity-90 mt-1 font-mono">${extraInfo}</p>` : ''}
                </div>
                <button onclick="this.parentElement.parentElement.remove()" 
                        class="text-white hover:text-gray-200 text-xl leading-none">
                    ×
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animación de entrada
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        
        // Auto-remover
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 500);
        }, 5000);
    }

    // Funciones del modal de puntos
    function openPointsModal() {
        document.getElementById('pointsModal').classList.remove('hidden');
        document.getElementById('pointsModal').classList.add('flex');
    }

    function closePointsModal() {
        document.getElementById('pointsModal').classList.add('hidden');
        document.getElementById('pointsModal').classList.remove('flex');
        document.getElementById('adjustPointsForm').reset();
    }

    // Manejar envío del formulario de ajuste de puntos
    document.getElementById('adjustPointsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch("{{ route('teacher.classrooms.adjust-points', $classroom) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showEpicNotification(`✅ ${data.message}`, 'success', `Estudiante: ${data.student_name}\nCambio: ${data.points_change > 0 ? '+' : ''}${data.points_change} puntos\nTotal actual: ${data.new_total} puntos`);
                closePointsModal();
                setTimeout(() => location.reload(), 1500); // Recargar para ver los cambios
            } else {
                showEpicNotification('❌ Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showEpicNotification('❌ Error al ajustar puntos', 'error');
        });
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('pointsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePointsModal();
        }
    });

    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePointsModal();
        }
    });
</script>
@endsection