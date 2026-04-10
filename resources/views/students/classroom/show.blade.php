@extends('layouts.app')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.classroom-show-bg {
    background: url('/fondo.png') center/cover fixed;
    min-height: 100vh;
    position: relative;
}
.classroom-show-bg::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.88) 0%, rgba(255,255,255,0.82) 100%);
    z-index: 1;
}
.cs-content { position: relative; z-index: 2; }

.cs-header {
    background: linear-gradient(135deg, rgba(59,130,246,0.95) 0%, rgba(37,99,235,0.92) 100%);
    border-radius: 24px;
    border: 3px solid rgba(255,255,255,0.3);
    box-shadow: 0 15px 40px rgba(59,130,246,0.3);
    color: white;
}
.cs-title { font-family: 'Cinzel Decorative', serif; font-size: 2rem; font-weight: 900; }
.info-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.92) 100%);
    border-radius: 18px;
    border: 2px solid rgba(59,130,246,0.15);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}
.section-title {
    font-family: 'Cinzel', serif;
    font-weight: 700;
    color: #1e40af;
    font-size: 1rem;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.code-display {
    background: linear-gradient(135deg, #1e3a5f, #1e40af);
    color: white;
    font-family: 'Cinzel', serif;
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: 0.3em;
    border-radius: 14px;
    padding: 16px 24px;
    text-align: center;
    border: 2px solid rgba(255,255,255,0.2);
}
.leave-btn {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.leave-btn:hover { transform: scale(1.03); box-shadow: 0 5px 15px rgba(220,38,38,0.4); }
</style>
@endpush

@section('content')
<div class="classroom-show-bg">
<div class="cs-content px-4 py-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="cs-header p-6 mb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <div class="cs-title">🏰 {{ $classroom->name }}</div>
                <p class="text-blue-100 mt-1" style="font-family:'Cinzel',serif;">{{ $classroom->subject ?? '' }} — {{ $classroom->grade_level ?? '' }}</p>
                @if($classroom->description)
                <p class="text-blue-200 text-sm mt-2">{{ $classroom->description }}</p>
                @endif
            </div>
            <form method="POST" action="{{ route('students.leave-classroom', $classroom->_id) }}"
                  onsubmit="return confirm('¿Estás seguro que deseas abandonar esta aula?')">
                @csrf @method('DELETE')
                <button type="submit" class="leave-btn">🚪 Salir del Aula</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Info del aula --}}
        <div class="info-card p-5">
            <div class="section-title">📋 Información del Aula</div>
            <div class="space-y-3 text-sm">
                @if($classroom->teacher)
                <div class="flex items-center gap-2">
                    <span class="text-2xl">👨‍🏫</span>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $classroom->teacher->name }}</div>
                        <div class="text-gray-500 text-xs">Maestro</div>
                    </div>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <span class="text-xl">📚</span>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $classroom->subject ?? '—' }}</div>
                        <div class="text-gray-500 text-xs">Materia</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">🎓</span>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $classroom->grade_level ?? '—' }}</div>
                        <div class="text-gray-500 text-xs">Grado</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">👥</span>
                    <div>
                        <div class="font-semibold text-gray-800">{{ count($classroom->student_ids ?? []) }} estudiantes</div>
                        <div class="text-gray-500 text-xs">Inscritos</div>
                    </div>
                </div>
                @if($classroom->school_year)
                <div class="flex items-center gap-2">
                    <span class="text-xl">📅</span>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $classroom->school_year }}</div>
                        <div class="text-gray-500 text-xs">Año escolar</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Código de aula --}}
        <div class="info-card p-5">
            <div class="section-title">🔑 Código de Acceso</div>
            <div class="code-display mb-3">{{ $classroom->class_code ?? '——' }}</div>
            <p class="text-xs text-gray-500 text-center">Comparte este código con tus compañeros para que se unan</p>
        </div>

        {{-- Mis puntos en esta aula --}}
        <div class="info-card p-5 md:col-span-2">
            <div class="section-title">⭐ Mi Progreso en esta Aula</div>
            @php
                $studentPoint = \App\Models\StudentPoint::where('student_id', auth()->user()->_id)
                    ->where('classroom_id', $classroom->_id)
                    ->first();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-4 rounded-xl" style="background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));border:1px solid rgba(59,130,246,0.2);">
                    <div class="text-2xl font-black text-blue-600" style="font-family:'Cinzel',serif;">{{ $studentPoint->total_points ?? 0 }}</div>
                    <div class="text-xs text-gray-500">Puntos</div>
                </div>
                <div class="text-center p-4 rounded-xl" style="background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(124,58,237,0.05));border:1px solid rgba(124,58,237,0.2);">
                    <div class="text-2xl font-black text-purple-600" style="font-family:'Cinzel',serif;">{{ auth()->user()->level ?? 1 }}</div>
                    <div class="text-xs text-gray-500">Nivel</div>
                </div>
                <div class="text-center p-4 rounded-xl" style="background:linear-gradient(135deg,rgba(34,197,94,0.1),rgba(34,197,94,0.05));border:1px solid rgba(34,197,94,0.2);">
                    <div class="text-2xl font-black text-green-600" style="font-family:'Cinzel',serif;">{{ auth()->user()->quests_completed ?? 0 }}</div>
                    <div class="text-xs text-gray-500">Misiones</div>
                </div>
                <div class="text-center p-4 rounded-xl" style="background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));border:1px solid rgba(245,158,11,0.2);">
                    <div class="text-2xl font-black text-yellow-600" style="font-family:'Cinzel',serif;">{{ auth()->user()->achievements_count ?? 0 }}</div>
                    <div class="text-xs text-gray-500">Logros</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-between flex-wrap gap-3">
        <a href="{{ route('students.classrooms.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-gray-600 font-bold hover:bg-white/60 transition"
           style="font-family:'Cinzel',serif;border:2px solid rgba(107,114,128,0.3);">
            ← Mis Aulas
        </a>
        <a href="{{ route('students.store') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-bold transition hover:opacity-90"
           style="background:linear-gradient(135deg,#d97706,#b45309);font-family:'Cinzel',serif;">
            🛒 Tienda
        </a>
    </div>
</div>
</div>
@endsection
