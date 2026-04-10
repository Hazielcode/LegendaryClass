@extends('layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap');

.rewards-bg {
    background: url('/fondo.png') center/cover;
    min-height: 100vh;
    position: relative;
}

.rewards-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.1) 0%, 
        rgba(34, 197, 94, 0.1) 50%, 
        rgba(16, 185, 129, 0.1) 100%);
    z-index: 1;
}

.rewards-content {
    position: relative;
    z-index: 2;
}

.header-section {
    background: linear-gradient(135deg, 
        rgba(16, 185, 129, 0.95) 0%, 
        rgba(34, 197, 94, 0.9) 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-number {
    font-family: 'Cinzel', serif;
    font-size: 2.5rem;
    font-weight: bold;
    color: #059669;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-weight: 600;
}

.reward-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    border-left: 6px solid;
}

.reward-card.pending { border-left-color: #f59e0b; }
.reward-card.approved { border-left-color: #10b981; }
.reward-card.delivered { border-left-color: #3b82f6; }
.reward-card.cancelled { border-left-color: #ef4444; }

.reward-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.reward-info {
    display: flex;
    align-items: center;
}

.reward-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
}

.reward-details h3 {
    font-family: 'Cinzel', serif;
    font-weight: bold;
    font-size: 1.2rem;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.reward-details p {
    color: #6b7280;
    font-size: 0.9rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.reward-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.meta-item {
    text-align: center;
    padding: 0.5rem;
    background: #f9fafb;
    border-radius: 8px;
}

.meta-label {
    font-size: 0.7rem;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.meta-value {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1f2937;
}

.empty-state {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.fade-in {
    animation: fadeInUp 0.6s ease-out;
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
</style>
@endpush

@section('content')
<div class="rewards-bg">
    <div class="rewards-content py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="header-section fade-in">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-2" style="font-family: 'Cinzel', serif;">
                        🎒 MIS RECOMPENSAS LEGENDARIAS
                    </h1>
                    <p class="text-xl opacity-90">
                        Historial completo de todas tus recompensas épicas
                    </p>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-grid fade-in">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_rewards'] ?? 0 }}</div>
                    <div class="stat-label">Recompensas Totales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_spent'] ?? 0 }}</div>
                    <div class="stat-label">💎 Puntos Gastados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['pending_rewards'] ?? 0 }}</div>
                    <div class="stat-label">⏳ Pendientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['active_rewards'] ?? 0 }}</div>
                    <div class="stat-label">✨ Activas</div>
                </div>
            </div>

            <!-- Botones de navegación -->
            <div class="text-center mb-8 fade-in">
                <a href="{{ route('students.store') }}" 
                   class="inline-block bg-gradient-to-r from-purple-500 to-purple-700 text-white px-8 py-3 rounded-xl font-bold font-serif text-lg mr-4 hover:from-purple-600 hover:to-purple-800 transition-all duration-300 transform hover:scale-105">
                    🛒 Ir a la Tienda
                </a>
                <a href="{{ route('students.dashboard') }}" 
                   class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white px-8 py-3 rounded-xl font-bold font-serif text-lg hover:from-green-600 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
                    🏠 Dashboard
                </a>
            </div>

            <!-- Lista de recompensas -->
            @if($myRewards->isNotEmpty())
                <div class="fade-in">
                    @foreach($myRewards as $studentReward)
                        <div class="reward-card {{ $studentReward->status ?? 'pending' }}">
                            <div class="reward-header">
                                <div class="reward-info">
                                    <div class="reward-icon">{{ $studentReward->reward->icon ?? '🎁' }}</div>
                                    <div class="reward-details">
                                        <h3>{{ $studentReward->reward->name ?? 'Recompensa Épica' }}</h3>
                                        <p>{{ $studentReward->reward->description ?? 'Una recompensa legendaria para tu aventura' }}</p>
                                    </div>
                                </div>
                                <div class="status-badge {{ $studentReward->getStatusColor() }}">
                                    {{ $studentReward->getStatusIcon() }} {{ $studentReward->getStatusText() }}
                                </div>
                            </div>

                            <div class="reward-meta">
                                <div class="meta-item">
                                    <div class="meta-label">Puntos Gastados</div>
                                    <div class="meta-value">{{ $studentReward->points_spent ?? 0 }} 💎</div>
                                </div>
                                
                                <div class="meta-item">
                                    <div class="meta-label">Fecha de Canje</div>
                                    <div class="meta-value">
                                        {{ $studentReward->redeemed_at ? $studentReward->redeemed_at->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </div>
                                
                                @if($studentReward->expires_at && !$studentReward->is_permanent)
                                    <div class="meta-item">
                                        <div class="meta-label">Expira</div>
                                        <div class="meta-value">
                                            {{ $studentReward->expires_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @elseif($studentReward->is_permanent)
                                    <div class="meta-item">
                                        <div class="meta-label">Duración</div>
                                        <div class="meta-value">♾️ Permanente</div>
                                    </div>
                                @endif
                                
                                @if($studentReward->classroom)
                                    <div class="meta-item">
                                        <div class="meta-label">Aula</div>
                                        <div class="meta-value">{{ $studentReward->classroom->name ?? 'General' }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Efectos aplicados -->
                            @if($studentReward->effects_applied && is_array($studentReward->effects_applied))
                                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <h4 class="font-bold text-green-800 mb-2">✨ Efectos Aplicados:</h4>
                                    <div class="text-sm text-green-700">
                                        @if(isset($studentReward->effects_applied['xp']))
                                            <div>• XP Ganado: +{{ $studentReward->effects_applied['xp']['gained'] ?? 0 }}</div>
                                        @endif
                                        @if(isset($studentReward->effects_applied['stats']))
                                            @foreach($studentReward->effects_applied['stats'] as $stat => $value)
                                                <div>• {{ ucfirst($stat) }}: +{{ $value }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Notas adicionales -->
                            @if($studentReward->notes)
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <h4 class="font-bold text-blue-800 mb-1">📝 Notas:</h4>
                                    <p class="text-sm text-blue-700">{{ $studentReward->notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Paginación si es necesaria -->
                @if(method_exists($myRewards, 'hasPages') && $myRewards->hasPages())
                    <div class="mt-8">
                        {{ $myRewards->links() }}
                    </div>
                @endif

            @else
                <!-- Estado vacío -->
                <div class="empty-state fade-in">
                    <div class="text-6xl mb-6">🎒</div>
                    <h2 class="text-3xl font-bold text-gray-700 mb-4" style="font-family: 'Cinzel', serif;">
                        ¡Tu Inventario Está Vacío!
                    </h2>
                    <p class="text-xl text-gray-600 mb-8 max-w-md mx-auto">
                        Aún no has canjeado ninguna recompensa. ¡Visita la tienda para conseguir tesoros épicos!
                    </p>
                    <a href="{{ route('students.store') }}" 
                       class="inline-block bg-gradient-to-r from-purple-500 to-purple-700 text-white px-8 py-4 rounded-xl font-bold font-serif text-xl hover:from-purple-600 hover:to-purple-800 transition-all duration-300 transform hover:scale-105">
                        🛒 Explorar Tienda
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mensajes -->
@if(session('success'))
    <div class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 max-w-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-6 right-6 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 max-w-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">❌</span>
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
// Auto-ocultar mensajes
document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.fixed.bottom-6.right-6');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });

    // Animaciones de entrada
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
</script>
@endpush