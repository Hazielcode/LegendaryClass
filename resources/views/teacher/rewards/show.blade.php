@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap');

    .show-bg {
        background: url('/fondo.png') center/cover fixed;
        min-height: 100vh;
        position: relative;
    }
    .show-bg::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.88) 0%, rgba(255,255,255,0.82) 100%);
        z-index: 1;
    }
    .show-content { position: relative; z-index: 2; }

    .detail-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%);
        border-radius: 20px;
        border: 2px solid rgba(245,158,11,0.15);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .section-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #92400e;
        font-size: 1rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .rarity-common   { background:rgba(107,114,128,0.12);color:#374151;border:1px solid rgba(107,114,128,0.25); }
    .rarity-rare     { background:rgba(59,130,246,0.12);color:#1d4ed8;border:1px solid rgba(59,130,246,0.25); }
    .rarity-epic     { background:rgba(124,58,237,0.12);color:#5b21b6;border:1px solid rgba(124,58,237,0.25); }
    .rarity-legendary{ background:rgba(245,158,11,0.15);color:#92400e;border:1px solid rgba(245,158,11,0.3); }
</style>
@endpush

@section('content')
<div class="show-bg">
<div class="show-content px-4 py-6 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('teacher.rewards.index') }}" class="text-yellow-700 hover:text-yellow-900 transition text-sm font-bold"
           style="font-family:'Cinzel',serif;">← Volver</a>
        <h1 class="text-2xl font-black text-gray-800" style="font-family:'Cinzel',serif;">
            🎁 Detalle de la Recompensa
        </h1>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 rounded-xl text-green-800 text-sm font-semibold"
         style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Hero --}}
    <div class="detail-card p-6 mb-6">
        <div class="flex items-start gap-5 flex-wrap">
            <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl flex-shrink-0"
                 style="background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.08));border:2px solid rgba(245,158,11,0.3);">
                {{ $reward->icon ?? '🎁' }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap mb-2">
                    <h2 class="text-xl font-black text-gray-800" style="font-family:'Cinzel',serif;">
                        {{ $reward->name }}
                    </h2>
                    @php
                        $rarity = $reward->rarity ?? 'common';
                        $rarityLabels = ['common'=>'Común','rare'=>'Raro','epic'=>'Épico','legendary'=>'Legendario'];
                    @endphp
                    <span class="rarity-{{ $rarity }}" style="padding:3px 14px;border-radius:20px;font-size:0.78rem;font-weight:700;font-family:'Cinzel',serif;">
                        {{ $rarityLabels[$rarity] ?? ucfirst($rarity) }}
                    </span>
                    @if($reward->is_active)
                    <span style="background:rgba(34,197,94,0.1);color:#15803d;border:1px solid rgba(34,197,94,0.25);padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:700;">
                        Activa
                    </span>
                    @else
                    <span style="background:rgba(107,114,128,0.1);color:#6b7280;border:1px solid rgba(107,114,128,0.2);padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:700;">
                        Inactiva
                    </span>
                    @endif
                </div>
                <p class="text-gray-600 text-sm mb-2">{{ $reward->description }}</p>
                <div class="text-2xl font-black text-yellow-600" style="font-family:'Cinzel',serif;">
                    {{ $reward->cost_points ?? 0 }} <span class="text-sm font-semibold text-gray-500">puntos</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

        {{-- Detalles --}}
        <div class="detail-card p-5">
            <div class="section-title">📊 Detalles</div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tipo:</span>
                    <span class="font-semibold text-gray-800">{{ $reward->type ?? '—' }}</span>
                </div>
                @if($reward->xp_bonus)
                <div class="flex justify-between">
                    <span class="text-gray-500">Bonus XP:</span>
                    <span class="font-bold text-purple-600">+{{ $reward->xp_bonus }} XP</span>
                </div>
                @endif
                @if($reward->level_requirement && $reward->level_requirement > 1)
                <div class="flex justify-between">
                    <span class="text-gray-500">Nivel mín.:</span>
                    <span class="font-semibold text-gray-800">Nv. {{ $reward->level_requirement }}</span>
                </div>
                @endif
                @if($reward->duration_hours)
                <div class="flex justify-between">
                    <span class="text-gray-500">Duración:</span>
                    <span class="font-semibold text-gray-800">{{ $reward->duration_hours }}h</span>
                </div>
                @endif
                @if($reward->max_uses_per_student)
                <div class="flex justify-between">
                    <span class="text-gray-500">Usos máx./est.:</span>
                    <span class="font-semibold text-gray-800">{{ $reward->max_uses_per_student }}</span>
                </div>
                @endif
                @if($reward->stock_quantity !== null)
                <div class="flex justify-between">
                    <span class="text-gray-500">Stock:</span>
                    <span class="font-semibold" style="color:{{ $reward->stock_quantity > 0 ? '#15803d' : '#dc2626' }};">
                        {{ $reward->stock_quantity > 0 ? $reward->stock_quantity : 'Agotado' }}
                    </span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Canjeada:</span>
                    <span class="font-semibold text-gray-800">{{ $reward->studentRewards()->count() }} veces</span>
                </div>
            </div>
        </div>

        {{-- Aula --}}
        <div class="detail-card p-5">
            <div class="section-title">🏫 Aula</div>
            @php
                $classroom = $reward->classroom ?? null;
                if (!$classroom && $reward->classroom_id) {
                    $classroom = \App\Models\Classroom::find($reward->classroom_id);
                }
            @endphp
            @if($classroom)
            <div class="space-y-2 text-sm">
                <div class="font-bold text-gray-800" style="font-family:'Cinzel',serif;">{{ $classroom->name }}</div>
                @if($classroom->subject)
                <div class="text-gray-500">📚 {{ $classroom->subject }}</div>
                @endif
                @if($classroom->grade_level)
                <div class="text-gray-500">🎓 {{ $classroom->grade_level }}</div>
                @endif
            </div>
            @else
            <p class="text-gray-400 text-sm">Sin aula asignada</p>
            @endif

            @if($reward->effect_description)
            <div class="mt-4">
                <div class="text-xs font-bold text-gray-500 mb-1" style="font-family:'Cinzel',serif;">EFECTO</div>
                <p class="text-gray-600 text-sm">{{ $reward->effect_description }}</p>
            </div>
            @endif

            @if(!empty($reward->character_specific))
            <div class="mt-4">
                <div class="text-xs font-bold text-gray-500 mb-1" style="font-family:'Cinzel',serif;">EXCLUSIVO PARA</div>
                <div class="flex flex-wrap gap-1">
                    @foreach($reward->character_specific as $char)
                    <span class="px-2 py-1 rounded-lg text-xs font-semibold" style="background:rgba(124,58,237,0.1);color:#5b21b6;">
                        {{ $char }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('teacher.rewards.edit', $reward->_id) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
           style="background:linear-gradient(135deg,#d97706,#b45309);font-family:'Cinzel',serif;">
            ✏️ Editar
        </a>
        <form method="POST" action="{{ route('teacher.rewards.destroy', $reward->_id) }}"
              onsubmit="return confirm('¿Eliminar esta recompensa?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
                    style="background:linear-gradient(135deg,#dc2626,#b91c1c);font-family:'Cinzel',serif;">
                🗑️ Eliminar
            </button>
        </form>
        <a href="{{ route('teacher.rewards.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm transition hover:bg-gray-100"
           style="border:2px solid rgba(107,114,128,0.3);color:#374151;font-family:'Cinzel',serif;">
            ← Lista
        </a>
    </div>

</div>
</div>
@endsection
