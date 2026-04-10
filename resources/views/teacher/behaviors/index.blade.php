@extends('layouts.app')

@push('styles')
<style>
.behavior-section {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(59, 130, 246, 0.1);
    transition: all 0.3s ease;
}

.behavior-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15), 0 0 30px rgba(59, 130, 246, 0.2);
}

.behavior-item {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
    border: 1px solid rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
}

.behavior-item:hover {
    transform: translateX(4px);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.positive-item {
    border-left: 4px solid #10b981;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
}

.negative-item {
    border-left: 4px solid #ef4444;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
}

.action-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    font-weight: 600;
    transition: all 0.2s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.action-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.action-btn.delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.action-btn.delete:hover {
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
}

.stats-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.title-epic {
    font-family: 'Cinzel', serif;
    color: #1f2937;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}

.dashboard-bg {
    background: url('/fondo.png') center/cover;
    min-height: 100vh;
    position: relative;
}

.dashboard-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
    z-index: 1;
}

.dashboard-content {
    position: relative;
    z-index: 2;
}
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Título épico -->
            <div class="text-center mb-12">
                <h1 class="text-6xl font-bold title-epic mb-4" style="font-family: 'Cinzel Decorative', serif;">
                    ⭐ COMPORTAMIENTOS ÉPICOS ⭐
                </h1>
                <p class="text-2xl title-epic">Sistema de Recompensas y Consecuencias</p>
                <div class="mt-6">
                    <a href="{{ route('teacher.behaviors.create') }}" 
                       class="inline-block bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-200" 
                       style="font-family: 'Cinzel', serif; text-transform: uppercase;">
                        ✨ Crear Nuevo Comportamiento
                    </a>
                </div>
            </div>

            <!-- Secciones de comportamientos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                
                <!-- Comportamientos Positivos -->
                <div class="behavior-section rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-3xl font-bold title-epic flex items-center gap-4">
                            <span class="text-4xl">✅</span>
                            Comportamientos Positivos
                        </h3>
                        <span class="bg-green-500 text-white px-4 py-2 rounded-full text-lg font-bold shadow-lg">
                            {{ isset($behaviors) ? $behaviors->where('type', 'positive')->count() : 0 }}
                        </span>
                    </div>
                    
                    @if(isset($behaviors) && $behaviors->where('type', 'positive')->count() > 0)
                        <div class="space-y-4">
                            @foreach($behaviors->where('type', 'positive') as $behavior)
                                <div class="behavior-item positive-item rounded-xl p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-4">
                                            <span class="text-3xl">{{ $behavior->icon ?? '⭐' }}</span>
                                            <div>
                                                <h4 class="text-xl font-bold title-epic">{{ $behavior->name }}</h4>
                                                <p class="text-gray-600">{{ $behavior->description }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-3xl font-bold text-green-600">+{{ $behavior->points }}</div>
                                            <div class="text-green-500 text-sm font-semibold">puntos</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <a href="{{ route('teacher.behaviors.edit', $behavior) }}" 
                                           class="action-btn py-2 px-4 rounded-lg text-sm">
                                            ✏️ Editar
                                        </a>
                                        <form action="{{ route('teacher.behaviors.destroy', $behavior) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Estás seguro?')"
                                                    class="action-btn delete py-2 px-4 rounded-lg text-sm">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-8xl mb-4">✅</div>
                            <h4 class="text-2xl font-bold title-epic mb-3">No hay comportamientos positivos</h4>
                            <p class="text-gray-600 mb-6">Crea comportamientos positivos para recompensar a tus estudiantes.</p>
                            <a href="{{ route('teacher.behaviors.create') }}" class="action-btn py-3 px-6 rounded-lg">
                                ➕ Crear Comportamiento Positivo
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Comportamientos Negativos -->
                <div class="behavior-section rounded-2xl p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-3xl font-bold title-epic flex items-center gap-4">
                            <span class="text-4xl">❌</span>
                            Comportamientos Negativos
                        </h3>
                        <span class="bg-red-500 text-white px-4 py-2 rounded-full text-lg font-bold shadow-lg">
                            {{ isset($behaviors) ? $behaviors->where('type', 'negative')->count() : 0 }}
                        </span>
                    </div>
                    
                    @if(isset($behaviors) && $behaviors->where('type', 'negative')->count() > 0)
                        <div class="space-y-4">
                            @foreach($behaviors->where('type', 'negative') as $behavior)
                                <div class="behavior-item negative-item rounded-xl p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-4">
                                            <span class="text-3xl">{{ $behavior->icon ?? '⚠️' }}</span>
                                            <div>
                                                <h4 class="text-xl font-bold title-epic">{{ $behavior->name }}</h4>
                                                <p class="text-gray-600">{{ $behavior->description }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-3xl font-bold text-red-600">{{ $behavior->points }}</div>
                                            <div class="text-red-500 text-sm font-semibold">puntos</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <a href="{{ route('teacher.behaviors.edit', $behavior) }}" 
                                           class="action-btn py-2 px-4 rounded-lg text-sm">
                                            ✏️ Editar
                                        </a>
                                        <form action="{{ route('teacher.behaviors.destroy', $behavior) }}" method="POST" class="inline">

                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Estás seguro?')"
                                                    class="action-btn delete py-2 px-4 rounded-lg text-sm">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-8xl mb-4">❌</div>
                            <h4 class="text-2xl font-bold title-epic mb-3">No hay comportamientos negativos</h4>
                            <p class="text-gray-600 mb-6">Crea comportamientos negativos para establecer consecuencias.</p>
                            <a href="{{ route('teacher.behaviors.create') }}" class="action-btn py-3 px-6 rounded-lg">
                                ➕ Crear Comportamiento Negativo
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Estadísticas épicas -->
            <div class="stats-card rounded-2xl p-8">
                <h3 class="text-3xl font-bold title-epic mb-8 flex items-center gap-4">
                    <span class="text-4xl">📊</span>
                    Estadísticas Épicas del Sistema
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-blue-600 mb-3" style="font-family: 'Cinzel', serif;">
                            {{ isset($behaviors) ? $behaviors->count() : 0 }}
                        </div>
                        <div class="title-epic text-lg">Total Comportamientos</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-5xl font-bold text-green-600 mb-3" style="font-family: 'Cinzel', serif;">
                            {{ isset($behaviors) ? $behaviors->where('type', 'positive')->count() : 0 }}
                        </div>
                        <div class="title-epic text-lg">Positivos</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-5xl font-bold text-red-600 mb-3" style="font-family: 'Cinzel', serif;">
                            {{ isset($behaviors) ? $behaviors->where('type', 'negative')->count() : 0 }}
                        </div>
                        <div class="title-epic text-lg">Negativos</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-600 mb-3" style="font-family: 'Cinzel', serif;">
                            {{ isset($behaviors) ? $behaviors->sum('points') : 0 }}
                        </div>
                        <div class="title-epic text-lg">Puntos Totales</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Animación de entrada
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.behavior-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
});
</script>
@endpush