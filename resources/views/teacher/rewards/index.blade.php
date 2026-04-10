@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    .epic-form-card {
        backdrop-filter: blur(20px);
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
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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
        font-family: 'Cinzel', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
        position: relative;
        overflow: hidden;
        min-height: 36px;
    }

    .epic-button.primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .epic-button.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .epic-button.danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    .epic-button.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #1f2937;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
    }

    

    .stats-card {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(203, 213, 225, 0.6);
        border-radius: 8px;
        padding: 8px;
        width: 100%;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-card .number {
        font-size: 18px;
        font-weight: 900;
        line-height: 1;
    }

    /* Estilos específicos de rareza para recompensas */
    .reward-card {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        will-change: transform, box-shadow;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
    }

    .reward-card:hover {
        transform: translateY(-6px) scale(1.03);
        z-index: 10;
    }

    /* Legendary */
    .reward-card[data-rarity="legendary"] {
        border-image: linear-gradient(45deg, #fbbf24, #f59e0b, #fbbf24) 1;
        background: linear-gradient(135deg, 
            rgba(251, 191, 36, 0.1) 0%, 
            rgba(255, 255, 255, 0.95) 20%, 
            rgba(255, 255, 255, 0.95) 80%, 
            rgba(251, 191, 36, 0.1) 100%);
        animation: legendary-glow 3s ease-in-out infinite alternate;
        box-shadow: 0 0 30px rgba(251, 191, 36, 0.3);
    }

    /* Epic */
    .reward-card[data-rarity="epic"] {
        border-image: linear-gradient(45deg, #a855f7, #9333ea, #a855f7) 1;
        background: linear-gradient(135deg, 
            rgba(168, 85, 247, 0.1) 0%, 
            rgba(255, 255, 255, 0.95) 20%, 
            rgba(255, 255, 255, 0.95) 80%, 
            rgba(168, 85, 247, 0.1) 100%);
        animation: epic-pulse 2.5s ease-in-out infinite;
        box-shadow: 0 0 25px rgba(168, 85, 247, 0.3);
    }

    /* Rare */
    .reward-card[data-rarity="rare"] {
        border-image: linear-gradient(45deg, #3b82f6, #2563eb, #3b82f6) 1;
        background: linear-gradient(135deg, 
            rgba(59, 130, 246, 0.1) 0%, 
            rgba(255, 255, 255, 0.95) 20%, 
            rgba(255, 255, 255, 0.95) 80%, 
            rgba(59, 130, 246, 0.1) 100%);
        animation: rare-shimmer 4s linear infinite;
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }

    /* Common */
    .reward-card[data-rarity="common"] {
        border-image: linear-gradient(45deg, #6b7280, #4b5563, #6b7280) 1;
        background: linear-gradient(135deg, 
            rgba(107, 114, 128, 0.05) 0%, 
            rgba(255, 255, 255, 0.95) 20%, 
            rgba(255, 255, 255, 0.95) 80%, 
            rgba(107, 114, 128, 0.05) 100%);
    }

    /* Animaciones */
    @keyframes legendary-glow {
        0% { box-shadow: 0 0 30px rgba(251, 191, 36, 0.3); }
        100% { box-shadow: 0 0 50px rgba(251, 191, 36, 0.6); }
    }

    @keyframes epic-pulse {
        0%, 100% { 
            box-shadow: 0 0 25px rgba(168, 85, 247, 0.3);
            transform: scale(1);
        }
        50% { 
            box-shadow: 0 0 40px rgba(168, 85, 247, 0.6);
            transform: scale(1.01);
        }
    }

    @keyframes rare-shimmer {
        0% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
        25% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.5); }
        50% { box-shadow: 0 0 25px rgba(59, 130, 246, 0.4); }
        75% { box-shadow: 0 0 35px rgba(59, 130, 246, 0.6); }
        100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
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

    .filter-button {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 2px solid rgba(203, 213, 225, 0.6);
        color: #6b7280;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border-radius: 12px;
        font-family: 'Cinzel', serif;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 10px 16px;
    }

    .filter-button.active {
        border-color: rgba(59, 130, 246, 0.6);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.1) 100%);
        color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .filter-button:hover {
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .notification {
        z-index: 9999;
        font-family: 'Cinzel', serif;
        font-weight: 600;
    }

    .paused-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 20;
        border-radius: inherit;
    }

    .paused-badge {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-family: 'Cinzel', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.3);
        font-size: 0.75rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico principal -->
            <div class="text-center mb-6">
                <h1 class="text-6xl font-bold epic-title mb-4" style="font-family: 'Cinzel Decorative', serif; text-shadow: 0 0 20px rgba(255, 215, 0, 0.8), 0 0 40px rgba(255, 215, 0, 0.6), 0 0 60px rgba(255, 215, 0, 0.4);">
                    ⭐ ARSENAL DE RECOMPENSAS ÉPICAS ⭐
                </h1>
                <p class="text-3xl font-bold epic-title mb-6 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                    FORJA TESOROS LEGENDARIOS PARA TUS AVENTUREROS
                </p>
                <p class="text-gray-600 mb-6 text-xl">Administra las recompensas que motivarán a tus estudiantes en su épica aventura de aprendizaje</p>
                
                <!-- Botón crear recompensa épico -->
                <div class="mb-6">
                    <a href="{{ route('teacher.rewards.create') }}" 
                       class="epic-button warning text-xl px-8 py-4 inline-flex items-center space-x-3">
                        <span class="text-2xl">✨</span>
                        <span>FORJAR NUEVA RECOMPENSA</span>
                        <span class="text-2xl">🔨</span>
                    </a>
                </div>

                <!-- Filtros con estadísticas debajo -->
                <div class="epic-form-card p-6 mb-8">
                    <div class="flex justify-center gap-4">
                        <!-- Todas -->
                        <div class="flex flex-col items-center">
                            <button class="filter-button active w-full mb-2" data-filter="all">
                                🎁 Todas
                            </button>
                            <div class="stats-card">
                                <div class="number text-gray-700 epic-title">{{ $rewards->count() }}</div>
                            </div>
                        </div>

                        <!-- Comunes -->
                        <div class="text-center">
                            <button class="filter-button w-full mb-2" data-filter="common">
                                ⚪ Comunes
                            </button>
                            <div class="stats-card">
                                <div class="number text-gray-700 epic-title">{{ $rewards->where('rarity', 'common')->count() }}</div>
                            </div>
                        </div>

                        <!-- Raras -->
                        <div class="text-center">
                            <button class="filter-button w-full mb-2" data-filter="rare">
                                🔵 Raras
                            </button>
                            <div class="stats-card">
                                <div class="number text-blue-700 epic-title">{{ $rewards->where('rarity', 'rare')->count() }}</div>
                            </div>
                        </div>

                        <!-- Épicas -->
                        <div class="text-center">
                            <button class="filter-button w-full mb-2" data-filter="epic">
                                🟣 Épicas
                            </button>
                            <div class="stats-card">
                                <div class="number text-purple-700 epic-title">{{ $rewards->where('rarity', 'epic')->count() }}</div>
                            </div>
                        </div>

                        <!-- Legendarias -->
                        <div class="text-center">
                            <button class="filter-button w-full mb-2" data-filter="legendary">
                                🟡 Legendarias
                            </button>
                            <div class="stats-card">
                                <div class="number text-yellow-700 epic-title">{{ $rewards->where('rarity', 'legendary')->count() }}</div>
                            </div>
                        </div>

                        <!-- Pausadas -->
                        <div class="text-center">
                            <button class="filter-button w-full mb-2" data-filter="inactive">
                                ⏸️ Pausadas
                            </button>
                            <div class="stats-card">
                                <div class="number text-red-700 epic-title">{{ $rewards->where('is_active', false)->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            

            <!-- Grid de recompensas en 3 columnas -->
            @if($rewards->isEmpty())
                <div class="epic-form-card p-12 text-center">
                    <div class="text-6xl mb-4">🎁</div>
                    <h3 class="text-3xl font-bold epic-title mb-4">Arsenal Vacío</h3>
                    <p class="text-gray-600 text-lg max-w-lg mx-auto mb-6">Tu arsenal de recompensas está esperando ser llenado con tesoros épicos.</p>
                    <a href="{{ route('teacher.rewards.create') }}" 
                       class="epic-button warning text-lg px-6 py-3 inline-flex items-center space-x-2">
                        <span class="text-xl">⚔️</span>
                        <span>CREAR PRIMERA RECOMPENSA</span>
                        <span class="text-xl">✨</span>
                    </a>
                </div>
            @else
                <div id="rewards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($rewards as $reward)
                        <div class="reward-card epic-form-card shadow-lg hover:shadow-2xl transition-all duration-400 overflow-hidden relative min-h-[280px]" 
                             data-rarity="{{ $reward->rarity }}" 
                             data-active="{{ $reward->is_active ? 'true' : 'false' }}"
                             id="reward-card-{{ $reward->id }}">
                            
                            <!-- Header compacto de la carta -->
                            <div class="p-3 relative overflow-hidden">
                                <div class="absolute inset-0 opacity-20" style="background: linear-gradient(135deg, 
                                    @if($reward->rarity === 'legendary') #fbbf24, #f59e0b
                                    @elseif($reward->rarity === 'epic') #a855f7, #9333ea
                                    @elseif($reward->rarity === 'rare') #3b82f6, #2563eb
                                    @else #6b7280, #4b5563 @endif
                                );"></div>
                                
                                <div class="relative z-10">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="text-3xl filter drop-shadow-lg">{{ $reward->icon }}</div>
                                        <span class="px-2 py-1 rounded-full text-xs font-bold epic-title text-white shadow-lg" style="background: linear-gradient(135deg, 
                                            @if($reward->rarity === 'legendary') #fbbf24, #f59e0b
                                            @elseif($reward->rarity === 'epic') #a855f7, #9333ea
                                            @elseif($reward->rarity === 'rare') #3b82f6, #2563eb
                                            @else #6b7280, #4b5563 @endif
                                        );">
                                            {{ ucfirst($reward->rarity) }}
                                        </span>
                                    </div>
                                    <h3 class="text-sm font-bold epic-title mb-2 text-gray-800 line-clamp-2">{{ $reward->name }}</h3>
                                    <p class="text-gray-600 text-xs leading-relaxed line-clamp-2">{{ $reward->description }}</p>
                                </div>
                            </div>

                            <!-- Contenido compacto de la carta -->
                            <div class="p-3 pt-0 flex flex-col justify-between flex-1">
                                <!-- Características épicas condensadas -->
                                <div class="space-y-2 mb-3">
                                    @if($reward->xp_bonus > 0)
                                        <div class="flex items-center space-x-2 text-xs bg-yellow-50 p-2 rounded-md border border-yellow-200">
                                            <div class="w-6 h-6 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white text-xs">⚡</span>
                                            </div>
                                            <span class="text-gray-700 font-bold epic-title">+{{ $reward->xp_bonus }} XP</span>
                                        </div>
                                    @endif

                                    @if($reward->level_requirement > 1)
                                        <div class="flex items-center space-x-2 text-xs bg-blue-50 p-2 rounded-md border border-blue-200">
                                            <div class="w-6 h-6 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white text-xs">🔒</span>
                                            </div>
                                            <span class="text-gray-600 epic-title">Nivel {{ $reward->level_requirement }}</span>
                                        </div>
                                    @endif

                                    @if($reward->character_specific)
                                        <div class="flex items-center space-x-2 text-xs bg-purple-50 p-2 rounded-md border border-purple-200">
                                            <div class="w-6 h-6 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white text-xs">👤</span>
                                            </div>
                                            <span class="text-gray-600 epic-title">Específico</span>
                                        </div>
                                    @endif

                                    @if($reward->duration_hours)
                                        <div class="flex items-center space-x-2 text-xs bg-green-50 p-2 rounded-md border border-green-200">
                                            <div class="w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white text-xs">⏰</span>
                                            </div>
                                            <span class="text-gray-600 epic-title">{{ $reward->duration_hours }}h</span>
                                        </div>
                                    @endif

                                    @if($reward->stock_quantity !== null)
                                        <div class="flex items-center space-x-2 text-xs bg-orange-50 p-2 rounded-md border border-orange-200">
                                            <div class="w-6 h-6 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full flex items-center justify-center shadow-sm">
                                                <span class="text-white text-xs">📦</span>
                                            </div>
                                            <span class="text-gray-600 epic-title">Stock: {{ $reward->stock_quantity }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Precio compacto -->
                                <div class="mb-3">
                                    <div class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-3 py-2 rounded-lg shadow-lg text-center">
                                        <span class="text-lg font-bold epic-title block">{{ $reward->cost_points }}</span>
                                        <span class="text-xs opacity-90 epic-title">Puntos</span>
                                    </div>
                                </div>

                                <!-- Botones de acción alineados -->
                                <div class="space-y-2 mt-auto">
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('teacher.rewards.edit', $reward) }}" 
                                           class="epic-button primary text-center py-2 text-xs">
                                            <span class="mr-1">📝</span>
                                            <span>Editar</span>
                                        </a>
                                        
                                        <button onclick="toggleRewardStatus('{{ $reward->id }}')" 
                                                id="toggleBtn-{{ $reward->id }}"
                                                class="epic-button {{ $reward->is_active ? 'danger' : 'success' }} py-2 text-xs"
                                                title="{{ $reward->is_active ? 'Pausar' : 'Reanudar' }} recompensa">
                                            <span id="toggleIcon-{{ $reward->id }}" class="mr-1">{{ $reward->is_active ? '⏸️' : '▶️' }}</span>
                                            <span id="toggleText-{{ $reward->id }}">{{ $reward->is_active ? 'Pausar' : 'Activar' }}</span>
                                        </button>
                                    </div>
                                    
                                    @if($reward->is_active && $reward->studentRewards()->where('status', 'pending')->count() > 0)
                                        <button onclick="approveAllPending('{{ $reward->id }}')"
                                                class="epic-button success w-full py-2 text-xs"
                                                title="Aprobar todas las solicitudes pendientes">
                                            <span class="mr-1">✅</span>
                                            <span>Aprobar ({{ $reward->studentRewards()->where('status', 'pending')->count() }})</span>
                                        </button>
                                    @endif
                                </div>

                                <!-- Estadísticas de uso compactas -->
                                @if($reward->studentRewards()->count() > 0)
                                    <div class="mt-2 p-2 bg-gray-50 rounded-md border text-xs">
                                        <div class="text-gray-600 epic-title text-center">
                                            <div class="flex justify-between items-center">
                                                <span>📊 Canjeada:</span>
                                                <span class="font-bold">{{ $reward->studentRewards()->where('status', 'approved')->count() }}</span>
                                            </div>
                                            @if($reward->studentRewards()->where('status', 'pending')->count() > 0)
                                                <div class="flex justify-between items-center mt-1">
                                                    <span>⏳ Pendientes:</span>
                                                    <span class="font-bold text-orange-600">{{ $reward->studentRewards()->where('status', 'pending')->count() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Overlay para recompensas pausadas -->
                            @if(!$reward->is_active)
                                <div class="paused-overlay">
                                    <div class="paused-badge">
                                       ⏸️ PAUSADA
                                   </div>
                               </div>
                           @endif

                           <!-- Indicador de rareza brillante más pequeño -->
                           <div class="absolute top-1 left-1 w-3 h-3 rounded-full animate-pulse" style="background: 
                               @if($reward->rarity === 'legendary') linear-gradient(45deg, #fbbf24, #f59e0b)
                               @elseif($reward->rarity === 'epic') linear-gradient(45deg, #a855f7, #9333ea)
                               @elseif($reward->rarity === 'rare') linear-gradient(45deg, #3b82f6, #2563eb)
                               @else linear-gradient(45deg, #6b7280, #4b5563) @endif
                           ; box-shadow: 0 0 8px 
                               @if($reward->rarity === 'legendary') rgba(251, 191, 36, 0.6)
                               @elseif($reward->rarity === 'epic') rgba(168, 85, 247, 0.6)
                               @elseif($reward->rarity === 'rare') rgba(59, 130, 246, 0.6)
                               @else rgba(107, 114, 128, 0.4) @endif
                           ;"></div>
                       </div>
                   @endforeach
               </div>
           @endif
       </div>
   </div>
</div>

<!-- Notificaciones épicas -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script>
// Función mejorada para alternar estado de recompensa
function toggleRewardStatus(rewardId) {
   const button = document.getElementById(`toggleBtn-${rewardId}`);
   const icon = document.getElementById(`toggleIcon-${rewardId}`);
   const text = document.getElementById(`toggleText-${rewardId}`);
   const card = document.getElementById(`reward-card-${rewardId}`);
   
   if (!button || !icon || !text || !card) {
       showNotification('Error: No se encontraron los elementos necesarios', 'error');
       return;
   }
   
   button.disabled = true;
   const originalIcon = icon.innerHTML;
   const originalText = text.innerHTML;
   icon.innerHTML = '⚡';
   text.innerHTML = 'Procesando...';
   
   fetch(`/teacher/rewards/${rewardId}/toggle-status`, {
       method: 'PATCH',
       headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
       }
   })
   .then(response => {
       if (!response.ok) {
           throw new Error(`Error HTTP: ${response.status}`);
       }
       return response.json();
   })
   .then(data => {
       if (data.success) {
           const isActive = data.is_active;
           
           button.classList.remove('danger', 'success');
           button.classList.add(isActive ? 'danger' : 'success');
           
           icon.innerHTML = isActive ? '⏸️' : '▶️';
           text.innerHTML = isActive ? 'Pausar' : 'Reanudar';
           button.title = `${isActive ? 'Pausar' : 'Reanudar'} recompensa`;
           
           updatePausedOverlay(card, isActive);
           card.setAttribute('data-active', isActive ? 'true' : 'false');
           
           showNotification(`✨ ${data.message}`, 'success');
           
           card.style.transform = 'scale(1.05)';
           setTimeout(() => {
               card.style.transform = '';
           }, 300);
           
       } else {
           throw new Error(data.message || 'Error desconocido');
       }
   })
   .catch(error => {
       console.error('Error:', error);
       icon.innerHTML = originalIcon;
       text.innerHTML = originalText;
       showNotification(`❌ Error: ${error.message}`, 'error');
   })
   .finally(() => {
       button.disabled = false;
   });
}

// Función para aprobar todas las solicitudes pendientes
function approveAllPending(rewardId) {
   if (!confirm('¿Estás seguro de que quieres aprobar todas las solicitudes pendientes de esta recompensa?')) {
       return;
   }
   
   const button = event.target;
   const originalHTML = button.innerHTML;
   button.disabled = true;
   button.innerHTML = '<span class="animate-spin mr-1">⚡</span>Procesando...';
   
   fetch(`/teacher/rewards/${rewardId}/approve-all-pending`, {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
       }
   })
   .then(response => response.json())
   .then(data => {
       if (data.success) {
           showNotification(`✅ ${data.message}`, 'success');
           setTimeout(() => location.reload(), 2000);
       } else {
           throw new Error(data.message || 'Error al aprobar solicitudes');
       }
   })
   .catch(error => {
       console.error('Error:', error);
       showNotification(`❌ Error: ${error.message}`, 'error');
       button.disabled = false;
       button.innerHTML = originalHTML;
   });
}

// Función para actualizar overlay de pausada
function updatePausedOverlay(card, isActive) {
   const existingOverlay = card.querySelector('.paused-overlay');
   
   if (!isActive && !existingOverlay) {
       const overlay = document.createElement('div');
       overlay.className = 'paused-overlay';
       overlay.innerHTML = '<div class="paused-badge">⏸️ PAUSADA</div>';
       card.appendChild(overlay);
       
       overlay.style.opacity = '0';
       setTimeout(() => {
           overlay.style.transition = 'opacity 0.3s ease';
           overlay.style.opacity = '1';
       }, 10);
       
   } else if (isActive && existingOverlay) {
       existingOverlay.style.transition = 'opacity 0.3s ease';
       existingOverlay.style.opacity = '0';
       setTimeout(() => {
           existingOverlay.remove();
       }, 300);
   }
}

// Función mejorada para mostrar notificaciones épicas
function showNotification(message, type) {
   const container = document.getElementById('notification-container');
   
   const notification = document.createElement('div');
   notification.className = `notification bg-white rounded-xl shadow-2xl p-4 border-l-4 transform transition-all duration-500 translate-x-full max-w-sm ${
       type === 'success' ? 'border-green-500' : 'border-red-500'
   }`;
   
   notification.innerHTML = `
       <div class="flex items-center space-x-3">
           <div class="flex-shrink-0 text-2xl">
               ${type === 'success' ? '✅' : '❌'}
           </div>
           <div class="flex-1">
               <p class="font-medium epic-title text-gray-800">${message}</p>
           </div>
           <button onclick="this.parentElement.parentElement.remove()" 
                   class="flex-shrink-0 ml-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
               ×
           </button>
       </div>
   `;
   
   container.appendChild(notification);
   
   setTimeout(() => notification.classList.remove('translate-x-full'), 100);
   
   setTimeout(() => {
       notification.classList.add('translate-x-full');
       setTimeout(() => notification.remove(), 500);
   }, 5000);
}

// Sistema de filtros épico mejorado
document.addEventListener('DOMContentLoaded', function() {
   const filterButtons = document.querySelectorAll('.filter-button');
   const rewardCards = document.querySelectorAll('.reward-card');
   const statsCards = document.querySelectorAll('.stats-card');
   
   // Inicializar filtros
   filterButtons.forEach(button => {
       button.addEventListener('click', function() {
           const filter = this.dataset.filter;
           
           filterButtons.forEach(btn => {
               btn.classList.remove('active');
               btn.style.transform = 'scale(1)';
           });
           this.classList.add('active');
           this.style.transform = 'scale(1.05)';
           setTimeout(() => {
               this.style.transform = 'scale(1)';
           }, 200);
           
           let visibleCount = 0;
           rewardCards.forEach((card, index) => {
               const rarity = card.dataset.rarity;
               const isActive = card.dataset.active === 'true';
               let shouldShow = false;
               
               switch(filter) {
                   case 'all':
                       shouldShow = true;
                       break;
                   case 'inactive':
                       shouldShow = !isActive;
                       break;
                   case 'common':
                   case 'rare':
                   case 'epic':
                   case 'legendary':
                       shouldShow = rarity === filter;
                       break;
               }
               
               if (shouldShow) {
                   card.style.display = 'block';
                   setTimeout(() => {
                       card.style.opacity = '1';
                       card.style.transform = 'translateY(0) scale(1)';
                   }, visibleCount * 100);
                   visibleCount++;
               } else {
                   card.style.opacity = '0';
                   card.style.transform = 'translateY(20px) scale(0.95)';
                   setTimeout(() => {
                       card.style.display = 'none';
                   }, 300);
               }
           });
           
           statsCards.forEach(statsCard => {
               if (statsCard.dataset.filter === filter || filter === 'all') {
                   statsCard.style.transform = 'scale(1.1)';
                   statsCard.style.boxShadow = '0 20px 40px rgba(59, 130, 246, 0.3)';
                   setTimeout(() => {
                       statsCard.style.transform = 'scale(1)';
                       statsCard.style.boxShadow = '';
                   }, 300);
               }
           });
       });
   });
   
   // Hacer las estadísticas clickeables para filtrar
   statsCards.forEach(statsCard => {
       if (statsCard.dataset.filter) {
           statsCard.addEventListener('click', function() {
               const filterButton = document.querySelector(`[data-filter="${this.dataset.filter}"]`);
               if (filterButton) {
                   filterButton.click();
               }
           });
           
           statsCard.style.cursor = 'pointer';
       }
   });
   
   // Inicializar animaciones de entrada
   rewardCards.forEach((card, index) => {
       card.style.opacity = '0';
       card.style.transform = 'translateY(30px)';
       setTimeout(() => {
           card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
           card.style.opacity = '1';
           card.style.transform = 'translateY(0)';
       }, index * 150);
   });
   
   // Efectos de hover mejorados para las cartas
   rewardCards.forEach(card => {
       card.addEventListener('mouseenter', function() {
           const rarity = this.dataset.rarity;
           
           switch(rarity) {
               case 'legendary':
                   this.style.boxShadow = '0 0 60px rgba(251, 191, 36, 0.9), 0 20px 40px rgba(0, 0, 0, 0.2)';
                   break;
               case 'epic':
                   this.style.boxShadow = '0 0 50px rgba(168, 85, 247, 0.9), 0 20px 40px rgba(0, 0, 0, 0.2)';
                   break;
               case 'rare':
                   this.style.boxShadow = '0 0 40px rgba(59, 130, 246, 0.9), 0 20px 40px rgba(0, 0, 0, 0.2)';
                   break;
               default:
                   this.style.boxShadow = '0 0 30px rgba(156, 163, 175, 0.7), 0 20px 40px rgba(0, 0, 0, 0.2)';
           }
       });
       
       card.addEventListener('mouseleave', function() {
           this.style.boxShadow = '';
       });
   });
});
</script>
@endsection