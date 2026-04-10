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

    .epic-button.yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        color: #1f2937;
    }

    .epic-button.yellow:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: #1f2937;
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
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico -->
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold epic-title mb-3" style="font-family: 'Cinzel Decorative', serif; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 0 0 40px rgba(255, 215, 0, 0.6), 0 0 60px rgba(255, 215, 0, 0.4);">
                    ⭐ FORJAR RECOMPENSA ÉPICA ⭐
                </h1>
                <p class="text-lg epic-title">Crea tesoros legendarios para tus aventureros</p>
            </div>

            <!-- Formulario principal -->
            <div class="epic-form-card p-6">
                <form method="POST" action="{{ route('teacher.rewards.store') }}" id="rewardForm">
                    @csrf
                    
                    <!-- Información básica -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">📋</span>
                            Información Básica
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Nombre y Costo -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="epic-label">🎯 Nombre de la Recompensa</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus
                                           class="epic-input"
                                           placeholder="Ej: Stickers Mágicos del Poder">
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="epic-label">💰 Costo en Puntos</label>
                                    <input type="number" 
                                           name="cost_points" 
                                           id="cost_points"
                                           value="{{ old('cost_points', 25) }}" 
                                           required
                                           min="1"
                                           max="10000"
                                           class="epic-input"
                                           placeholder="25">
                                    @error('cost_points')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="epic-label">📜 Descripción</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="2"
                                          required
                                          class="epic-input"
                                          placeholder="Describe el poder de esta recompensa...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
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
                            <!-- Tipo y Rareza -->
                            <div>
                                <label class="epic-label">🔄 Tipo</label>
                                <select name="type" 
                                        id="type" 
                                        required 
                                        onchange="updatePreview()"
                                        class="epic-select">
                                    <option value="">Selecciona el tipo</option>
                                    <option value="xp_boost" {{ old('type') === 'xp_boost' ? 'selected' : '' }}>
                                        ⚡ Boost XP
                                    </option>
                                    <option value="stat_boost" {{ old('type') === 'stat_boost' ? 'selected' : '' }}>
                                        💪 Boost Stats
                                    </option>
                                    <option value="level_boost" {{ old('type') === 'level_boost' ? 'selected' : '' }}>
                                        🚀 Boost Nivel
                                    </option>
                                    <option value="character_upgrade" {{ old('type') === 'character_upgrade' ? 'selected' : '' }}>
                                        ✨ Mejora Personaje
                                    </option>
                                    <option value="special_ability" {{ old('type') === 'special_ability' ? 'selected' : '' }}>
                                        🔮 Habilidad Especial
                                    </option>
                                </select>
                                @error('type')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="epic-label">💎 Rareza</label>
                                <select name="rarity" 
                                        id="rarity" 
                                        required
                                        onchange="updatePreview()"
                                        class="epic-select">
                                    <option value="common" {{ old('rarity', 'common') === 'common' ? 'selected' : '' }}>
                                        ⚪ Común
                                    </option>
                                    <option value="rare" {{ old('rarity') === 'rare' ? 'selected' : '' }}>
                                        🔵 Rara
                                    </option>
                                    <option value="epic" {{ old('rarity') === 'epic' ? 'selected' : '' }}>
                                        🟣 Épica
                                    </option>
                                    <option value="legendary" {{ old('rarity') === 'legendary' ? 'selected' : '' }}>
                                        🟡 Legendaria
                                    </option>
                                </select>
                                @error('rarity')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- XP Bonus y Nivel -->
                            <div>
                                <label class="epic-label">⭐ Bonus XP</label>
                                <input type="number" 
                                       name="xp_bonus" 
                                       id="xp_bonus"
                                       value="{{ old('xp_bonus', 0) }}" 
                                       min="0"
                                       max="1000"
                                       class="epic-input"
                                       placeholder="0">
                                @error('xp_bonus')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="epic-label">🔒 Nivel Requerido</label>
                                <input type="number" 
                                       name="level_requirement" 
                                       id="level_requirement"
                                       value="{{ old('level_requirement', 1) }}" 
                                       min="1"
                                       max="100"
                                       class="epic-input"
                                       placeholder="1">
                                @error('level_requirement')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Selección de aula -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">🏰</span>
                            Aula Destino
                        </h3>
                        
                        <div>
                            <label class="epic-label">🏛️ Seleccionar Aula</label>
                            <select name="classroom_id" 
                                    id="classroom_id" 
                                    required
                                    class="epic-select">
                                <option value="">Selecciona un aula</option>
                                @foreach(auth()->user()->classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                        🏰 {{ $classroom->name }} ({{ $classroom->subject }})
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Campos ocultos -->
                    <input type="hidden" name="reward_type" value="experience">

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <a href="{{ route('teacher.rewards.index') }}" 
                           class="epic-button gray w-full sm:w-auto text-center">
                            ← Cancelar
                        </a>
                        <button type="submit"
                                class="epic-button yellow w-full sm:w-auto">
                            ⭐ FORJAR RECOMPENSA
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vista previa compacta -->
            <div class="epic-form-card p-4 mt-4">
                <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                    <span class="text-xl mr-2">🔮</span>
                    Vista Previa
                </h3>
                <div class="preview-card">
                    <div class="flex items-center space-x-3">
                        <div id="preview-icon" 
                             class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-xl">
                            🎁
                        </div>
                        <div class="flex-1">
                            <h4 id="preview-name" class="font-bold epic-title">
                                Nombre de la Recompensa
                            </h4>
                            <p id="preview-description" class="text-sm text-gray-600">
                                Descripción de la recompensa
                            </p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span id="preview-cost" 
                                      class="inline-block bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                    25 pts
                                </span>
                                <span id="preview-rarity" 
                                      class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    Común
                                </span>
                                <span id="preview-type" 
                                      class="inline-block px-2 py-1 rounded-full text-xs">
                                    Tipo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePreview() {
    const name = document.getElementById('name').value || 'Nombre de la Recompensa';
    const description = document.getElementById('description').value || 'Descripción de la recompensa';
    const cost = document.getElementById('cost_points').value || '25';
    const type = document.getElementById('type').value || '';
    const rarity = document.getElementById('rarity').value || 'common';
    
    document.getElementById('preview-name').textContent = name;
    document.getElementById('preview-description').textContent = description;
    document.getElementById('preview-cost').textContent = cost + ' pts';
    
    // Actualizar rareza
    const rarityMap = {
        'common': { text: 'Común', class: 'bg-gray-100 text-gray-800' },
        'rare': { text: 'Rara', class: 'bg-blue-100 text-blue-800' },
        'epic': { text: 'Épica', class: 'bg-purple-100 text-purple-800' },
        'legendary': { text: 'Legendaria', class: 'bg-yellow-100 text-yellow-800' }
    };
    
    const rarityInfo = rarityMap[rarity] || rarityMap['common'];
    const rarityElement = document.getElementById('preview-rarity');
    rarityElement.textContent = rarityInfo.text;
    rarityElement.className = 'inline-block px-2 py-1 rounded-full text-xs ' + rarityInfo.class;
    
    // Actualizar tipo
    const typeMap = {
        'xp_boost': { text: '⚡ Boost XP', class: 'bg-yellow-100 text-yellow-800' },
        'stat_boost': { text: '💪 Boost Stats', class: 'bg-red-100 text-red-800' },
        'level_boost': { text: '🚀 Boost Nivel', class: 'bg-green-100 text-green-800' },
        'character_upgrade': { text: '✨ Mejora', class: 'bg-purple-100 text-purple-800' },
        'special_ability': { text: '🔮 Habilidad', class: 'bg-indigo-100 text-indigo-800' }
    };
    
    const typeInfo = typeMap[type] || { text: 'Tipo', class: 'bg-gray-100 text-gray-800' };
    const typeElement = document.getElementById('preview-type');
    typeElement.textContent = typeInfo.text;
    typeElement.className = 'inline-block px-2 py-1 rounded-full text-xs ' + typeInfo.class;
    
    // Actualizar icono
    const iconMap = {
        'xp_boost': '⚡',
        'stat_boost': '💪',
        'level_boost': '🚀',
        'character_upgrade': '✨',
        'special_ability': '🔮'
    };
    
    let icon = iconMap[type] || '🎁';
    if (rarity === 'legendary') icon = '🌟';
    else if (rarity === 'epic') icon = '👑';
    else if (rarity === 'rare') icon = '💎';
    
    document.getElementById('preview-icon').textContent = icon;
}

document.addEventListener('DOMContentLoaded', function() {
    // Actualizar preview cuando cambien los campos
    ['name', 'description', 'cost_points', 'type', 'rarity'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });
    
    updatePreview();
    
    // Validación del formulario
    document.getElementById('rewardForm').addEventListener('submit', function(e) {
        const cost = parseInt(document.getElementById('cost_points').value);
        const type = document.getElementById('type').value;
        
        if (cost < 1 || cost > 10000) {
            e.preventDefault();
            alert('El costo debe estar entre 1 y 10,000 puntos');
            return false;
        }
        
        if (!type) {
            e.preventDefault();
            alert('Debe seleccionar un tipo de recompensa');
            return false;
        }
    });
});
</script>
@endsection