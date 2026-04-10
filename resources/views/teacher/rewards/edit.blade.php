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

    .epic-button.orange {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
    }

    .epic-button.orange:hover {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
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

    .error-message {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #dc2626;
        padding: 0.25rem 0.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .stats-mini {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-item {
        flex: 1;
        text-align: center;
        padding: 0.75rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .epic-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .epic-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
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
                    ✏️ PERFECCIONAR RECOMPENSA ÉPICA ✏️
                </h1>
                <p class="text-lg epic-title">Modifica: {{ $reward->name }}</p>
            </div>

            <!-- Estadísticas mini -->
            <div class="stats-mini">
                <div class="stat-item">
                    <div class="text-2xl mb-1">📊</div>
                    <div class="text-lg font-bold epic-title text-blue-600">{{ $reward->studentRewards()->count() }}</div>
                    <div class="text-xs text-gray-600 epic-title">Canjes</div>
                </div>
                <div class="stat-item">
                    <div class="text-2xl mb-1">✅</div>
                    <div class="text-lg font-bold epic-title text-green-600">{{ $reward->studentRewards()->where('status', 'approved')->count() }}</div>
                    <div class="text-xs text-gray-600 epic-title">Aprobados</div>
                </div>
                <div class="stat-item">
                    <div class="text-2xl mb-1">⏳</div>
                    <div class="text-lg font-bold epic-title text-yellow-600">{{ $reward->studentRewards()->where('status', 'pending')->count() }}</div>
                    <div class="text-xs text-gray-600 epic-title">Pendientes</div>
                </div>
            </div>

            <!-- Formulario principal -->
            <div class="epic-form-card p-6">
                <form method="POST" action="{{ route('teacher.rewards.update', $reward) }}" id="rewardEditForm">
                    @csrf
                    @method('PUT')
                    
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
                                           value="{{ old('name', $reward->name) }}" 
                                           required 
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
                                           value="{{ old('cost_points', $reward->cost_points) }}" 
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
                                          placeholder="Describe el poder de esta recompensa...">{{ old('description', $reward->description) }}</textarea>
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
                                        class="epic-select">
                                    <option value="">Selecciona el tipo</option>
                                    <option value="xp_boost" {{ old('type', $reward->type) === 'xp_boost' ? 'selected' : '' }}>
                                        ⚡ Boost XP
                                    </option>
                                    <option value="stat_boost" {{ old('type', $reward->type) === 'stat_boost' ? 'selected' : '' }}>
                                        💪 Boost Stats
                                    </option>
                                    <option value="level_boost" {{ old('type', $reward->type) === 'level_boost' ? 'selected' : '' }}>
                                        🚀 Boost Nivel
                                    </option>
                                    <option value="character_upgrade" {{ old('type', $reward->type) === 'character_upgrade' ? 'selected' : '' }}>
                                        ✨ Mejora Personaje
                                    </option>
                                    <option value="special_ability" {{ old('type', $reward->type) === 'special_ability' ? 'selected' : '' }}>
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
                                        class="epic-select">
                                    <option value="common" {{ old('rarity', $reward->rarity) === 'common' ? 'selected' : '' }}>
                                        ⚪ Común
                                    </option>
                                    <option value="rare" {{ old('rarity', $reward->rarity) === 'rare' ? 'selected' : '' }}>
                                        🔵 Rara
                                    </option>
                                    <option value="epic" {{ old('rarity', $reward->rarity) === 'epic' ? 'selected' : '' }}>
                                        🟣 Épica
                                    </option>
                                    <option value="legendary" {{ old('rarity', $reward->rarity) === 'legendary' ? 'selected' : '' }}>
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
                                       value="{{ old('xp_bonus', $reward->xp_bonus ?? 0) }}" 
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
                                       value="{{ old('level_requirement', $reward->level_requirement ?? 1) }}" 
                                       min="1"
                                       max="100"
                                       class="epic-input"
                                       placeholder="1">
                                @error('level_requirement')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stock y Duración -->
                            <div>
                                <label class="epic-label">📦 Stock</label>
                                <input type="number" 
                                       name="stock_quantity" 
                                       id="stock_quantity"
                                       value="{{ old('stock_quantity', $reward->stock_quantity) }}" 
                                       min="0"
                                       class="epic-input"
                                       placeholder="Ilimitado">
                                @error('stock_quantity')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="epic-label">⏰ Duración (horas)</label>
                                <input type="number" 
                                       name="duration_hours" 
                                       id="duration_hours"
                                       value="{{ old('duration_hours', $reward->duration_hours) }}" 
                                       min="1"
                                       max="8760"
                                       class="epic-input"
                                       placeholder="Permanente">
                                @error('duration_hours')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Estado Activo -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                            <span class="text-xl mr-2">🔧</span>
                            Estado
                        </h3>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-bold epic-title">Recompensa Activa</h4>
                                <p class="text-sm text-gray-600">Los estudiantes pueden canjearla</p>
                            </div>
                            <label class="epic-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $reward->is_active) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Campos ocultos -->
                    <input type="hidden" name="reward_type" value="{{ $reward->reward_type ?? 'experience' }}">

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <a href="{{ route('teacher.rewards.index') }}" 
                           class="epic-button gray w-full sm:w-auto text-center">
                            ← Cancelar
                        </a>
                        <div class="flex space-x-2">
                            <button type="submit"
                                    class="epic-button orange">
                                💾 GUARDAR
                            </button>
                            <button type="button" 
                                    onclick="confirmDelete()"
                                    class="epic-button red"
                                    {{ $reward->studentRewards()->count() > 0 ? 'disabled title="No se puede eliminar una recompensa con canjes"' : '' }}>
                                🗑️ ELIMINAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Canjes recientes (solo si hay) -->
            @if($reward->studentRewards()->count() > 0)
                <div class="epic-form-card p-4 mt-4">
                    <h3 class="text-lg font-bold epic-title mb-3 flex items-center">
                        <span class="text-xl mr-2">📜</span>
                        Canjes Recientes
                    </h3>
                    
                    <div class="space-y-2">
                        @foreach($reward->studentRewards()->with('student')->latest()->take(3)->get() as $studentReward)
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <div class="flex items-center space-x-3">
                                    <div class="text-lg">
                                        @if($studentReward->status === 'approved') ✅
                                        @elseif($studentReward->status === 'pending') ⏳
                                        @elseif($studentReward->status === 'cancelled') ❌
                                        @else 📦 @endif
                                    </div>
                                    <div>
                                        <h5 class="font-bold epic-title text-sm">{{ $studentReward->student->name ?? 'Estudiante' }}</h5>
                                        <p class="text-xs text-gray-600">{{ $studentReward->redeemed_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-bold epic-title
                                    {{ $studentReward->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $studentReward->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $studentReward->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($studentReward->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Formulario de eliminación oculto -->
            <form id="delete-form" action="{{ route('teacher.rewards.destroy', $reward) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    const redemptionCount = {{ $reward->studentRewards()->count() }};
    
    if (redemptionCount > 0) {
        alert('No se puede eliminar una recompensa que tiene canjes registrados.');
        return;
    }
    
    if (confirm('¿Estás seguro de que quieres eliminar esta recompensa épica?\n\nEsta acción no se puede deshacer.')) {
        document.getElementById('delete-form').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    document.getElementById('rewardEditForm').addEventListener('submit', function(e) {
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