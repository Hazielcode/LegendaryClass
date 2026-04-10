<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-900 via-yellow-900 to-slate-900 -mx-6 -mt-6 px-6 pt-6 pb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('parent.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 transition text-sm" style="font-family:'Cinzel',serif;">
                    ← Volver
                </a>
                <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600" style="font-family: 'Cinzel', serif;">
                    🌟 Progreso de {{ $child->name }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap');
        .guardian-background { background-image: url('/fondo.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh; position: relative; }
        .guardian-overlay { background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(245,158,11,0.04) 50%, rgba(255,255,255,0.9) 100%); position: absolute; inset: 0; }
        .guardian-content { position: relative; z-index: 1; }
        .guardian-card { backdrop-filter: blur(15px); background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%); border: 2px solid rgba(255,255,255,0.9); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 0 20px rgba(245,158,11,0.08); }
        .child-hero { background: linear-gradient(135deg, rgba(15,23,42,0.97) 0%, rgba(88,28,135,0.95) 50%, rgba(88,28,135,0.95) 100%); border-radius: 20px; border: 3px solid rgba(251,191,36,0.4); box-shadow: 0 15px 40px rgba(0,0,0,0.2); }
        .section-title { font-family: 'Cinzel', serif; font-weight: 700; color: #4c1d95; font-size: 1rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .metric-box { border-radius: 12px; padding: 14px; text-align: center; }
        .behavior-row { border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; }
        .classroom-progress-card { border-radius: 14px; border: 2px solid rgba(124,58,237,0.15); padding: 16px; background: linear-gradient(135deg, rgba(245,243,255,0.8), rgba(255,255,255,0.9)); }
        .progress-track { background: rgba(124,58,237,0.1); border-radius: 8px; height: 8px; overflow: hidden; }
        .progress-fill { background: linear-gradient(90deg, #7c3aed, #a78bfa); height: 100%; border-radius: 8px; }
    </style>

    <div class="guardian-background">
        <div class="guardian-overlay"></div>
        <div class="guardian-content p-4 max-w-5xl mx-auto">

            {{-- Hero del hijo --}}
            <div class="child-hero p-6 mb-6">
                <div class="flex items-center gap-5 flex-wrap">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl"
                         style="background:linear-gradient(135deg,rgba(251,191,36,0.3),rgba(245,158,11,0.2));border:3px solid rgba(251,191,36,0.6);">
                        {{ $child->character_icon ?? '⚔️' }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-1" style="font-family:'Cinzel',serif;">{{ $child->name }}</h2>
                        <p class="text-yellow-400" style="font-family:'Cinzel',serif;">{{ $child->character_class ?? 'Sin personaje' }} — Nivel {{ $child->level ?? 1 }}</p>
                        <p class="text-purple-300 text-sm">{{ $child->email }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 rounded-xl" style="background:rgba(255,255,255,0.15);">
                            <div class="text-2xl font-black text-yellow-400" style="font-family:'Cinzel',serif;">{{ number_format($child->experience_points ?? 0) }}</div>
                            <div class="text-purple-200 text-xs">XP Total</div>
                        </div>
                        <div class="text-center p-3 rounded-xl" style="background:rgba(255,255,255,0.15);">
                            <div class="text-2xl font-black text-yellow-400" style="font-family:'Cinzel',serif;">{{ $child->points ?? 0 }}</div>
                            <div class="text-purple-200 text-xs">Puntos</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Métricas generales --}}
                <div class="guardian-card p-5">
                    <div class="section-title">📊 Métricas</div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(34,197,94,0.1),rgba(34,197,94,0.05));border:1px solid rgba(34,197,94,0.2);">
                            <div class="text-2xl font-black text-green-600" style="font-family:'Cinzel',serif;">{{ $child->positive_points ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Pts. Positivos</div>
                        </div>
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(239,68,68,0.08),rgba(239,68,68,0.04));border:1px solid rgba(239,68,68,0.15);">
                            <div class="text-2xl font-black text-red-500" style="font-family:'Cinzel',serif;">{{ $child->negative_points ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Pts. Negativos</div>
                        </div>
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(124,58,237,0.05));border:1px solid rgba(124,58,237,0.2);">
                            <div class="text-2xl font-black text-purple-600" style="font-family:'Cinzel',serif;">{{ $child->quests_completed ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Misiones</div>
                        </div>
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));border:1px solid rgba(245,158,11,0.2);">
                            <div class="text-2xl font-black text-yellow-600" style="font-family:'Cinzel',serif;">{{ $child->achievements_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Logros</div>
                        </div>
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));border:1px solid rgba(59,130,246,0.2);">
                            <div class="text-2xl font-black text-blue-600" style="font-family:'Cinzel',serif;">{{ $child->rewards_earned ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Recompensas</div>
                        </div>
                        <div class="metric-box" style="background:linear-gradient(135deg,rgba(249,115,22,0.1),rgba(249,115,22,0.05));border:1px solid rgba(249,115,22,0.2);">
                            <div class="text-2xl font-black text-orange-500" style="font-family:'Cinzel',serif;">{{ $child->login_streak ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Racha días</div>
                        </div>
                    </div>
                </div>

                {{-- Progreso por aula --}}
                <div class="lg:col-span-2 guardian-card p-5">
                    <div class="section-title">🏫 Progreso por Aula</div>
                    @if($progress_by_classroom->isEmpty())
                        <p class="text-gray-500 text-sm">Tu hijo aún no está inscrito en ninguna aula.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($progress_by_classroom as $prog)
                            <div class="classroom-progress-card">
                                <div class="flex items-center justify-between mb-2 flex-wrap gap-2">
                                    <div>
                                        <span class="font-bold text-gray-800" style="font-family:'Cinzel',serif;">{{ $prog['classroom']->name ?? 'Aula' }}</span>
                                        @if($prog['classroom']->subject ?? null)
                                        <span class="text-gray-500 text-sm ml-2">— {{ $prog['classroom']->subject }}</span>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="text-xs px-3 py-1 rounded-full font-bold" style="background:rgba(245,158,11,0.15);color:#b45309;">
                                            {{ $prog['points'] }} pts
                                        </span>
                                        <span class="text-xs px-3 py-1 rounded-full font-bold" style="background:rgba(124,58,237,0.15);color:#5b21b6;">
                                            Nv. {{ $prog['level'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width:{{ min(100, ($prog['points'] / max(1, $prog['points'] + 200)) * 100) }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Comportamientos recientes --}}
                <div class="guardian-card p-5">
                    <div class="section-title">📝 Comportamientos Recientes</div>
                    @if($recent_behaviors->isEmpty())
                        <p class="text-gray-500 text-sm">Sin actividad reciente registrada.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($recent_behaviors->take(10) as $beh)
                            @php $positive = ($beh->points_awarded ?? 0) >= 0; @endphp
                            <div class="behavior-row" style="background:{{ $positive ? 'rgba(34,197,94,0.08)' : 'rgba(239,68,68,0.06)' }};border:1px solid {{ $positive ? 'rgba(34,197,94,0.2)' : 'rgba(239,68,68,0.15)' }};">
                                <span class="text-lg">{{ $positive ? '✅' : '⚠️' }}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-gray-700 truncate">{{ $beh->behavior->name ?? 'Comportamiento' }}</div>
                                    <div class="text-xs text-gray-500">{{ $beh->classroom->name ?? '' }}</div>
                                </div>
                                <span class="font-bold text-sm flex-shrink-0" style="color:{{ $positive ? '#16a34a' : '#dc2626' }};">
                                    {{ $positive ? '+' : '' }}{{ $beh->points_awarded ?? 0 }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Recompensas canjeadas --}}
                <div class="lg:col-span-2 guardian-card p-5">
                    <div class="section-title">🎁 Recompensas Canjeadas</div>
                    @if($rewards->isEmpty())
                        <p class="text-gray-500 text-sm">Tu hijo aún no ha canjeado recompensas.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($rewards as $sr)
                            <div class="flex items-center gap-3 p-3 rounded-xl" style="background:linear-gradient(135deg,rgba(245,158,11,0.08),rgba(255,255,255,0.9));border:1px solid rgba(245,158,11,0.2);">
                                <span class="text-2xl">{{ $sr->reward->icon ?? '🎁' }}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-sm truncate">{{ $sr->reward->name ?? 'Recompensa' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $sr->points_spent ?? 0 }} pts —
                                        <span class="capitalize" style="color:{{ $sr->status === 'approved' ? '#16a34a' : ($sr->status === 'pending' ? '#d97706' : '#374151') }};">
                                            {{ $sr->status === 'approved' ? 'Aprobada' : ($sr->status === 'pending' ? 'Pendiente' : ucfirst($sr->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold transition hover:opacity-80"
                   style="background:linear-gradient(135deg,#d97706,#b45309);color:white;font-family:'Cinzel',serif;">
                    ← Panel Principal
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
