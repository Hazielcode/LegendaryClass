@extends('layouts.app')

@section('title', 'Mis Recompensas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900">
    <div class="container mx-auto px-6 py-8">
        
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">🏆 Mis Recompensas</h1>
            <p class="text-indigo-200">Historial de todas tus recompensas canjeadas</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">📊 Estadísticas</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-200">Total Canjeadas:</span>
                            <span class="text-2xl font-bold text-yellow-400">{{ $rewards->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-200">Activas:</span>
                            <span class="text-2xl font-bold text-green-400">{{ $activeRewards->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-200">Puntos Gastados:</span>
                            <span class="text-2xl font-bold text-red-400">{{ $rewards->sum('points_spent') }}</span>
                        </div>
                    </div>
                </div>

                @if($activeRewards->count() > 0)
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                        <h3 class="text-xl font-semibold text-white mb-4">⚡ Efectos Activos</h3>
                        
                        <div class="space-y-3">
                            @foreach($activeRewards as $activeReward)
                                <div class="bg-green-500/20 rounded-lg p-3 border border-green-400/30">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold text-white">{{ $activeReward->reward->name }}</span>
                                        <span class="text-xs text-green-300">Activo</span>
                                    </div>
                                    
                                    @if(!$activeReward->is_permanent && $activeReward->expires_at)
                                        <div class="text-xs text-green-200">
                                            Expira: {{ $activeReward->expires_at->format('d/m/Y H:i') }}
                                        </div>
                                    @else
                                        <div class="text-xs text-green-200">Permanente</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2">
                @if($rewards->isEmpty())
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-12 border border-white/20 text-center">
                        <div class="text-6xl mb-4">🎁</div>
                        <h3 class="text-2xl font-semibold text-white mb-2">No has canjeado recompensas aún</h3>
                        <p class="text-indigo-200 mb-6">¡Gana puntos completando tareas y comportándote bien!</p>
                        <a href="{{ route('students.rewards.index') }}" 
                           class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                            Ver Recompensas Disponibles
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($rewards as $studentReward)
                            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="text-3xl">{{ $studentReward->reward->icon }}</div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-white mb-1">
                                                {{ $studentReward->reward->name }}
                                            </h3>
                                            <p class="text-indigo-200 text-sm mb-2">
                                                {{ $studentReward->reward->description }}
                                            </p>
                                            
                                            <div class="flex items-center space-x-4 text-sm">
                                                <span class="text-yellow-400">
                                                    💰 {{ $studentReward->points_spent }} puntos
                                                </span>
                                                
                                                @if($studentReward->reward->xp_bonus > 0)
                                                    <span class="text-blue-400">
                                                        ⚡ +{{ $studentReward->reward->xp_bonus }} XP
                                                    </span>
                                                @endif
                                                
                                                <span class="text-indigo-300">
                                                    📚 {{ $studentReward->classroom->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $studentReward->getStatusColor() }}">
                                            {{ $studentReward->getStatusText() }}
                                        </span>
                                        
                                        <div class="text-xs text-indigo-300 mt-2">
                                            {{ $studentReward->redeemed_at->format('d/m/Y H:i') }}
                                        </div>
                                        
                                        @if($studentReward->status === 'approved' && $studentReward->expires_at && !$studentReward->is_permanent)
                                            <div class="text-xs text-orange-300 mt-1">
                                                @if($studentReward->isActive())
                                                    Expira: {{ $studentReward->expires_at->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-red-400">Expirado</span>
                                                @endif
                                            </div>
                                        @elseif($studentReward->is_permanent && $studentReward->status === 'approved')
                                            <div class="text-xs text-green-300 mt-1">
                                                Permanente ♾️
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($studentReward->effects_applied)
                                    <div class="mt-4 p-3 bg-blue-500/20 rounded-lg border border-blue-400/30">
                                        <h4 class="text-sm font-semibold text-blue-300 mb-2">🎯 Efectos Aplicados:</h4>
                                        <div class="text-xs text-blue-200">
                                            @if(isset($studentReward->effects_applied['xp']))
                                                <div>• XP Ganado: +{{ $studentReward->effects_applied['xp']['xp_gained'] ?? 0 }}</div>
                                                @if(isset($studentReward->effects_applied['xp']['level_up']) && $studentReward->effects_applied['xp']['level_up'])
                                                    <div class="text-yellow-300">• ¡Subiste de nivel! 🎉</div>
                                                @endif
                                            @endif
                                            
                                            @if(isset($studentReward->effects_applied['stats']))
                                                @foreach($studentReward->effects_applied['stats'] as $stat => $bonus)
                                                    <div>• {{ ucfirst($stat) }}: +{{ $bonus }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($studentReward->notes)
                                    <div class="mt-4 p-3 bg-gray-500/20 rounded-lg border border-gray-400/30">
                                        <h4 class="text-sm font-semibold text-gray-300 mb-1">📝 Notas del Maestro:</h4>
                                        <p class="text-xs text-gray-200">{{ $studentReward->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8 text-center">
                        <a href="{{ route('students.rewards.index') }}" 
                           class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            🛒 Ver Más Recompensas
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection