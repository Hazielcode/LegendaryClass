@extends('layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700&display=swap');

.profile-bg {
    background: url('/fondo.png') center/cover fixed;
    min-height: 100vh;
    position: relative;
}
.profile-bg::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.87) 0%, rgba(255,255,255,0.80) 50%, rgba(255,255,255,0.87) 100%);
    z-index: 1;
}
.profile-content { position: relative; z-index: 2; }

.hero-card {
    background: linear-gradient(135deg, rgba(15,23,42,0.97) 0%, rgba(88,28,135,0.95) 40%, rgba(124,58,237,0.92) 70%, rgba(88,28,135,0.95) 100%);
    border-radius: 24px;
    border: 3px solid rgba(251,191,36,0.5);
    box-shadow: 0 20px 50px rgba(0,0,0,0.3), 0 0 30px rgba(124,58,237,0.3);
    color: white;
    position: relative;
    overflow: hidden;
}
.hero-card::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 50%, rgba(251,191,36,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 50%, rgba(124,58,237,0.15) 0%, transparent 60%);
}
.hero-content { position: relative; z-index: 1; }
.character-avatar {
    width: 100px; height: 100px;
    background: linear-gradient(135deg, rgba(251,191,36,0.3), rgba(245,158,11,0.2));
    border: 4px solid rgba(251,191,36,0.7);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem;
    box-shadow: 0 0 30px rgba(251,191,36,0.4);
}
.xp-bar-track {
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    height: 10px;
    overflow: hidden;
}
.xp-bar-fill {
    background: linear-gradient(90deg, #fbbf24, #f59e0b, #fcd34d);
    height: 100%;
    border-radius: 10px;
    transition: width 1s ease;
    box-shadow: 0 0 10px rgba(251,191,36,0.5);
}
.info-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%);
    border-radius: 18px;
    border: 2px solid rgba(124,58,237,0.15);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}
.stat-item {
    display: flex; flex-direction: column; align-items: center;
    background: linear-gradient(135deg, rgba(124,58,237,0.08), rgba(124,58,237,0.05));
    border: 1px solid rgba(124,58,237,0.2);
    border-radius: 12px;
    padding: 12px 8px;
    text-align: center;
}
.stat-bar-track { background: rgba(124,58,237,0.1); border-radius: 6px; height: 6px; overflow: hidden; }
.stat-bar-fill { height: 100%; border-radius: 6px; transition: width 0.8s ease; }
.section-title {
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    font-weight: 700;
    color: #4c1d95;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.tier-badge {
    font-family: 'Cinzel', serif;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    letter-spacing: 0.05em;
}
.metric-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.97), rgba(255,255,255,0.92));
    border-radius: 14px;
    border: 2px solid rgba(124,58,237,0.15);
    padding: 16px;
    text-align: center;
}
</style>
@endpush

