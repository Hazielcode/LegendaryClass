@extends('layouts.app')

@push('styles')
<style>
/* Fuentes épicas */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.store-bg {
    background: url('/fondo.png') center/cover;
    min-height: 100vh;
    position: relative;
}

.store-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(147, 51, 234, 0.1) 0%, 
        rgba(79, 70, 229, 0.1) 50%, 
        rgba(147, 51, 234, 0.1) 100%);
    z-index: 1;
}

.store-content {
    position: relative;
    z-index: 2;
}

.store-header {
    background: linear-gradient(135deg, 
        rgba(147, 51, 234, 0.95) 0%, 
        rgba(79, 70, 229, 0.9) 50%,
        rgba(147, 51, 234, 0.95) 100%);
    backdrop-filter: blur(20px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 24px;
    box-shadow: 0 15px 40px rgba(147, 51, 234, 0.3);
    color: white;
    position: relative;
    overflow: hidden;
}

.store-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(300%); }
}

.store-title {
    font-family: 'Cinzel Decorative', serif;
    font-size: 3.5rem;
    font-weight: 900;
    text-align: center;
    margin-bottom: 1rem;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    letter-spacing: 0.1em;
}

.points-display {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #92400e;
    padding: 1.5rem;
    border-radius: 16px;
    text-align: center;
    font-family: 'Cinzel', serif;
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 30px rgba(251, 191, 36, 0.4);
}

.points-number {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.points-label {
    font-size: 1.2rem;
    font-weight: bold;
    opacity: 0.9;
}

.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.reward-card {
    background: linear-gradient(135deg, 
        rgba(255, 255, 255, 0.95) 0%, 
        rgba(255, 255, 255, 0.9) 100%);
    border: 3px solid rgba(147, 51, 234, 0.2);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    overflow: hidden;
    position: relative;
}

.reward-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 50px rgba(147, 51, 234, 0.3);
    border-color: rgba(147, 51, 234, 0.4);
}

.reward-header {
    padding: 1.5rem;
    text-align: center;
    position: relative;
}

.reward-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    display: block;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
}

