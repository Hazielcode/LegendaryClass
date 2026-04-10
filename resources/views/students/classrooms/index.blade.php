@extends('layouts.app')

@push('styles')
<style>
/* Fuentes épicas */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');

.student-dashboard-bg {
    background: url('/fondo.png') center/cover;
    min-height: 100vh;
    position: relative;
}

.student-dashboard-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
    z-index: 1;
}

.student-content {
    position: relative;
    z-index: 2;
}

.student-header {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
    border: 2px solid rgba(59, 130, 246, 0.2);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.character-display {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
    border: 2px solid rgba(34, 197, 94, 0.3);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.join-button {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.join-button:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    color: white;
}

.classroom-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.classroom-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    border: 2px solid rgba(59, 130, 246, 0.2);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.classroom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: rgba(59, 130, 246, 0.4);
}

.classroom-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 1.5rem;
    position: relative;
}

.classroom-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
}

.classroom-title {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.classroom-description {
    font-size: 0.9rem;
    opacity: 0.9;
    line-height: 1.4;
}

.classroom-body {
    padding: 1.5rem;
}

.teacher-info {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.teacher-avatar {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
}

.teacher-details h4 {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.teacher-details p {
    color: #6b7280;
    font-size: 0.875rem;
}

.points-display {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1rem;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 1.5rem;
}

.points-number {
    font-size: 2rem;
    font-weight: 700;
    font-family: 'Cinzel', serif;
}

.points-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    border: 2px solid transparent;
}

.stat-missions {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    border-color: rgba(34, 197, 94, 0.2);
}

.stat-progress {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
    border-color: rgba(139, 92, 246, 0.2);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'Cinzel', serif;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.2;
}

.actions-row {
    display: flex;
    gap: 0.75rem;
}

.btn-enter {
    flex: 1;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 0.875rem;
    border-radius: 12px;
    font-weight: 600;
    font-family: 'Cinzel', serif;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-enter:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    color: white;
    text-decoration: none;
}

.btn-leave {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.875rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.2);
    cursor: pointer;
}

.btn-leave:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

.empty-state {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    border: 2px solid rgba(245, 158, 11, 0.3);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 3rem;
    margin-top: 2rem;
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    opacity: 0.8;
}

.empty-title {
    font-family: 'Cinzel Decorative', serif;
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
}

.empty-description {
    color: #6b7280;
    font-size: 1.125rem;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.title-epic {
    font-family: 'Cinzel Decorative', serif;
    background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 2px 4px rgba(184, 83, 9, 0.1);
}

/* Animaciones de entrada */
.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

.fade-in-delay {
    animation: fadeInUp 0.6s ease-out;
    animation-delay: 0.2s;
    animation-fill-mode: both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .classroom-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .student-header {
        padding: 1.5rem;
    }
    
    .actions-row {
        flex-direction: column;
    }
    
    .btn-enter {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')

<div class="student-dashboard-bg">
    <div class="student-content py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header del estudiante -->
            <div class="student-header p-6 fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Título y descripción -->
                    <div class="mb-6 lg:mb-0">
                        <h1 class="text-4xl font-bold title-epic mb-2">
                            🏰 MIS AULAS ÉPICAS
                        </h1>
                        <p class="text-lg text-gray-600">
                            Explora tus reinos de conocimiento y completa aventuras legendarias
                        </p>
                    </div>
                    
                    <!-- Información del personaje y botón -->
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Info del personaje -->
                        <div class="character-display p-4 flex items-center">
                            <div class="text-4xl mr-4">{{ auth()->user()->character_icon ?? '⚔️' }}</div>
                            <div>
                                <div class="font-bold text-lg text-green-700">
                                    {{ auth()->user()->character_class ?? 'Aventurero' }}
                                </div>
                                <div class="text-sm text-green-600">
                                    Nivel {{ auth()->user()->level ?? 1 }} • {{ auth()->user()->points ?? 0 }} Puntos
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón unirse -->
                        <a href="{{ route('students.join-classroom') }}" 
                           class="join-button px-6 py-3 rounded-xl font-bold font-serif text-lg">
                            🗝️ UNIRSE A AULA
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            @if(isset($myClassrooms) && $myClassrooms->isNotEmpty())
                <div class="classroom-grid fade-in-delay">
                    @foreach($myClassrooms as $classroom)
                        <div class="classroom-card">
                            <!-- Header de la tarjeta -->
                            <div class="classroom-header">
                                <span class="classroom-icon">🏫</span>
                                <h3 class="classroom-title">{{ $classroom->name }}</h3>
                                <p class="classroom-description">{{ $classroom->description }}</p>
                            </div>
                            
                            <!-- Cuerpo de la tarjeta -->
                            <div class="classroom-body">
                                <!-- Información del profesor -->
                                <div class="teacher-info">
                                    <div class="teacher-avatar">
                                        👨‍🏫
                                    </div>
                                    <div class="teacher-details">
                                        <h4>{{ $classroom->teacher->name ?? 'Profesor' }}</h4>
                                        <p>Maestro del Reino</p>
                                    </div>
                                </div>
                                
                                <!-- Mis puntos en esta aula -->
                                <div class="points-display">
                                    <div class="points-number">
                                        {{ auth()->user()->getPointsInClassroom($classroom->_id ?? $classroom->id) ?? 0 }}
                                    </div>
                                    <div class="points-label">Mis Puntos en Esta Aula</div>
                                </div>
                                
                                <!-- Estadísticas -->
                                <div class="stats-grid">
                                    <div class="stat-item stat-missions">
                                        <div class="stat-number text-green-600">{{ rand(8, 20) }}</div>
                                        <div class="stat-label">Misiones<br>Completadas</div>
                                    </div>
                                    <div class="stat-item stat-progress">
                                        <div class="stat-number text-purple-600">{{ rand(75, 95) }}%</div>
                                        <div class="stat-label">Progreso<br>General</div>
                                    </div>
                                </div>
                                
                                <!-- Acciones -->
                                <div class="actions-row">
                                    <a href="{{ route('students.classrooms.show', $classroom->_id ?? $classroom->id) }}"
                                       class="btn-enter">
                                        🚪 ENTRAR AL AULA
                                    </a>
                                    
                                    <form action="{{ route('students.leave-classroom', $classroom->_id ?? $classroom->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('¿Estás seguro de que quieres abandonar esta aula?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-leave">
                                            🚪
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vacío -->
                <div class="empty-state fade-in-delay">
                    <div class="empty-icon">🏰</div>
                    <h2 class="empty-title">¡Tu Aventura Épica Te Espera!</h2>
                    <p class="empty-description">
                        Aún no te has unido a ninguna aula mágica. Únete a tu primera aula 
                        y comienza tu emocionante viaje de aprendizaje lleno de misiones, 
                        recompensas y aventuras legendarias.
                    </p>
                    <a href="{{ route('students.join-classroom') }}" 
                       class="join-button px-8 py-4 rounded-xl font-bold font-serif text-xl inline-block">
                        🗝️ UNIRSE A MI PRIMERA AULA
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mensajes -->
@if(session('success'))
    <div class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 max-w-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-6 right-6 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 max-w-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">❌</span>
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
// Auto-ocultar mensajes
document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.fixed.bottom-6.right-6');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });
});
</script>
@endpush