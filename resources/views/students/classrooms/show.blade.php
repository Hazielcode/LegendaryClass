@extends('layouts.app')

@push('styles')
<style>
/* Fuentes épicas */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.classroom-bg {
    background: url('/fondo.png') center/cover;
    min-height: 100vh;
    position: relative;
}

.classroom-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
    z-index: 1;
}

.classroom-content {
    position: relative;
    z-index: 2;
}

.classroom-header {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
    border: 2px solid rgba(59, 130, 246, 0.2);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.quest-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    border: 2px solid rgba(34, 197, 94, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.quest-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    border-color: rgba(34, 197, 94, 0.4);
}

.reward-card {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
    border: 2px solid rgba(245, 158, 11, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.reward-card:hover {
    transform: translateY(-3px);
    border-color: rgba(245, 158, 11, 0.4);
}

.btn-epic {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-family: 'Cinzel', serif;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-epic:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    color: white;
}

.btn-orange {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.btn-orange:hover {
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.title-epic {
    font-family: 'Cinzel Decorative', serif;
    background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 2px 4px rgba(184, 83, 9, 0.1);
}

.stats-display {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-box {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
    border: 2px solid rgba(139, 92, 246, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}

.section-title {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.grid-layout {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-display {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .grid-layout {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="classroom-bg">
    <div class="classroom-content py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header del aula -->
            <div class="classroom-header p-6 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-4 lg:mb-0">
                        <div class="flex items-center mb-2">
                            <a href="{{ route('students.classrooms.index') }}" 
                               class="text-blue-600 hover:text-blue-800 mr-4 text-2xl">
                                ← 
                            </a>
                            <h1 class="text-4xl font-bold title-epic">
                                🏫 {{ $classroom->name }}
                            </h1>
                        </div>
                        <p class="text-lg text-gray-600">{{ $classroom->description }}</p>
                        <div class="flex items-center mt-2 text-gray-500">
                            <span class="text-xl mr-2">👨‍🏫</span>
                            <span>Profesor: {{ $classroom->teacher->name ?? 'Profesor Épico' }}</span>
                        </div>
                    </div>
                    
                    <!-- Mis estadísticas en esta aula -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-4 border-2 border-green-200">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 font-serif">
                                {{ auth()->user()->getPointsInClassroom($classroom->_id ?? $classroom->id) ?? rand(150, 350) }}
                            </div>
                            <div class="text-sm text-green-700 font-semibold">Mis Puntos</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas generales -->
            <div class="stats-display">
                <div class="stat-box">
                    <div class="text-3xl mb-2">🎯</div>
                    <div class="text-2xl font-bold text-purple-600 font-serif">{{ rand(8, 25) }}</div>
                    <div class="text-sm text-gray-600">Misiones Completadas</div>
                </div>
                <div class="stat-box">
                    <div class="text-3xl mb-2">🏆</div>
                    <div class="text-2xl font-bold text-yellow-600 font-serif">{{ rand(3, 12) }}</div>
                    <div class="text-sm text-gray-600">Logros Desbloqueados</div>
                </div>
                <div class="stat-box">
                    <div class="text-3xl mb-2">📈</div>
                    <div class="text-2xl font-bold text-blue-600 font-serif">{{ rand(75, 98) }}%</div>
                    <div class="text-sm text-gray-600">Progreso General</div>
                </div>
                <div class="stat-box">
                    <div class="text-3xl mb-2">⭐</div>
                    <div class="text-2xl font-bold text-green-600 font-serif">{{ auth()->user()->level ?? rand(1, 15) }}</div>
                    <div class="text-sm text-gray-600">Nivel Actual</div>
                </div>
            </div>

            <div class="grid-layout">
                <!-- Misiones Activas -->
                <div>
                    <h2 class="section-title">
                        🗡️ Misiones Épicas Activas
                    </h2>
                    
                    @for($i = 1; $i <= 3; $i++)
                    <div class="quest-card p-6 mb-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="text-2xl mr-3">
                                        @if($i == 1) 📚
                                        @elseif($i == 2) 🧪
                                        @else ✍️
                                        @endif
                                    </span>
                                    <h3 class="font-bold text-lg text-gray-800">
                                        @if($i == 1) 
                                            Resolver Ecuaciones Cuadráticas
                                        @elseif($i == 2)
                                            Experimento de Química
                                        @else
                                            Ensayo sobre Fotosíntesis
                                        @endif
                                    </h3>
                                </div>
                                
                                <p class="text-gray-600 mb-3">
                                    @if($i == 1)
                                        Completa los ejercicios 1-15 del capítulo 7 sobre ecuaciones de segundo grado
                                    @elseif($i == 2)
                                        Realizar el experimento de mezclas químicas y escribir un reporte detallado
                                    @else
                                        Escribir un ensayo de 500 palabras explicando el proceso de fotosíntesis
                                    @endif
                                </p>
                                
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                        +{{ rand(50, 150) }} XP
                                    </span>
                                    <span class="text-gray-500">
                                        📅 Vence: {{ now()->addDays(rand(2, 7))->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                            
                            <button onclick="completeQuest({{ $i }})" 
                                    class="btn-epic ml-4">
                                ✅ Completar
                            </button>
                        </div>
                    </div>
                    @endfor
                </div>

                <!-- Tienda de Recompensas -->
                <div>
                    <h2 class="section-title">
                        🛒 Tienda de Recompensas
                    </h2>
                    
                    @php
                        $rewards = [
                            ['name' => 'Sticker Dorado', 'icon' => '⭐', 'cost' => 25, 'desc' => 'Un sticker especial para tu cuaderno'],
                            ['name' => 'Tiempo Extra de Recreo', 'icon' => '🎮', 'cost' => 75, 'desc' => '10 minutos adicionales de recreo'],
                            ['name' => 'Lápiz Legendario', 'icon' => '✏️', 'cost' => 50, 'desc' => 'Un lápiz especial con tu nombre'],
                            ['name' => 'Certificado de Honor', 'icon' => '🏆', 'cost' => 150, 'desc' => 'Certificado personalizado de logro']
                        ];
                    @endphp
                    
                    @foreach($rewards as $index => $reward)
                    <div class="reward-card p-4 mb-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <span class="text-3xl mr-4">{{ $reward['icon'] }}</span>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $reward['name'] }}</h4>
                                    <p class="text-sm text-gray-600">{{ $reward['desc'] }}</p>
                                    <span class="text-orange-600 font-bold">{{ $reward['cost'] }} puntos</span>
                                </div>
                            </div>
                            
                            <button onclick="buyReward({{ $index + 1 }})" 
                                    class="btn-epic btn-orange">
                                🛒 Canjear
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ranking del Aula -->
            <div class="mt-8">
                <h2 class="section-title">
                    🏅 Ranking de Héroes del Aula
                </h2>
                
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border-2 border-yellow-200">
                    <div class="grid gap-4">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="flex items-center justify-between p-4 
                                    {{ $i == 1 ? 'bg-yellow-100 border-2 border-yellow-300' : ($i <= 3 ? 'bg-gray-50 border border-gray-200' : 'bg-white border border-gray-100') }} 
                                    rounded-xl">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full 
                                           {{ $i == 1 ? 'bg-yellow-400' : ($i == 2 ? 'bg-gray-400' : ($i == 3 ? 'bg-orange-400' : 'bg-blue-400')) }} 
                                           flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ $i }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">
                                        {{ $i == 2 ? 'Tu' : 'Estudiante ' . $i }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ ['⚔️ Guerrero', '🧙‍♂️ Mago', '🏹 Arquero', '🥷 Ninja', '🎯 Lanzador'][($i-1) % 5] }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-lg text-green-600">{{ 500 - ($i-1) * 50 }} pts</div>
                                <div class="text-sm text-gray-500">Nivel {{ 10 - $i + 1 }}</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de éxito -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
        <div class="text-6xl mb-4">🎉</div>
        <h3 class="text-2xl font-bold text-green-600 mb-2">¡Misión Completada!</h3>
        <p id="success-message" class="text-gray-600 mb-6"></p>
        <button onclick="closeModal()" class="btn-epic">
            ¡Genial!
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function completeQuest(questId) {
    fetch(`{{ url('/students/quests') }}/${questId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessModal(data.message);
            // Recargar la página después de 2 segundos
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert(data.message || 'Error al completar la misión');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al completar la misión');
    });
}

function buyReward(rewardId) {
    fetch(`{{ url('/students/rewards') }}/${rewardId}/buy`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessModal('¡Recompensa canjeada exitosamente!');
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert(data.message || 'Error al canjear la recompensa');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al canjear la recompensa');
    });
}

function showSuccessModal(message) {
    document.getElementById('success-message').textContent = message;
    document.getElementById('success-modal').classList.remove('hidden');
    document.getElementById('success-modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('success-modal').classList.add('hidden');
    document.getElementById('success-modal').classList.remove('flex');
}
</script>
@endpush