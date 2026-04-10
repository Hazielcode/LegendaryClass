<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-900 via-yellow-900 to-slate-900 -mx-6 -mt-6 px-6 pt-6 pb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('parent.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 transition text-sm" style="font-family:'Cinzel',serif;">
                    ← Volver
                </a>
                <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600" style="font-family: 'Cinzel', serif;">
                    🏫 {{ $classroom->name }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap');
        .guardian-background { background-image: url('/fondo.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh; position: relative; }
        .guardian-overlay { background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(245,158,11,0.04) 50%, rgba(255,255,255,0.9) 100%); position: absolute; inset: 0; }
        .guardian-content { position: relative; z-index: 1; }
        .guardian-card { backdrop-filter: blur(15px); background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%); border: 2px solid rgba(255,255,255,0.9); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .section-title { font-family: 'Cinzel', serif; font-weight: 700; color: #4c1d95; font-size: 1rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .child-card { border-radius: 16px; border: 2px solid rgba(124,58,237,0.2); padding: 16px; background: linear-gradient(135deg, rgba(245,243,255,0.9), rgba(255,255,255,0.95)); }
        .behavior-item { border-radius: 10px; padding: 8px 12px; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; }
        .reward-item { border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; }
        .classroom-header-card { background: linear-gradient(135deg, rgba(59,130,246,0.95) 0%, rgba(37,99,235,0.92) 100%); border-radius: 20px; border: 3px solid rgba(255,255,255,0.3); color: white; }
    </style>

    <div class="guardian-background">
        <div class="guardian-overlay"></div>
        <div class="guardian-content p-4 max-w-5xl mx-auto">

            {{-- Header del aula --}}
            <div class="classroom-header-card p-6 mb-6">
                <div class="flex items-start justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1" style="font-family:'Cinzel',serif;">{{ $classroom->name }}</h2>
                        <p class="text-blue-200" style="font-family:'Cinzel',serif;">{{ $classroom->subject ?? '' }} — {{ $classroom->grade_level ?? '' }}</p>
                        @if($classroom->description)
                        <p class="text-blue-300 text-sm mt-1">{{ $classroom->description }}</p>
                        @endif
                    </div>
                    <div class="space-y-2 text-right">
                        @if($teacher)
                        <div class="flex items-center gap-2 justify-end">
                            <span class="text-blue-200 text-sm">👨‍🏫 {{ $teacher->name }}</span>
                        </div>
                        @endif
                        <div class="text-blue-200 text-sm">👥 {{ count($classroom->student_ids ?? []) }} estudiantes</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Progreso de mis hijos en esta aula --}}
                <div class="guardian-card p-5 lg:col-span-2">
                    <div class="section-title">👶 Progreso de mis Hijos en esta Aula</div>
                    @if($children_progress->isEmpty())
                        <p class="text-gray-500 text-sm">Sin datos de progreso disponibles.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($children_progress as $cp)
                            <div class="child-card">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" style="background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(124,58,237,0.1));border:2px solid rgba(124,58,237,0.3);">
                                        {{ $cp['child']->character_icon ?? '⚔️' }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800" style="font-family:'Cinzel',serif;">{{ $cp['child']->name }}</div>
                                        <div class="text-purple-600 text-xs">{{ $cp['child']->character_class ?? 'Aventurero' }}</div>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <div class="font-black text-yellow-600 text-lg" style="font-family:'Cinzel',serif;">{{ $cp['points'] }}</div>
                                        <div class="text-gray-500 text-xs">puntos</div>
                                    </div>
                                </div>

                                <div class="flex gap-3 mb-3">
                                    <span class="text-xs px-3 py-1 rounded-full font-bold" style="background:rgba(124,58,237,0.12);color:#5b21b6;">
                                        Nivel {{ $cp['level'] }}
                                    </span>
                                </div>

                                @if($cp['recent_behaviors']->isNotEmpty())
                                <div>
                                    <div class="text-xs font-bold text-gray-500 mb-2" style="font-family:'Cinzel',serif;">ÚLTIMOS COMPORTAMIENTOS</div>
                                    <div class="space-y-1">
                                        @foreach($cp['recent_behaviors']->take(3) as $beh)
                                        @php $pos = ($beh->points_awarded ?? 0) >= 0; @endphp
                                        <div class="behavior-item" style="background:{{ $pos ? 'rgba(34,197,94,0.08)' : 'rgba(239,68,68,0.06)' }};">
                                            <span>{{ $pos ? '✅' : '⚠️' }}</span>
                                            <span class="flex-1 truncate text-gray-700">{{ $beh->behavior->name ?? 'Comportamiento' }}</span>
                                            <span class="font-bold" style="color:{{ $pos ? '#16a34a' : '#dc2626' }};">{{ $pos ? '+' : '' }}{{ $beh->points_awarded ?? 0 }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Comportamientos del aula --}}
                <div class="guardian-card p-5">
                    <div class="section-title">📋 Comportamientos del Aula</div>
                    @if($behaviors->isEmpty())
                        <p class="text-gray-500 text-sm">El maestro aún no ha definido comportamientos.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($behaviors as $beh)
                            <div class="behavior-item" style="background:{{ ($beh->points ?? 0) >= 0 ? 'rgba(34,197,94,0.08)' : 'rgba(239,68,68,0.06)' }};border:1px solid {{ ($beh->points ?? 0) >= 0 ? 'rgba(34,197,94,0.2)' : 'rgba(239,68,68,0.15)' }};">
                                <span class="text-lg">{{ $beh->icon ?? (($beh->points ?? 0) >= 0 ? '✅' : '⚠️') }}</span>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-700 text-sm">{{ $beh->name }}</div>
                                    @if($beh->description)
                                    <div class="text-xs text-gray-500">{{ $beh->description }}</div>
                                    @endif
                                </div>
                                <span class="font-bold text-sm" style="color:{{ ($beh->points ?? 0) >= 0 ? '#16a34a' : '#dc2626' }};">
                                    {{ ($beh->points ?? 0) >= 0 ? '+' : '' }}{{ $beh->points ?? 0 }} pts
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Recompensas disponibles --}}
                <div class="guardian-card p-5">
                    <div class="section-title">🎁 Recompensas Disponibles</div>
                    @if($rewards->isEmpty())
                        <p class="text-gray-500 text-sm">El maestro aún no ha definido recompensas.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($rewards as $reward)
                            <div class="reward-item" style="background:linear-gradient(135deg,rgba(245,158,11,0.08),rgba(255,255,255,0.9));border:1px solid rgba(245,158,11,0.2);border-radius:10px;">
                                <span class="text-2xl">{{ $reward->icon ?? '🎁' }}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-sm truncate">{{ $reward->name }}</div>
                                    @if($reward->description)
                                    <div class="text-xs text-gray-500 truncate">{{ $reward->description }}</div>
                                    @endif
                                </div>
                                <span class="font-bold text-yellow-600 text-sm flex-shrink-0">{{ $reward->cost_points ?? 0 }} pts</span>
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
