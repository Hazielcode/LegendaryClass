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

    .epic-button.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .epic-button.green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
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
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico -->
            <div class="text-center mb-6">
                <h1 class="text-8xl font-bold epic-title mb-6 animate-pulse" style="font-family: 'Cinzel Decorative', serif; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 0 0 40px rgba(255, 215, 0, 0.6), 0 0 60px rgba(255, 215, 0, 0.4);">
                    🏰 CREAR AULA MÁGICA 🏰
                </h1>
                <p class="text-base epic-title">Funda tu nuevo dominio de aprendizaje</p>
            </div>

            <!-- Formulario épico -->
            <div class="epic-form-card p-4">
                <form method="POST" action="{{ route('teacher.classrooms.store') }}">
                    @csrf

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
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus
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
                                          placeholder="Describe tu aula...">{{ old('description') }}</textarea>
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
                                    <option value="Matemáticas" {{ old('subject') === 'Matemáticas' ? 'selected' : '' }}>🔢 Matemáticas</option>
                                    <option value="Ciencias" {{ old('subject') === 'Ciencias' ? 'selected' : '' }}>🧪 Ciencias</option>
                                    <option value="Lengua" {{ old('subject') === 'Lengua' ? 'selected' : '' }}>📖 Lengua</option>
                                    <option value="Historia" {{ old('subject') === 'Historia' ? 'selected' : '' }}>🏛️ Historia</option>
                                    <option value="Geografía" {{ old('subject') === 'Geografía' ? 'selected' : '' }}>🗺️ Geografía</option>
                                    <option value="Arte" {{ old('subject') === 'Arte' ? 'selected' : '' }}>🎨 Arte</option>
                                    <option value="Educación Física" {{ old('subject') === 'Educación Física' ? 'selected' : '' }}>⚽ Ed. Física</option>
                                    <option value="Inglés" {{ old('subject') === 'Inglés' ? 'selected' : '' }}>🇺🇸 Inglés</option>
                                    <option value="Otro" {{ old('subject') === 'Otro' ? 'selected' : '' }}>✨ Otro</option>
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
                                    <option value="1° Primaria" {{ old('grade_level') === '1° Primaria' ? 'selected' : '' }}>1° Primaria</option>
                                    <option value="2° Primaria" {{ old('grade_level') === '2° Primaria' ? 'selected' : '' }}>2° Primaria</option>
                                    <option value="3° Primaria" {{ old('grade_level') === '3° Primaria' ? 'selected' : '' }}>3° Primaria</option>
                                    <option value="4° Primaria" {{ old('grade_level') === '4° Primaria' ? 'selected' : '' }}>4° Primaria</option>
                                    <option value="5° Primaria" {{ old('grade_level') === '5° Primaria' ? 'selected' : '' }}>5° Primaria</option>
                                    <option value="6° Primaria" {{ old('grade_level') === '6° Primaria' ? 'selected' : '' }}>6° Primaria</option>
                                    <option value="1° Secundaria" {{ old('grade_level') === '1° Secundaria' ? 'selected' : '' }}>1° Secundaria</option>
                                    <option value="2° Secundaria" {{ old('grade_level') === '2° Secundaria' ? 'selected' : '' }}>2° Secundaria</option>
                                    <option value="3° Secundaria" {{ old('grade_level') === '3° Secundaria' ? 'selected' : '' }}>3° Secundaria</option>
                                    <option value="4° Secundaria" {{ old('grade_level') === '4° Secundaria' ? 'selected' : '' }}>4° Secundaria</option>
                                    <option value="5° Secundaria" {{ old('grade_level') === '5° Secundaria' ? 'selected' : '' }}>5° Secundaria</option>
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
                                <div class="bg-white/20 rounded p-2 border border-green-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="allow_student_rewards" name="settings[allow_student_rewards]" value="1" checked
                                               class="epic-checkbox">
                                        <label for="allow_student_rewards" class="epic-label text-xs">
                                            🎁 Canje de recompensas
                                        </label>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded p-2 border border-yellow-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="public_leaderboard" name="settings[public_leaderboard]" value="1"
                                               class="epic-checkbox">
                                        <label for="public_leaderboard" class="epic-label text-xs">
                                            🏆 Tabla pública
                                        </label>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded p-2 border border-blue-200">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="parent_notifications" name="settings[parent_notifications]" value="1" checked
                                               class="epic-checkbox">
                                        <label for="parent_notifications" class="epic-label text-xs">
                                            📧 Notificaciones
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones épicos -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <<a href="{{ route('teacher.classrooms.index') }}" 
                           class="epic-button gray text-xs py-2 px-3 w-full sm:w-auto text-center">
                            ← Cancelar
                        </a>
                        <button type="submit"
                                class="epic-button green text-3xl py-6 px-12 w-full sm:w-auto">
                            🏰 FUNDAR AULA MÁGICA
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vista previa épica -->
            <div class="epic-form-card p-4 mt-4">
                <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                    <span class="text-xl mr-2">🔮</span>
                    Vista Previa
                </h3>
                <div id="preview" class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg p-4 border border-blue-300">
                    <div class="flex items-center space-x-3">
                        <div class="text-3xl">🏰</div>
                        <div class="flex-1">
                            <h4 id="preview-name" class="text-lg font-bold epic-title">Tu Aula Mágica</h4>
                            <p id="preview-details" class="text-sm text-blue-600 font-semibold">Materia • Grado</p>
                            <p id="preview-description" class="text-xs text-gray-600">Descripción de tu aula...</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-bold">
                                NUEVO
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Vista previa en tiempo real
    function updatePreview() {
        const name = document.querySelector('input[name="name"]').value || 'Tu Aula Mágica';
        const subject = document.querySelector('select[name="subject"]').value || 'Materia';
        const grade = document.querySelector('select[name="grade_level"]').value || 'Grado';
        const description = document.querySelector('textarea[name="description"]').value || 'Descripción de tu aula mágica donde los estudiantes se convertirán en leyendas del aprendizaje...';

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-details').textContent = `${subject} • ${grade}`;
        document.getElementById('preview-description').textContent = description;
    }

    // Event listeners para actualización en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        ['input[name="name"]', 'select[name="subject"]', 'select[name="grade_level"]', 'textarea[name="description"]'].forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                element.addEventListener('input', updatePreview);
                element.addEventListener('change', updatePreview);
            }
        });
        
        updatePreview();
    });

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