@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    .epic-form-card {
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
    
    .epic-form-card:hover {
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

    .epic-input {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: 'Playfair Display', serif;
    }

    .epic-input:focus {
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.9) 100%);
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

    .epic-button.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .epic-button.orange:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .epic-button.gray {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }

    .epic-button.gray:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
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

    .epic-label {
        font-family: 'Cinzel', serif;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .epic-select {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: 'Playfair Display', serif;
    }

    .epic-select:focus {
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
    }

    .epic-checkbox {
        transform: scale(1.2);
        accent-color: #3b82f6;
    }

    .config-section {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .code-section {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.1) 100%);
        border: 2px solid rgba(245, 158, 11, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .students-section {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .student-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .student-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico -->
            <div class="text-center mb-6">
                <h1 class="text-8xl font-bold epic-title mb-6 animate-pulse" style="font-family: 'Cinzel Decorative', serif; text-shadow: 0 0 20px rgba(255, 165, 0, 0.8), 0 0 40px rgba(255, 165, 0, 0.6), 0 0 60px rgba(255, 165, 0, 0.4);">
                    ⚔️ MODIFICAR AULA MÁGICA ⚔️
                </h1>
                <p class="text-base epic-title">Modifica tu dominio de aprendizaje: <span class="text-orange-600">{{ $classroom->name }}</span></p>
            </div>

            <!-- Formulario épico -->
            <div class="epic-form-card p-4">
                <form method="POST" action="{{ route('teacher.classrooms.update', $classroom) }}">
                    @csrf
                    @method('PUT')

                    <!-- Sección de Información Básica -->
                    <div class="mb-4">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">📋</span>
                            Información Básica
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Nombre del Aula -->
                            <div>
                                <label class="block epic-label text-sm mb-1">🎯 Nombre del Aula</label>
                                <input type="text" name="name" value="{{ old('name', $classroom->name) }}" required autofocus
                                       class="epic-input w-full px-3 py-2 text-sm"
                                       placeholder="Ej: Aula de Aventureros Nivel 5">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="block epic-label text-sm mb-1">📜 Descripción (Opcional)</label>
                                <textarea name="description" rows="2"
                                          class="epic-input w-full px-3 py-2 text-xs"
                                          placeholder="Describe tu aula...">{{ old('description', $classroom->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Especialización -->
                    <div class="mb-4">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">🎭</span>
                            Especialización
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                            <!-- Materia -->
                            <div>
                                <label class="block epic-label text-sm mb-1">📚 Materia</label>
                                <select name="subject" required class="epic-select w-full px-3 py-2 text-xs">
                                    <option value="">Selecciona materia</option>
                                    @foreach(['Matemáticas' => '🔢 Matemáticas', 'Ciencias' => '🧪 Ciencias', 'Lengua' => '📖 Lengua', 'Historia' => '🏛️ Historia', 'Geografía' => '🗺️ Geografía', 'Arte' => '🎨 Arte', 'Educación Física' => '⚽ Ed. Física', 'Inglés' => '🇺🇸 Inglés', 'Otro' => '✨ Otro'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('subject', $classroom->subject) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Grado -->
                            <div>
                                <label class="block epic-label text-sm mb-1">🎓 Grado</label>
                                <select name="grade_level" required class="epic-select w-full px-3 py-2 text-xs">
                                    <option value="">Selecciona grado</option>
                                    @foreach(['1° Primaria', '2° Primaria', '3° Primaria', '4° Primaria', '5° Primaria', '6° Primaria', '1° Secundaria', '2° Secundaria', '3° Secundaria', '4° Secundaria', '5° Secundaria'] as $grade)
                                        <option value="{{ $grade }}" {{ old('grade_level', $classroom->grade_level) === $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                    @endforeach
                                </select>
                                @error('grade_level')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Configuraciones Mágicas -->
                    <div class="mb-4">
                        <div class="config-section">
                            <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                                <span class="text-xl mr-2">⚙️</span>
                                Configuraciones
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-2">
                                @php
                                    $settings = $classroom->settings ?? [];
                                @endphp
                                
                                <div class="bg-white/20 rounded p-2 border border-green-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="allow_student_rewards" name="settings[allow_student_rewards]" value="1" 
                                               {{ ($settings['allow_student_rewards'] ?? true) ? 'checked' : '' }}
                                               class="epic-checkbox">
                                        <label for="allow_student_rewards" class="epic-label text-xs">
                                            🎁 Canje de recompensas
                                        </label>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded p-2 border border-yellow-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="public_leaderboard" name="settings[public_leaderboard]" value="1"
                                               {{ ($settings['public_leaderboard'] ?? false) ? 'checked' : '' }}
                                               class="epic-checkbox">
                                        <label for="public_leaderboard" class="epic-label text-xs">
                                            🏆 Tabla pública
                                        </label>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded p-2 border border-blue-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="parent_notifications" name="settings[parent_notifications]" value="1" 
                                               {{ ($settings['parent_notifications'] ?? true) ? 'checked' : '' }}
                                               class="epic-checkbox">
                                        <label for="parent_notifications" class="epic-label text-xs">
                                            📧 Notificaciones
                                        </label>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded p-2 border border-purple-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ $classroom->is_active ? 'checked' : '' }}
                                               class="epic-checkbox">
                                        <label for="is_active" class="epic-label text-xs">
                                            ✅ Aula activa
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones épicos -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                           class="epic-button gray text-xs py-2 px-3 w-full sm:w-auto text-center">
                            ← Regresar
                        </a>
                        <button type="submit"
                                class="epic-button orange text-3xl py-6 px-12 w-full sm:w-auto">
                            ⚔️ ACTUALIZAR AULA
                        </button>
                    </div>
                </form>
            </div>

            <!-- Código del aula -->
            <div class="epic-form-card p-4 mt-4">
                <div class="code-section">
                    <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                        <span class="text-xl mr-2">🔑</span>
                        Código Mágico de Acceso
                    </h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-yellow-800 font-bold text-2xl epic-title">{{ $classroom->class_code }}</div>
                            <p class="text-xs text-yellow-700">Los estudiantes usan este código para unirse</p>
                        </div>
                        <button onclick="regenerateCode()" 
                                class="epic-button orange text-xs py-2 px-3">
                            🔄 Regenerar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Estudiantes inscritos -->
            @if($classroom->student_ids && count($classroom->student_ids) > 0)
                <div class="epic-form-card p-4 mt-4">
                    <div class="students-section">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">⚔️</span>
                            Aventureros del Reino ({{ count($classroom->student_ids) }})
                        </h3>
                        
                        <div class="space-y-2">
                            @foreach(\App\Models\User::whereIn('_id', $classroom->student_ids)->get() as $student)
                                <div class="student-card flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            {{ substr($student->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <h4 class="epic-label text-sm">{{ $student->name }}</h4>
                                            <p class="text-xs text-gray-600">{{ $student->email }}</p>
                                        </div>
                                    </div>
                                    <button onclick="removeStudent('{{ $student->id }}')" 
                                            class="epic-button red text-xs py-1 px-2">
                                        🗑️
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function regenerateCode() {
        if (confirm('¿Estás seguro? El código anterior dejará de funcionar.')) {
            fetch('{{ route("teacher.classrooms.regenerate-code", $classroom) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    function removeStudent(studentId) {
        if (confirm('¿Estás seguro de que quieres remover este estudiante del aula?')) {
            fetch('{{ route("teacher.classrooms.remove-student", $classroom) }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ student_id: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.epic-form-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
</script>
@endsection