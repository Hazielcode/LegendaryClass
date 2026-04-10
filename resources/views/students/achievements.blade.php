@extends('layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.achievements-bg {
    background: url('/fondo.png') center/cover fixed;
    min-height: 100vh;
    position: relative;
}
.achievements-bg::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(124,58,237,0.08) 0%, rgba(255,255,255,0.88) 50%, rgba(124,58,237,0.08) 100%);
    z-index: 1;
}
.achievements-content { position: relative; z-index: 2; }

.achievements-header {
    background: linear-gradient(135deg, rgba(88,28,135,0.95) 0%, rgba(124,58,237,0.9) 60%, rgba(88,28,135,0.95) 100%);
    border-radius: 24px;
    border: 3px solid rgba(255,255,255,0.2);
    box-shadow: 0 15px 40px rgba(88,28,135,0.35);
    color: white;
}
.achievements-title {
    font-family: 'Cinzel Decorative', serif;
    font-size: 2.5rem;
    font-weight: 900;
    text-shadow: 0 0 20px rgba(255,255,255,0.4);
}
.achievement-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%);
    border-radius: 18px;
    border: 2px solid rgba(124,58,237,0.2);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.achievement-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(124,58,237,0.2);
    border-color: rgba(124,58,237,0.5);
}
.achievement-card.rarity-legendary {
    border-color: rgba(217,119,6,0.5);
    background: linear-gradient(135deg, rgba(255,251,235,0.97) 0%, rgba(255,255,255,0.95) 100%);
}
.achievement-card.rarity-epic {
    border-color: rgba(124,58,237,0.5);
    background: linear-gradient(135deg, rgba(245,243,255,0.97) 0%, rgba(255,255,255,0.95) 100%);
}
.achievement-card.rarity-rare {
    border-color: rgba(59,130,246,0.4);
    background: linear-gradient(135deg, rgba(239,246,255,0.97) 0%, rgba(255,255,255,0.95) 100%);
}
.rarity-badge {
    font-family: 'Cinzel', serif;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.xp-badge {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #92400e;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
}
.achievement-icon {
    width: 60px; height: 60px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
}
.progress-bar-track {
    background: rgba(124,58,237,0.1);
    border-radius: 10px;
    height: 6px;
    overflow: hidden;
}
.progress-bar-fill {
    background: linear-gradient(90deg, #7c3aed, #a78bfa);
    height: 100%;
    border-radius: 10px;
    transition: width 0.5s ease;
}
.stat-pill {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    padding: 12px 20px;
    text-align: center;
}
.empty-state {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
    border: 2px dashed rgba(124,58,237,0.3);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
}
.section-title {
    font-family: 'Cinzel', serif;
    font-weight: 700;
    color: #4c1d95;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}
</style>
@endpush

@section('content')
<div class="achievements-bg">
<div class="achievements-content px-4 py-6 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="achievements-header p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <div class="achievements-title">🏆 Logros</div>
                <p class="text-purple-200 mt-1" style="font-family:'Cinzel',serif;">Tu colección de hazañas épicas</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <div class="stat-pill">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">{{ $achievements->count() }}</div>
                    <div class="text-purple-200 text-xs" style="font-family:'Cinzel',serif;">Obtenidos</div>
                </div>
                <div class="stat-pill">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">{{ $achievements->sum('xp_reward') }}</div>
                    <div class="text-purple-200 text-xs" style="font-family:'Cinzel',serif;">XP Ganado</div>
                </div>
                <div class="stat-pill">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">
                        {{ $achievements->where('rarity','legendary')->count() }}
                    </div>
                    <div class="text-purple-200 text-xs" style="font-family:'Cinzel',serif;">Legendarios</div>
                </div>
            </div>
        </div>
    </div>

    @if($achievements->isEmpty())
        <div class="empty-state">
            <div class="text-6xl mb-4">🏆</div>
            <h3 class="text-xl font-bold text-gray-600 mb-2" style="font-family:'Cinzel',serif;">Aún sin logros</h3>
            <p class="text-gray-500 mb-4">Completa misiones y muestra un buen comportamiento para desbloquear logros épicos.</p>
            <a href="{{ route('students.quests.index') }}" class="inline-block px-6 py-2 rounded-xl text-white font-bold"
               style="background:linear-gradient(135deg,#7c3aed,#6d28d9);font-family:'Cinzel',serif;">
                Ver Misiones
            </a>
        </div>
    @else
        {{-- Legendarios primero --}}
        @php
            $grouped = $achievements->groupBy('rarity');
            $order = ['legendary','epic','rare','common'];
            $rarityLabels = ['legendary'=>'⭐ Legendarios','epic'=>'💜 Épicos','rare'=>'💙 Raros','common'=>'📌 Comunes'];
            $rarityColors = ['legendary'=>'rgba(217,119,6,0.15)','epic'=>'rgba(124,58,237,0.15)','rare'=>'rgba(59,130,246,0.15)','common'=>'rgba(107,114,128,0.1)'];
            $rarityText   = ['legendary'=>'#92400e','epic'=>'#5b21b6','rare'=>'#1e40af','common'=>'#374151'];
            $rarityBorder = ['legendary'=>'rgba(217,119,6,0.4)','epic'=>'rgba(124,58,237,0.4)','rare'=>'rgba(59,130,246,0.3)','common'=>'rgba(107,114,128,0.2)'];
        @endphp

        @foreach($order as $rarity)
            @if(isset($grouped[$rarity]) && $grouped[$rarity]->isNotEmpty())
            <div class="mb-8">
                <div class="section-title">{{ $rarityLabels[$rarity] ?? ucfirst($rarity) }}</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($grouped[$rarity] as $achievement)
                    <div class="achievement-card rarity-{{ $rarity }} p-5">
                        <div class="flex items-start gap-4">
                            <div class="achievement-icon" style="background:{{ $rarityColors[$rarity] ?? 'rgba(107,114,128,0.1)' }};border:2px solid {{ $rarityBorder[$rarity] ?? 'rgba(107,114,128,0.2)' }};">
                                {{ $achievement->icon ?? '🏆' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-1 flex-wrap">
                                    <h3 class="font-bold text-gray-800" style="font-family:'Cinzel',serif;">{{ $achievement->name }}</h3>
                                    @if($achievement->xp_reward)
                                    <span class="xp-badge flex-shrink-0">+{{ $achievement->xp_reward }} XP</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $achievement->description }}</p>
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <span class="rarity-badge" style="background:{{ $rarityColors[$rarity] ?? 'rgba(107,114,128,0.1)' }};color:{{ $rarityText[$rarity] ?? '#374151' }};border:1px solid {{ $rarityBorder[$rarity] ?? 'rgba(107,114,128,0.2)' }};">
                                        {{ $rarity }}
                                    </span>
                                    @if($achievement->unlocked_at)
                                    <span class="text-xs text-gray-400">
                                        🗓 {{ is_string($achievement->unlocked_at) ? $achievement->unlocked_at : \Carbon\Carbon::parse($achievement->unlocked_at)->format('d/m/Y') }}
                                    </span>
                                    @endif
                                </div>
                                {{-- Barra de progreso si aplica --}}
                                @if(isset($achievement->max_progress) && $achievement->max_progress > 1)
                                <div class="mt-2">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Progreso</span>
                                        <span>{{ $achievement->progress ?? 0 }}/{{ $achievement->max_progress }}</span>
                                    </div>
                                    <div class="progress-bar-track">
                                        <div class="progress-bar-fill" style="width:{{ min(100, (($achievement->progress ?? 0) / $achievement->max_progress) * 100) }}%"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach

        {{-- Logros sin rarity categorizada --}}
        @php $uncategorized = $achievements->whereNotIn('rarity', $order); @endphp
        @if($uncategorized->isNotEmpty())
        <div class="mb-8">
            <div class="section-title">🎖 Otros Logros</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($uncategorized as $achievement)
                <div class="achievement-card p-5">
                    <div class="flex items-start gap-4">
                        <div class="achievement-icon" style="background:rgba(107,114,128,0.1);border:2px solid rgba(107,114,128,0.2);">
                            {{ $achievement->icon ?? '🏅' }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-bold text-gray-800" style="font-family:'Cinzel',serif;">{{ $achievement->name }}</h3>
                                @if($achievement->xp_reward)
                                <span class="xp-badge">+{{ $achievement->xp_reward }} XP</span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm">{{ $achievement->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('students.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-gray-600 font-bold hover:bg-white/60 transition"
           style="font-family:'Cinzel',serif;border:2px solid rgba(107,114,128,0.3);">
            ← Volver al Dashboard
        </a>
    </div>
</div>
</div>
@endsection