.reward-name {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.reward-description {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.4;
}

.reward-body {
    padding: 0 1.5rem 1.5rem;
}

.reward-features {
    margin-bottom: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: #4b5563;
}

.feature-icon {
    margin-right: 0.5rem;
    font-size: 1rem;
}

.reward-footer {
    padding: 1rem 1.5rem;
    background: rgba(147, 51, 234, 0.05);
    border-top: 1px solid rgba(147, 51, 234, 0.1);
}

.cost-display {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-family: 'Cinzel', serif;
}

.cost-number {
    font-size: 2rem;
    font-weight: 900;
    color: #7c3aed;
    margin-right: 0.5rem;
}

.cost-icon {
    font-size: 1.5rem;
}

.buy-button {
    width: 100%;
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
    color: white;
    padding: 1rem;
    border-radius: 12px;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    font-size: 1.1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.buy-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.buy-button:hover::before {
    left: 100%;
}

.buy-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
    background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
}

.buy-button:disabled {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.buy-button:disabled:hover::before {
    left: -100%;
}

.rarity-common { border-left: 6px solid #9ca3af; }
.rarity-rare { border-left: 6px solid #3b82f6; }
.rarity-epic { border-left: 6px solid #7c3aed; }
.rarity-legendary { border-left: 6px solid #fbbf24; }

.rarity-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.rarity-common .rarity-badge { background: #f3f4f6; color: #374151; }
.rarity-rare .rarity-badge { background: #dbeafe; color: #1e40af; }
.rarity-epic .rarity-badge { background: #ede9fe; color: #5b21b6; }
.rarity-legendary .rarity-badge { background: #fef3c7; color: #92400e; }

.requirements-section {
    margin-bottom: 1rem;
    padding: 1rem;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 8px;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.requirements-title {
    font-weight: bold;
    color: #dc2626;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.requirement-item {
    font-size: 0.8rem;
    color: #7f1d1d;
    margin-bottom: 0.25rem;
}

.empty-store {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    border-radius: 20px;
    border: 3px solid rgba(147, 51, 234, 0.2);
    backdrop-filter: blur(15px);
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.empty-title {
    font-family: 'Cinzel Decorative', serif;
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
}

.empty-description {
    color: #6b7280;
    font-size: 1.125rem;
    max-width: 500px;
    margin: 0 auto;
}

.filters-section {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 2px solid rgba(147, 51, 234, 0.1);
}

.filter-button {
    background: rgba(147, 51, 234, 0.1);
    color: #7c3aed;
    border: 2px solid rgba(147, 51, 234, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-button.active,
.filter-button:hover {
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
    color: white;
}

/* Animaciones */
.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

.fade-in-delay {
    animation: fadeInUp 0.6s ease-out;
    animation-delay: 0.2s;
    animation-fill-mode: both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .store-title {
        font-size: 2.5rem;
    }
    
    .rewards-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .points-number {
        font-size: 2rem;
    }
}
</style>
@endpush

@section('content')
<div class="store-bg">
    <div class="store-content py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header de la tienda -->
            <div class="store-header p-8 mb-8 fade-in">
                <h1 class="store-title">🛒 TIENDA LEGENDARIA</h1>
                <p class="text-center text-xl opacity-90 mb-6">
                    Canjea tus puntos por recompensas épicas y poderes legendarios
                </p>
                
                <!-- Display de puntos -->
                <div class="max-w-sm mx-auto">
                    <div class="points-display">
                        <div class="points-number">{{ auth()->user()->points ?? 0 }}</div>
                        <div class="points-label">💎 Puntos Disponibles</div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="filters-section fade-in-delay">
                <h3 class="font-bold text-lg mb-3 text-gray-800">🔍 Filtrar Recompensas:</h3>
                <div class="flex flex-wrap">
                    <button class="filter-button active" data-filter="all">Todas</button>
                    <button class="filter-button" data-filter="common">Comunes</button>
                    <button class="filter-button" data-filter="rare">Raras</button>
                    <button class="filter-button" data-filter="epic">Épicas</button>
                    <button class="filter-button" data-filter="legendary">Legendarias</button>
                    <button class="filter-button" data-filter="affordable">Alcanzables</button>
                </div>
            </div>

            <!-- Grid de recompensas -->
            @if(isset($availableRewards) && $availableRewards->isNotEmpty())
                <div class="rewards-grid fade-in-delay">
                    @foreach($availableRewards as $reward)
                        <div class="reward-card rarity-{{ $reward->rarity ?? 'common' }}" 
                             data-rarity="{{ $reward->rarity ?? 'common' }}"
                             data-cost="{{ $reward->cost_points ?? $reward->cost ?? 25 }}">
                            
                            <!-- Badge de rareza -->
                            <div class="rarity-badge">{{ ucfirst($reward->rarity ?? 'common') }}</div>
                            
                            <!-- Header de la recompensa -->
                            <div class="reward-header">
                                <span class="reward-icon">{{ $reward->icon ?? '🎁' }}</span>
                                <h3 class="reward-name">{{ $reward->name ?? 'Recompensa Épica' }}</h3>
                                <p class="reward-description">{{ $reward->description ?? 'Una recompensa legendaria que te ayudará en tu aventura' }}</p>
                            </div>

                            <!-- Cuerpo de la recompensa -->
                            <div class="reward-body">
                                <!-- Características -->
                                <div class="reward-features">
                                    @if($reward->xp_bonus ?? 0 > 0)
                                        <div class="feature-item">
                                            <span class="feature-icon">✨</span>
                                            <span>+{{ $reward->xp_bonus }} XP Bonus</span>
                                        </div>
                                    @endif
                                    
                                    @if($reward->stat_bonuses ?? [])
                                        @foreach($reward->stat_bonuses as $stat => $bonus)
                                            <div class="feature-item">
                                                <span class="feature-icon">📈</span>
                                                <span>+{{ $bonus }} {{ ucfirst($stat) }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    @if($reward->duration_hours ?? 0 > 0)
                                        <div class="feature-item">
                                            <span class="feature-icon">⏰</span>
                                            <span>Duración: {{ $reward->duration_hours }} horas</span>
                                        </div>
                                    @endif
                                    
                                    @if($reward->type === 'permanent')
                                        <div class="feature-item">
                                            <span class="feature-icon">♾️</span>
                                            <span>Efecto Permanente</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Requisitos -->
                                @if(($reward->level_requirement ?? 0) > (auth()->user()->level ?? 1) || 
                                    ($reward->character_specific ?? []) && !in_array(auth()->user()->character_type, $reward->character_specific))
                                    <div class="requirements-section">
                                        <div class="requirements-title">❗ Requisitos:</div>
                                        
                                        @if(($reward->level_requirement ?? 0) > (auth()->user()->level ?? 1))
                                            <div class="requirement-item">
                                                🔒 Nivel {{ $reward->level_requirement }} requerido (Tu nivel: {{ auth()->user()->level ?? 1 }})
                                            </div>
                                        @endif
                                        
                                        @if(($reward->character_specific ?? []) && !in_array(auth()->user()->character_type, $reward->character_specific))
                                            <div class="requirement-item">
                                                👥 Solo para: {{ implode(', ', $reward->character_specific) }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Footer con precio y botón -->
                            <div class="reward-footer">
                                <div class="cost-display">
                                    <span class="cost-number">{{ $reward->cost_points ?? $reward->cost ?? 25 }}</span>
                                    <span class="cost-icon">💎</span>
                                </div>
                                
                                @php
                                    $canAfford = (auth()->user()->points ?? 0) >= ($reward->cost_points ?? $reward->cost ?? 25);
                                    $meetsRequirements = ($reward->level_requirement ?? 0) <= (auth()->user()->level ?? 1) &&
                                                       (empty($reward->character_specific) || in_array(auth()->user()->character_type, $reward->character_specific));
                                @endphp
                                
                                <button onclick="buyReward({{ $reward->id ?? $reward->_id ?? 1 }})" 
                                        class="buy-button"
                                        {{ !$canAfford || !$meetsRequirements ? 'disabled' : '' }}>
                                    @if(!$meetsRequirements)
                                        🔒 No Disponible
                                    @elseif(!$canAfford)
                                        💸 Puntos Insuficientes
                                    @else
                                        🛒 Canjear Recompensa
                                    @endif
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vacío -->
                <div class="empty-store fade-in-delay">
                    <div class="empty-icon">🏪</div>
                    <h2 class="empty-title">¡Tienda en Construcción!</h2>
                    <p class="empty-description">
                        Los comerciantes legendarios están preparando increíbles recompensas para ti. 
                        ¡Pronto habrá tesoros épicos disponibles para canjear!
                    </p>
                </div>
            @endif

            <!-- Sección de recompensas obtenidas -->
            <div class="mt-12 fade-in-delay">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 font-serif mb-2">🎒 Mis Recompensas</h2>
                    <p class="text-gray-600">Recompensas que has canjeado recientemente</p>
                </div>
                
                @if(isset($myRewards) && $myRewards->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myRewards as $studentReward)
                            <div class="bg-white border-2 border-purple-200 rounded-lg p-4 shadow-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">{{ $studentReward->reward->icon ?? '🎁' }}</span>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $studentReward->reward->name ?? 'Recompensa' }}</h4>
                                            <p class="text-sm text-gray-600">{{ $studentReward->redeemed_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <span class="text-lg">{{ $studentReward->getStatusIcon() }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-purple-600 font-semibold">{{ $studentReward->points_spent }} 💎</span>
                                    <span class="px-2 py-1 rounded-full text-xs {{ $studentReward->getStatusColor() }}">
                                        {{ $studentReward->getStatusText() }}
                                    </span>
                                </div>
                                
                                @if($studentReward->expires_at && !$studentReward->is_permanent)
                                    <div class="mt-2 text-xs text-gray-500">
                                        ⏰ Expira: {{ $studentReward->expires_at->diffForHumans() }}
                                    </div>
                                @elseif($studentReward->is_permanent)
                                    <div class="mt-2 text-xs text-green-600">
                                        ♾️ Efecto Permanente
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-white rounded-lg border-2 border-gray-200">
                        <div class="text-4xl mb-4">🎒</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Aún no tienes recompensas</h3>
                        <p class="text-gray-500">¡Canjea tu primera recompensa arriba!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones -->
<div id="notification-container" class="fixed top-6 right-6 z-50 space-y-4"></div>
@endsection

@push('scripts')
<script>
// Variables globales
let userPoints = {{ auth()->user()->points ?? 0 }};

// Función para comprar recompensa
function buyReward(rewardId) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Deshabilitar botón
    button.disabled = true;
    button.innerHTML = '⏳ Canjeando...';
    
    fetch(`/students/rewards/${rewardId}/buy`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar puntos del usuario
            userPoints = data.remaining_points;
            updatePointsDisplay();
            
            // Mostrar notificación de éxito
            showNotification(`🎉 ¡${data.reward_name || 'Recompensa'} canjeada exitosamente!`, 'success');
            
            // Si hay efectos, mostrarlos
            if (data.effects) {
                if (data.xp_gained) {
                    showNotification(`✨ ¡Ganaste ${data.xp_gained} XP adicional!`, 'bonus');
                }
            }
            
            // Actualizar el botón
            button.innerHTML = '✅ Canjeado';
            
            // Recargar página después de 2 segundos para mostrar cambios
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            
        } else {
            showNotification('❌ ' + (data.message || 'Error al canjear la recompensa'), 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('❌ Error de conexión al canjear la recompensa', 'error');
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Función para actualizar display de puntos
function updatePointsDisplay() {
    const pointsDisplay = document.querySelector('.points-number');
    if (pointsDisplay) {
        pointsDisplay.textContent = userPoints;
        
        // Animación de cambio
        pointsDisplay.style.transform = 'scale(1.2)';
        pointsDisplay.style.color = '#10b981';
        
        setTimeout(() => {
            pointsDisplay.style.transform = 'scale(1)';
            pointsDisplay.style.color = '';
        }, 500);
    }
    
    // Actualizar botones según puntos disponibles
    updateAffordabilityButtons();
}

// Función para actualizar botones según lo que se puede comprar
function updateAffordabilityButtons() {
    document.querySelectorAll('.reward-card').forEach(card => {
        const cost = parseInt(card.dataset.cost);
        const button = card.querySelector('.buy-button');
        
        if (userPoints < cost) {
            button.disabled = true;
            button.innerHTML = '💸 Puntos Insuficientes';
        }
    });
}

// Sistema de filtros
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-button');
    const rewardCards = document.querySelectorAll('.reward-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Actualizar botones activos
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            rewardCards.forEach(card => {
                const rarity = card.dataset.rarity;
                const cost = parseInt(card.dataset.cost);
                let shouldShow = false;
                
                switch(filter) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'affordable':
                        shouldShow = cost <= userPoints;
                        break;
                    default:
                        shouldShow = rarity === filter;
                        break;
                }
                
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

// Función para mostrar notificaciones épicas
function showNotification(message, type = 'info') {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    
    const typeStyles = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        bonus: 'bg-purple-500',
        info: 'bg-blue-500'
    };
    
    notification.className = `${typeStyles[type] || typeStyles.info} text-white px-6 py-4 rounded-xl shadow-lg max-w-sm transform transition-all duration-300 translate-x-full opacity-0`;
    
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="font-semibold">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">×</button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
    }, 100);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Animaciones de entrada para las tarjetas
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.reward-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Efectos hover mejorados
document.querySelectorAll('.reward-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});
</script>
@endpush