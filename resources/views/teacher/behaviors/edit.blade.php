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
        padding: 0.5rem 0.75rem;
        width: 100%;
    }

    .epic-input:focus {
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.9) 100%);
        outline: none;
    }

    .epic-button {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-family: 'Cinzel', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        cursor: pointer;
        font-size: 0.875rem;
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
        margin-bottom: 0.25rem;
        display: block;
        font-size: 0.875rem;
    }

    .epic-select {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: 'Playfair Display', serif;
        padding: 0.5rem 0.75rem;
        width: 100%;
    }

    .epic-select:focus {
        border-color: rgba(59, 130, 246, 0.6);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    .preview-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        border: 2px solid rgba(59, 130, 246, 0.2);
        border-radius: 16px;
        padding: 1rem;
    }

    .error-message {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #dc2626;
        padding: 0.25rem 0.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .status-section {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
        border: 2px solid rgba(245, 158, 11, 0.2);
        border-radius: 16px;
        padding: 1rem;
    }

    .checkbox-epic {
        transform: scale(1.2);
        accent-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico -->
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold epic-title mb-3" style="font-family: 'Cinzel Decorative', serif; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 0 0 40px rgba(255, 215, 0, 0.6), 0 0 60px rgba(255, 215, 0, 0.4);">
                    ⚡ EDITAR COMPORTAMIENTO ÉPICO ⚡
                </h1>
                <p class="text-lg epic-title">Modifica el sistema de recompensas: <strong>{{ $behavior->name }}</strong></p>
            </div>

            <!-- Información actual del comportamiento -->
            <div class="epic-form-card p-4 mb-4">
                <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                    <span class="text-xl mr-2">📋</span>
                    Comportamiento Actual
                </h3>
                <div class="preview-card">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 {{ $behavior->type === 'positive' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded-full flex items-center justify-center font-bold">
                            {{ $behavior->points > 0 ? '+' : '' }}{{ $behavior->points }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold epic-title">{{ $behavior->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $behavior->description }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ ucfirst($behavior->category) }}
                                </span>
                                <span class="inline-block {{ $behavior->type === 'positive' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full text-xs">
                                    {{ $behavior->type === 'positive' ? '✅ Positivo' : '❌ Negativo' }}
                                </span>
                                @if(!$behavior->is_active)
                                    <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                        ⏸️ Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div class="epic-form-card p-6">
                <form method="POST" action="{{ route('teacher.behaviors.update', $behavior) }}" id="behaviorForm">
                    @csrf
                    @method('PUT')

                    <!-- Información básica -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">📝</span>
                            Editar Información
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Nombre del comportamiento -->
                            <div>
                                <label class="epic-label">🎯 Nombre del Comportamiento</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old('name', $behavior->name) }}" 
                                       required 
                                       autofocus
                                       class="epic-input"
                                       placeholder="Nombre del comportamiento">
                                @if($errors->has('name'))
                                    <div class="error-message">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="epic-label">📜 Descripción</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="2"
                                          class="epic-input"
                                          placeholder="Descripción del comportamiento">{{ old('description', $behavior->description) }}</textarea>
                                @if($errors->has('description'))
                                    <div class="error-message">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Configuración -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">⚖️</span>
                            Configuración
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Tipo de comportamiento -->
                            <div>
                                <label class="epic-label">🔄 Tipo</label>
                                <select name="type" 
                                        id="type" 
                                        required 
                                        onchange="updatePointsValidation()"
                                        class="epic-select">
                                    <option value="positive" {{ old('type', $behavior->type) === 'positive' ? 'selected' : '' }}>
                                        ✅ Positivo
                                    </option>
                                    <option value="negative" {{ old('type', $behavior->type) === 'negative' ? 'selected' : '' }}>
                                        ❌ Negativo
                                    </option>
                                </select>
                                @if($errors->has('type'))
                                    <div class="error-message">{{ $errors->first('type') }}</div>
                                @endif
                            </div>

                            <!-- Puntos -->
                            <div>
                                <label class="epic-label">🏆 Puntos</label>
                                <input type="number" 
                                       name="points" 
                                       id="points"
                                       value="{{ old('points', $behavior->points) }}" 
                                       required
                                       min="-100"
                                       max="100"
                                       class="epic-input"
                                       placeholder="Cantidad">
                                @if($errors->has('points'))
                                    <div class="error-message">{{ $errors->first('points') }}</div>
                                @endif
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label class="epic-label">📊 Categoría</label>
                                <select name="category" 
                                        id="category" 
                                        required
                                        class="epic-select">
                                    <option value="participation" {{ old('category', $behavior->category) === 'participation' ? 'selected' : '' }}>
                                        🙋 Participación
                                    </option>
                                    <option value="homework" {{ old('category', $behavior->category) === 'homework' ? 'selected' : '' }}>
                                        📝 Tareas
                                    </option>
                                    <option value="behavior" {{ old('category', $behavior->category) === 'behavior' ? 'selected' : '' }}>
                                        😊 Comportamiento
                                    </option>
                                    <option value="creativity" {{ old('category', $behavior->category) === 'creativity' ? 'selected' : '' }}>
                                        🎨 Creatividad
                                    </option>
                                    <option value="teamwork" {{ old('category', $behavior->category) === 'teamwork' ? 'selected' : '' }}>
                                        🤝 Trabajo en Equipo
                                    </option>
                                    <option value="punctuality" {{ old('category', $behavior->category) === 'punctuality' ? 'selected' : '' }}>
                                        ⏰ Puntualidad
                                    </option>
                                    <option value="respect" {{ old('category', $behavior->category) === 'respect' ? 'selected' : '' }}>
                                        🤲 Respeto
                                    </option>
                                    <option value="effort" {{ old('category', $behavior->category) === 'effort' ? 'selected' : '' }}>
                                        💪 Esfuerzo
                                    </option>
                                </select>
                                @if($errors->has('category'))
                                    <div class="error-message">{{ $errors->first('category') }}</div>
                                @endif
                            </div>

                            <!-- Color personalizado -->
                            <div>
                                <label class="epic-label">🎨 Color</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" 
                                           name="color" 
                                           id="color"
                                           value="{{ old('color', $behavior->color ?? '#3B82F6') }}"
                                           class="h-10 w-16 border-2 border-gray-300 rounded-lg cursor-pointer">
                                    <span class="text-xs text-gray-600">Color representativo</span>
                                </div>
                                @if($errors->has('color'))
                                    <div class="error-message">{{ $errors->first('color') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 mt-2">
                            <span id="points-help">Los puntos pueden ser de -100 a +100</span>
                        </div>
                    </div>

                    <!-- Estado del comportamiento -->
                    <div class="mb-6">
                        <div class="status-section">
                            <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                                <span class="text-xl mr-2">⚙️</span>
                                Estado del Comportamiento
                            </h3>
                            
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $behavior->is_active) ? 'checked' : '' }}
                                       class="checkbox-epic">
                                <label for="is_active" class="epic-label">
                                    🔄 Comportamiento Activo
                                </label>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">
                                Si está inactivo, no se podrá asignar a estudiantes, pero se mantendrán los registros existentes.
                            </p>
                            @if($errors->has('is_active'))
                                <div class="error-message">{{ $errors->first('is_active') }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.behaviors.index', ['classroom' => $behavior->classroom_id]) }}" 
                               class="epic-button gray text-center">
                                ← Volver
                            </a>
                            <a href="{{ route('teacher.behaviors.show', $behavior) }}" 
                               class="epic-button text-center">
                                👁️ Ver
                            </a>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit"
                                    class="epic-button orange">
                                ⚡ ACTUALIZAR COMPORTAMIENTO
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Vista previa de cambios -->
            <div class="epic-form-card p-4 mt-4">
                <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                    <span class="text-xl mr-2">🔮</span>
                    Vista Previa de Cambios
                </h3>
                <div class="preview-card">
                    <div class="flex items-center space-x-3">
                        <div id="preview-badge" 
                             class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">
                            {{ $behavior->points > 0 ? '+' : '' }}{{ $behavior->points }}
                        </div>
                        <div class="flex-1">
                            <h4 id="preview-name" class="font-bold epic-title">
                                {{ $behavior->name }}
                            </h4>
                            <p id="preview-description" class="text-sm text-gray-600">
                                {{ $behavior->description }}
                            </p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span id="preview-category" 
                                      class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ ucfirst($behavior->category) }}
                                </span>
                                <span id="preview-type" 
                                      class="inline-block px-2 py-1 rounded-full text-xs">
                                    {{ $behavior->type === 'positive' ? '✅ Positivo' : '❌ Negativo' }}
                                </span>
                                <span id="preview-status" 
                                      class="inline-block px-2 py-1 rounded-full text-xs">
                                    {{ $behavior->is_active ? '🟢 Activo' : '🔴 Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de eliminación -->
            @if($behavior->studentBehaviors()->count() === 0)
                <div class="epic-form-card p-4 mt-4 border-red-200">
                    <h3 class="text-lg font-bold epic-title mb-3 flex items-center text-red-600">
                        <span class="text-xl mr-2">⚠️</span>
                        Zona de Peligro
                    </h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Este comportamiento no ha sido utilizado aún. Puedes eliminarlo permanentemente.
                    </p>
                    <form action="{{ route('teacher.behaviors.destroy', $behavior) }}" 
                          method="POST" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este comportamiento? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="epic-button red">
                            🗑️ Eliminar Comportamiento
                        </button>
                    </form>
                </div>
            @else
                <div class="epic-form-card p-4 mt-4 border-blue-200">
                    <h3 class="text-lg font-bold epic-title mb-3 flex items-center text-blue-600">
                        <span class="text-xl mr-2">📊</span>
                        Información de Uso
                    </h3>
                    <p class="text-sm text-gray-600">
                        Este comportamiento ha sido utilizado <strong>{{ $behavior->studentBehaviors()->count() }} veces</strong>. 
                        No se puede eliminar, pero puedes desactivarlo si ya no lo necesitas.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function updatePointsValidation() {
        const type = document.getElementById('type').value;
        const pointsInput = document.getElementById('points');
        const helpText = document.getElementById('points-help');
        
        if (type === 'positive') {
            helpText.textContent = 'Para comportamientos positivos, usa números positivos (1 a 100)';
            pointsInput.min = '1';
            pointsInput.max = '100';
        } else if (type === 'negative') {
            helpText.textContent = 'Para comportamientos negativos, usa números negativos (-1 a -100)';
            pointsInput.min = '-100';
            pointsInput.max = '-1';
        }
        
        updatePreview();
    }

    function updatePreview() {
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        const points = document.getElementById('points').value;
        const category = document.getElementById('category').value;
        const type = document.getElementById('type').value;
        const isActive = document.getElementById('is_active').checked;

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-description').textContent = description;
        
        const categoryMap = {
            'participation': '🙋 Participación',
            'homework': '📝 Tareas',
            'behavior': '😊 Comportamiento',
            'creativity': '🎨 Creatividad',
            'teamwork': '🤝 Trabajo en Equipo',
            'punctuality': '⏰ Puntualidad',
            'respect': '🤲 Respeto',
            'effort': '💪 Esfuerzo'
        };
        document.getElementById('preview-category').textContent = categoryMap[category] || category;
        
        const badge = document.getElementById('preview-badge');
        badge.textContent = (points > 0 && type === 'positive' ? '+' : '') + points;
        
        if (type === 'positive') {
            badge.className = 'w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold';
            document.getElementById('preview-type').textContent = '✅ Positivo';
            document.getElementById('preview-type').className = 'inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs';
        } else {
            badge.className = 'w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center font-bold';
            document.getElementById('preview-type').textContent = '❌ Negativo';
            document.getElementById('preview-type').className = 'inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs';
        }

        // Actualizar estado
        if (isActive) {
            document.getElementById('preview-status').textContent = '🟢 Activo';
            document.getElementById('preview-status').className = 'inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs';
        } else {
            document.getElementById('preview-status').textContent = '🔴 Inactivo';
            document.getElementById('preview-status').className = 'inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        ['name', 'description', 'points', 'category', 'type', 'is_active'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', updatePreview);
                element.addEventListener('change', updatePreview);
            }
        });
        
        updatePointsValidation();
        updatePreview();
    });

    document.getElementById('behaviorForm').addEventListener('submit', function(e) {
        const type = document.getElementById('type').value;
        const points = parseInt(document.getElementById('points').value);
        
        if (type === 'positive' && points <= 0) {
            e.preventDefault();
            alert('Los comportamientos positivos deben tener puntos positivos');
            return false;
        }
        
        if (type === 'negative' && points >= 0) {
            e.preventDefault();
            alert('Los comportamientos negativos deben tener puntos negativos');
            return false;
        }
    });
</script>
@endsection