@section('content')
<div class="profile-bg">
<div class="profile-content px-4 py-6 max-w-4xl mx-auto">

    @php
        $level = $user->level ?? 1;
        $xp = $user->experience_points ?? 0;
        $nextXP = ($level * $level) * 100;
        $prevXP = ($level > 1) ? (($level-1)*($level-1)*100) : 0;
        $progress = $nextXP > $prevXP ? min(100, (($xp - $prevXP) / ($nextXP - $prevXP)) * 100) : 100;

        $tier = 1;
        if ($level >= 75) $tier = 4;
        elseif ($level >= 50) $tier = 3;
        elseif ($level >= 25) $tier = 2;

        $tierNames  = [1=>'Novato',2=>'Veterano',3=>'Épico',4=>'Legendario'];
        $tierColors = [1=>'rgba(107,114,128,0.2)',2=>'rgba(59,130,246,0.2)',3=>'rgba(124,58,237,0.3)',4=>'rgba(217,119,6,0.3)'];
        $tierText   = [1=>'#374151',2=>'#1e40af',3=>'#5b21b6',4=>'#92400e'];

        $stats = [
            'strength'     => ['label'=>'Fuerza',      'icon'=>'⚔️',  'color'=>'#ef4444', 'val'=>$user->strength??10],
            'intelligence' => ['label'=>'Inteligencia', 'icon'=>'📚',  'color'=>'#3b82f6', 'val'=>$user->intelligence??10],
            'agility'      => ['label'=>'Agilidad',     'icon'=>'💨',  'color'=>'#22c55e', 'val'=>$user->agility??10],
            'creativity'   => ['label'=>'Creatividad',  'icon'=>'🎨',  'color'=>'#a855f7', 'val'=>$user->creativity??10],
            'leadership'   => ['label'=>'Liderazgo',    'icon'=>'👑',  'color'=>'#f59e0b', 'val'=>$user->leadership??10],
            'resilience'   => ['label'=>'Resiliencia',  'icon'=>'🛡️', 'color'=>'#14b8a6', 'val'=>$user->resilience??10],
        ];
    @endphp

    {{-- Hero card --}}
    <div class="hero-card p-6 mb-6">
        <div class="hero-content">
            <div class="flex items-center gap-5 flex-wrap">
                <div class="character-avatar">{{ $user->character_icon ?? '⚔️' }}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1 flex-wrap">
                        <h1 class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">{{ $user->name }}</h1>
                        <span class="tier-badge" style="background:{{ $tierColors[$tier] }};color:{{ $tierText[$tier] }};">
                            {{ $tierNames[$tier] }}
                        </span>
                    </div>
                    <p class="text-yellow-400 font-semibold mb-1" style="font-family:'Cinzel',serif;">
                        {{ $user->character_class ?? 'Aventurero' }} — Nivel {{ $level }}
                    </p>
                    <p class="text-purple-300 text-sm mb-3">{{ $user->email }}</p>
                    {{-- XP bar --}}
                    <div>
                        <div class="flex justify-between text-xs text-purple-200 mb-1">
                            <span>XP: {{ number_format($xp) }}</span>
                            <span>Siguiente: {{ number_format($nextXP) }}</span>
                        </div>
                        <div class="xp-bar-track">
                            <div class="xp-bar-fill" style="width:{{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-black text-yellow-400" style="font-family:'Cinzel Decorative',serif;">Nv.{{ $level }}</div>
                    <div class="text-yellow-300 text-sm" style="font-family:'Cinzel',serif;">{{ number_format($user->points ?? 0) }} pts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda: métricas --}}
        <div class="space-y-4">
            <div class="info-card p-5">
                <div class="section-title">📊 Estadísticas</div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="metric-card">
                        <div class="text-2xl font-black text-purple-700" style="font-family:'Cinzel',serif;">{{ $user->quests_completed ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Misiones</div>
                    </div>
                    <div class="metric-card">
                        <div class="text-2xl font-black text-yellow-600" style="font-family:'Cinzel',serif;">{{ $user->achievements_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Logros</div>
                    </div>
                    <div class="metric-card">
                        <div class="text-2xl font-black text-green-600" style="font-family:'Cinzel',serif;">{{ $user->positive_points ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Pts. Positivos</div>
                    </div>
                    <div class="metric-card">
                        <div class="text-2xl font-black text-blue-600" style="font-family:'Cinzel',serif;">{{ $user->rewards_earned ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Recompensas</div>
                    </div>
                    <div class="metric-card">
                        <div class="text-2xl font-black text-orange-500" style="font-family:'Cinzel',serif;">{{ $user->login_streak ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Racha días</div>
                    </div>
                    <div class="metric-card">
                        <div class="text-2xl font-black text-indigo-600" style="font-family:'Cinzel',serif;">{{ number_format($xp) }}</div>
                        <div class="text-xs text-gray-500">XP Total</div>
                    </div>
                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="info-card p-5">
                <div class="section-title">⚡ Acciones</div>
                <div class="space-y-2">
                    <a href="{{ route('students.character.profile') }}" class="block w-full text-center py-2 px-4 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
                       style="background:linear-gradient(135deg,#7c3aed,#6d28d9);font-family:'Cinzel',serif;">
                        ⚔️ Ver Personaje
                    </a>
                    <a href="{{ route('students.achievements') }}" class="block w-full text-center py-2 px-4 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
                       style="background:linear-gradient(135deg,#d97706,#b45309);font-family:'Cinzel',serif;">
                        🏆 Mis Logros
                    </a>
                    <a href="{{ route('students.quests.index') }}" class="block w-full text-center py-2 px-4 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
                       style="background:linear-gradient(135deg,#059669,#047857);font-family:'Cinzel',serif;">
                        📜 Mis Misiones
                    </a>
                    <a href="{{ route('profile.edit.user', auth()->id()) }}" class="block w-full text-center py-2 px-4 rounded-xl font-bold text-sm transition hover:bg-gray-100"
                       style="border:2px solid rgba(107,114,128,0.3);color:#374151;font-family:'Cinzel',serif;">
                        ✏️ Editar Perfil
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna derecha: stats del personaje --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="info-card p-5">
                <div class="section-title">🎮 Atributos del Personaje</div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($stats as $key => $stat)
                    <div class="stat-item">
                        <div class="text-2xl mb-1">{{ $stat['icon'] }}</div>
                        <div class="text-lg font-black mb-1" style="color:{{ $stat['color'] }};font-family:'Cinzel',serif;">{{ $stat['val'] }}</div>
                        <div class="text-xs text-gray-500 mb-2">{{ $stat['label'] }}</div>
                        <div class="stat-bar-track w-full">
                            <div class="stat-bar-fill" style="width:{{ min(100, ($stat['val']/50)*100) }}%;background:{{ $stat['color'] }};opacity:0.7;"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">{{ $stat['val'] }}/50</div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-3 text-center" style="font-family:'Cinzel',serif;">
                    Mejora tus atributos en la tienda usando tus puntos
                </p>
            </div>

            {{-- Información personal --}}
            <div class="info-card p-5">
                <div class="section-title">👤 Información</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-500">Nombre:</span>
                        <span class="ml-2 font-semibold text-gray-700">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Correo:</span>
                        <span class="ml-2 font-semibold text-gray-700">{{ $user->email }}</span>
                    </div>
                    @if($user->grade_level)
                    <div>
                        <span class="text-gray-500">Grado:</span>
                        <span class="ml-2 font-semibold text-gray-700">{{ $user->grade_level }}</span>
                    </div>
                    @endif
                    @if($user->date_of_birth)
                    <div>
                        <span class="text-gray-500">Nacimiento:</span>
                        <span class="ml-2 font-semibold text-gray-700">{{ \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-500">Clase:</span>
                        <span class="ml-2 font-semibold text-purple-700">{{ $user->character_class ?? 'Sin seleccionar' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Bonus:</span>
                        <span class="ml-2 font-semibold text-yellow-700">{{ $user->character_bonus_type ?? '—' }}</span>
                    </div>
                    @if($user->parent_email)
                    <div class="sm:col-span-2">
                        <span class="text-gray-500">Email del padre:</span>
                        <span class="ml-2 font-semibold text-gray-700">{{ $user->parent_email }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('students.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-gray-600 font-bold hover:bg-white/60 transition"
           style="font-family:'Cinzel',serif;border:2px solid rgba(107,114,128,0.3);">
            ← Volver al Dashboard
        </a>
    </div>
</div>
</div>
@endsection
