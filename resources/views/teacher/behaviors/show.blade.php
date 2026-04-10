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
        border: 2px solid rgba(59,130,246,0.15);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
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
    .badge-positive {
        background: rgba(34,197,94,0.12); color: #15803d;
        border: 1px solid rgba(34,197,94,0.3);
        padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;
    }
    .badge-negative {
        background: rgba(239,68,68,0.1); color: #dc2626;
        border: 1px solid rgba(239,68,68,0.25);
        padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="show-bg">
<div class="show-content px-4 py-6 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 transition text-sm font-bold"
           style="font-family:'Cinzel',serif;">← Volver</a>
        <h1 class="text-2xl font-black text-gray-800" style="font-family:'Cinzel',serif;">
            📋 Detalle del Comportamiento
        </h1>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 rounded-xl text-green-800 text-sm font-semibold"
         style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);">
        ✅ {{ session('success') }}
    </div>
    @endif

    <div class="detail-card p-6 mb-6">
        <div class="flex items-start gap-5 flex-wrap">
            <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl flex-shrink-0"
                 style="background:linear-gradient(135deg,rgba(59,130,246,0.12),rgba(59,130,246,0.06));border:2px solid rgba(59,130,246,0.2);">
                {{ $behavior->icon ?? (($behavior->points ?? 0) >= 0 ? '✅' : '⚠️') }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap mb-2">
                    <h2 class="text-xl font-black text-gray-800" style="font-family:'Cinzel',serif;">
                        {{ $behavior->name }}
                    </h2>
                    <span class="{{ ($behavior->points ?? 0) >= 0 ? 'badge-positive' : 'badge-negative' }}">
                        {{ ($behavior->points ?? 0) >= 0 ? '+' : '' }}{{ $behavior->points ?? 0 }} pts
                    </span>
                    @if($behavior->is_active ?? true)
                    <span style="background:rgba(34,197,94,0.1);color:#15803d;border:1px solid rgba(34,197,94,0.25);padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:700;">
                        Activo
                    </span>
                    @else
                    <span style="background:rgba(107,114,128,0.1);color:#6b7280;border:1px solid rgba(107,114,128,0.2);padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:700;">
                        Inactivo
                    </span>
                    @endif
                </div>
                @if($behavior->description)
                <p class="text-gray-600 text-sm">{{ $behavior->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="detail-card p-5">
            <div class="section-title">📊 Detalles</div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tipo:</span>
                    <span class="font-semibold text-gray-800">{{ ($behavior->points ?? 0) >= 0 ? 'Positivo' : 'Negativo' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Puntos:</span>
                    <span class="font-bold" style="color:{{ ($behavior->points ?? 0) >= 0 ? '#15803d' : '#dc2626' }};">
                        {{ ($behavior->points ?? 0) >= 0 ? '+' : '' }}{{ $behavior->points ?? 0 }}
                    </span>
                </div>
                @if($behavior->category)
                <div class="flex justify-between">
                    <span class="text-gray-500">Categoría:</span>
                    <span class="font-semibold text-gray-800">{{ $behavior->category }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Estado:</span>
                    <span class="font-semibold" style="color:{{ ($behavior->is_active ?? true) ? '#15803d' : '#6b7280' }};">
                        {{ ($behavior->is_active ?? true) ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Creado:</span>
                    <span class="font-semibold text-gray-800">
                        {{ $behavior->created_at ? \Carbon\Carbon::parse($behavior->created_at)->format('d/m/Y') : '—' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="detail-card p-5">
            <div class="section-title">🏫 Aula</div>
            @php
                $classroom = $behavior->classroom ?? null;
                if (!$classroom && $behavior->classroom_id) {
                    $classroom = \App\Models\Classroom::find($behavior->classroom_id);
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
        </div>
    </div>

    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('teacher.behaviors.edit', $behavior->_id) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
           style="background:linear-gradient(135deg,#2563eb,#1d4ed8);font-family:'Cinzel',serif;">
            ✏️ Editar
        </a>
        <form method="POST" action="{{ route('teacher.behaviors.destroy', $behavior->_id) }}"
              onsubmit="return confirm('¿Eliminar este comportamiento?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm transition hover:opacity-90"
                    style="background:linear-gradient(135deg,#dc2626,#b91c1c);font-family:'Cinzel',serif;">
                🗑️ Eliminar
            </button>
        </form>
        <a href="{{ route('teacher.behaviors.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm transition hover:bg-gray-100"
           style="border:2px solid rgba(107,114,128,0.3);color:#374151;font-family:'Cinzel',serif;">
            ← Lista
        </a>
    </div>

</div>
</div>
@endsection
