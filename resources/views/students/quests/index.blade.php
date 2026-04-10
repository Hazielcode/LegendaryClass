@extends('layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.quests-bg {
    background: url('/fondo.png') center/cover fixed;
    min-height: 100vh;
    position: relative;
}
.quests-bg::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(245,158,11,0.08) 0%, rgba(255,255,255,0.88) 50%, rgba(245,158,11,0.08) 100%);
    z-index: 1;
}
.quests-content { position: relative; z-index: 2; }

.quests-header {
    background: linear-gradient(135deg, rgba(217,119,6,0.95) 0%, rgba(245,158,11,0.9) 100%);
    backdrop-filter: blur(20px);
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 24px;
    box-shadow: 0 15px 40px rgba(217,119,6,0.3);
    color: white;
}
.quests-title {
    font-family: 'Cinzel Decorative', serif;
    font-size: 2.5rem;
    font-weight: 900;
    text-shadow: 0 0 20px rgba(255,255,255,0.4);
}
.quest-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%);
    border-radius: 18px;
    border: 2px solid rgba(245,158,11,0.2);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.quest-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(245,158,11,0.2);
    border-color: rgba(245,158,11,0.5);
}
.quest-card.completed {
    border-color: rgba(34,197,94,0.4);
    background: linear-gradient(135deg, rgba(240,253,244,0.97) 0%, rgba(255,255,255,0.92) 100%);
}
.quest-type-badge {
    font-family: 'Cinzel', serif;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.xp-badge {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #92400e;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
}
.complete-btn {
    background: linear-gradient(135deg, #d97706, #b45309);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 8px 20px;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.complete-btn:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(217,119,6,0.4); }
.stat-pill {
    background: linear-gradient(135deg, rgba(217,119,6,0.15), rgba(245,158,11,0.1));
    border: 1px solid rgba(245,158,11,0.3);
    border-radius: 12px;
    padding: 12px 20px;
    text-align: center;
}
.empty-state {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
    border: 2px dashed rgba(245,158,11,0.3);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
}
</style>
@endpush

@section('content')
<div class="quests-bg">
<div class="quests-bg::before"></div>
<div class="quests-content px-4 py-6 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="quests-header p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <div class="quests-title">📜 Misiones</div>
                <p class="text-yellow-100 mt-1" style="font-family:'Cinzel',serif;">Completa tus misiones y gana XP épico</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <div class="stat-pill" style="background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.4);">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">
                        {{ $quests->where('status','active')->count() }}
                    </div>
                    <div class="text-yellow-100 text-xs" style="font-family:'Cinzel',serif;">Activas</div>
                </div>
                <div class="stat-pill" style="background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.4);">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">
                        {{ $quests->where('status','completed')->count() }}
                    </div>
                    <div class="text-yellow-100 text-xs" style="font-family:'Cinzel',serif;">Completadas</div>
                </div>
                <div class="stat-pill" style="background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.4);">
                    <div class="text-2xl font-bold text-white" style="font-family:'Cinzel',serif;">
                        {{ $quests->sum('xp_reward') }}
                    </div>
                    <div class="text-yellow-100 text-xs" style="font-family:'Cinzel',serif;">XP Total</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notificaciones --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-green-100 border border-green-300 text-green-800 flex items-center gap-2">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    {{-- Lista de misiones --}}
    @if($quests->isEmpty())
        <div class="empty-state">
            <div class="text-6xl mb-4">📜</div>
            <h3 class="text-xl font-bold text-gray-600 mb-2" style="font-family:'Cinzel',serif;">Sin misiones por ahora</h3>
            <p class="text-gray-500">Tu maestro aún no ha asignado misiones. ¡Vuelve pronto!</p>
            <a href="{{ route('students.dashboard') }}" class="mt-4 inline-block px-6 py-2 rounded-xl text-white font-bold" style="background:linear-gradient(135deg,#d97706,#b45309);font-family:'Cinzel',serif;">
                Volver al inicio
            </a>
        </div>
    @else
        {{-- Activas --}}
        @php $active = $quests->where('status','active'); @endphp
        @if($active->isNotEmpty())
        <h2 class="text-lg font-bold text-gray-700 mb-3 flex items-center gap-2" style="font-family:'Cinzel',serif;">
            ⚔️ Misiones Activas
        </h2>
        <div class="space-y-4 mb-8">
            @foreach($active as $quest)
            <div class="quest-card p-5">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <span class="text-2xl">
                                @switch($quest->type)
                                    @case('homework') 📚 @break
                                    @case('project')  🔨 @break
                                    @case('writing')  ✍️ @break
                                    @case('reading')  📖 @break
                                    @default          ⚔️
                                @endswitch
                            </span>
                            <h3 class="font-bold text-gray-800 text-lg" style="font-family:'Cinzel',serif;">{{ $quest->title }}</h3>
                            <span class="quest-type-badge" style="background:rgba(245,158,11,0.15);color:#b45309;border:1px solid rgba(245,158,11,0.3);">
                                {{ $quest->type ?? 'misión' }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $quest->description }}</p>
                        @if(isset($quest->due_date) && $quest->due_date)
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <span>⏰</span>
                            <span>Vence: {{ is_string($quest->due_date) ? $quest->due_date : \Carbon\Carbon::parse($quest->due_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="xp-badge">+{{ $quest->xp_reward }} XP</span>
                        <form method="POST" action="{{ route('students.quests.complete', $quest->id) }}">
                            @csrf
                            <button type="submit" class="complete-btn">Completar ✓</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Completadas --}}
        @php $completed = $quests->where('status','completed'); @endphp
        @if($completed->isNotEmpty())
        <h2 class="text-lg font-bold text-gray-600 mb-3 flex items-center gap-2" style="font-family:'Cinzel',serif;">
            ✅ Completadas
        </h2>
        <div class="space-y-3">
            @foreach($completed as $quest)
            <div class="quest-card completed p-4 opacity-80">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        <div>
                            <h3 class="font-bold text-gray-700 line-through" style="font-family:'Cinzel',serif;">{{ $quest->title }}</h3>
                            <p class="text-gray-500 text-sm">{{ $quest->description }}</p>
                        </div>
                    </div>
                    <span class="xp-badge opacity-60">+{{ $quest->xp_reward }} XP</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    @endif

    {{-- Volver --}}
    <div class="mt-8 text-center">
        <a href="{{ route('students.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-gray-600 font-bold hover:bg-white/60 transition"
           style="font-family:'Cinzel',serif;border:2px solid rgba(107,114,128,0.3);">
            ← Volver al Dashboard
        </a>
    </div>
</div>
</div>
@endsection
