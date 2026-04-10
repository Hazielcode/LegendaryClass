@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 relative overflow-hidden">
    <!-- Efectos de fondo -->
    <div class="absolute inset-0 bg-[url('/fondo.png')] bg-cover bg-center opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-transparent to-black/30"></div>
    
    <!-- Partículas flotantes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-yellow-400/30 rounded-full animate-pulse"></div>
        <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-blue-400/40 rounded-full animate-bounce"></div>
        <div class="absolute bottom-1/4 left-1/3 w-3 h-3 bg-purple-400/20 rounded-full animate-ping"></div>
        <div class="absolute top-1/2 right-1/4 w-1.5 h-1.5 bg-green-400/30 rounded-full animate-pulse"></div>
    </div>

    <div class="container mx-auto px-6 py-8 relative z-10">
        
        <!-- Header épico -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full mb-6 shadow-lg shadow-yellow-500/25">
                <span class="text-3xl">👤</span>
            </div>
            <h1 class="text-5xl font-bold text-white mb-3 font-cinzel">Perfil Legendario</h1>
            <div class="w-32 h-1 bg-gradient-to-r from-yellow-400 to-orange-500 mx-auto mb-4 rounded-full"></div>
            <p class="text-xl text-indigo-200">Información del aventurero épico</p>
        </div>

        <div class="max-w-6xl mx-auto">
            
            <!-- Tarjeta principal del perfil -->
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl shadow-black/20 mb-8 relative overflow-hidden">
                
                <!-- Efectos decorativos -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-400/10 to-purple-500/10 rounded-full translate-y-12 -translate-x-12"></div>
                
                <!-- Información principal -->
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 mb-10">
                        
                        <!-- Avatar y info básica -->
                        <div class="flex-shrink-0 text-center lg:text-left">
                            <div class="relative inline-block">
                                <div class="w-32 h-32 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-6xl shadow-lg shadow-yellow-500/25 relative z-10">
                                    {{ $targetUser->avatar_url }}
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full animate-ping opacity-20"></div>
                                @if($targetUser->role === 'student' && $targetUser->character_class)
                                    <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-2xl border-4 border-white/20">
                                        {{ $targetUser->character_icon }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Información del usuario -->
                        <div class="flex-1 text-center lg:text-left">
                            <h2 class="text-4xl font-bold text-white mb-3 font-cinzel">{{ $targetUser->name }}</h2>
                            <p class="text-xl text-indigo-200 mb-4 flex items-center justify-center lg:justify-start gap-2">
                                <span class="text-2xl">📧</span>
                                {{ $targetUser->email }}
                            </p>
                            
                            <div class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold shadow-lg {{ $targetUser->role_class }} border border-white/20">
                                <span class="mr-2 text-xl">
                                    @if($targetUser->role === 'teacher') 🧙‍♂️
                                    @elseif($targetUser->role === 'student') ⚔️
                                    @elseif($targetUser->role === 'director') 👑
                                    @elseif($targetUser->role === 'parent') 🛡️
                                    @else 👤 @endif
                                </span>
                                {{ $targetUser->role_name }}
                            </div>
                            
                            @if($targetUser->is_active)
                                <div class="inline-flex items-center ml-4 px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-sm border border-green-400/30">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    Activo
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Información del personaje (solo estudiantes) -->
                    @if($targetUser->role === 'student' && $targetUser->character_class)
                        <div class="bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-2xl p-8 mb-8 border border-purple-400/30 relative overflow-hidden">
                            <div class="absolute top-0 right-0 text-8xl opacity-10">🎭</div>
                            
                            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                                <span class="text-3xl">🎭</span>
                                Información del Personaje
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-4xl mb-3 mx-auto shadow-lg">
                                        {{ $targetUser->character_icon }}
                                    </div>
                                    <div class="text-white font-bold text-lg">{{ $targetUser->character_class }}</div>
                                    <div class="text-purple-200 text-sm">Clase</div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mb-3 mx-auto shadow-lg">
                                        <span class="text-3xl font-bold text-white">{{ $targetUser->level ?? 1 }}</span>
                                    </div>
                                    <div class="text-white font-bold text-lg">Nivel {{ $targetUser->level ?? 1 }}</div>
                                    <div class="text-yellow-200 text-sm">Poder</div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mb-3 mx-auto shadow-lg">
                                        <span class="text-2xl">⚡</span>
                                    </div>
                                    <div class="text-white font-bold text-lg">{{ number_format($targetUser->experience_points ?? 0) }}</div>
                                    <div class="text-blue-200 text-sm">Experiencia</div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mb-3 mx-auto shadow-lg">
                                        <span class="text-2xl">💰</span>
                                    </div>
                                    <div class="text-white font-bold text-lg">{{ $targetUser->points ?? 0 }}</div>
                                    <div class="text-green-200 text-sm">Puntos</div>
                                </div>
                            </div>
                            
                            <!-- Barra de progreso XP -->
                            @if($targetUser->level)
                                <div class="mt-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-white text-sm">Progreso al siguiente nivel</span>
                                        <span class="text-purple-200 text-sm">{{ number_format($targetUser->getCurrentLevelProgress(), 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-purple-900/30 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-full rounded-full transition-all duration-500 shadow-lg" 
                                             style="width: {{ $targetUser->getCurrentLevelProgress() }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Grid de información -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Información Personal -->
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-sm">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                                <span class="text-2xl">📋</span>
                                Información Personal
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-blue-300">👤</span>
                                    </div>
                                    <div>
                                        <label class="text-indigo-300 text-sm font-medium">Nombre Completo</label>
                                        <p class="text-white font-semibold">{{ $targetUser->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-green-300">📧</span>
                                    </div>
                                    <div>
                                        <label class="text-indigo-300 text-sm font-medium">Correo Electrónico</label>
                                        <p class="text-white font-semibold">{{ $targetUser->email }}</p>
                                    </div>
                                </div>
                                
                                @if($targetUser->phone)
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                            <span class="text-purple-300">📱</span>
                                        </div>
                                        <div>
                                            <label class="text-indigo-300 text-sm font-medium">Teléfono</label>
                                            <p class="text-white font-semibold">{{ $targetUser->phone }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($targetUser->date_of_birth)
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                            <span class="text-yellow-300">🎂</span>
                                        </div>
                                        <div>
                                            <label class="text-indigo-300 text-sm font-medium">Fecha de Nacimiento</label>
                                            <p class="text-white font-semibold">{{ $targetUser->date_of_birth->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-orange-300">📅</span>
                                    </div>
                                    <div>
                                        <label class="text-indigo-300 text-sm font-medium">Miembro desde</label>
                                        <p class="text-white font-semibold">{{ $targetUser->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas (solo estudiantes) -->
                        @if($targetUser->role === 'student')
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-sm">
                                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                                    <span class="text-2xl">📊</span>
                                    Estadísticas Épicas
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-3 bg-yellow-500/10 rounded-lg border border-yellow-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🏆</span>
                                            <span class="text-yellow-300 font-medium">Logros Desbloqueados</span>
                                        </div>
                                        <span class="text-2xl font-bold text-yellow-400">{{ $targetUser->achievements_count ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-green-500/10 rounded-lg border border-green-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">⚔️</span>
                                            <span class="text-green-300 font-medium">Misiones Completadas</span>
                                        </div>
                                        <span class="text-2xl font-bold text-green-400">{{ $targetUser->quests_completed ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-purple-500/10 rounded-lg border border-purple-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🎁</span>
                                            <span class="text-purple-300 font-medium">Recompensas Ganadas</span>
                                        </div>
                                        <span class="text-2xl font-bold text-purple-400">{{ $targetUser->rewards_earned ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-blue-500/10 rounded-lg border border-blue-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">⭐</span>
                                            <span class="text-blue-300 font-medium">Puntos Positivos</span>
                                        </div>
                                        <span class="text-2xl font-bold text-blue-400">{{ $targetUser->positive_points ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-red-500/10 rounded-lg border border-red-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">📚</span>
                                            <span class="text-red-300 font-medium">Tareas Completadas</span>
                                        </div>
                                        <span class="text-2xl font-bold text-red-400">{{ $targetUser->homework_completed ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Info adicional para otros roles -->
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-sm">
                                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                                    <span class="text-2xl">ℹ️</span>
                                    Información Adicional
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-3 bg-blue-500/10 rounded-lg border border-blue-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🔰</span>
                                            <span class="text-blue-300 font-medium">Estado de la Cuenta</span>
                                        </div>
                                        <span class="text-lg font-bold {{ $targetUser->is_active ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $targetUser->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 bg-purple-500/10 rounded-lg border border-purple-400/20">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">📊</span>
                                            <span class="text-purple-300 font-medium">Último Acceso</span>
                                        </div>
                                        <span class="text-lg font-bold text-purple-400">
                                            {{ $targetUser->last_login ? $targetUser->last_login->diffForHumans() : 'Nunca' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600/80 hover:bg-gray-600 text-white font-semibold rounded-xl transition duration-200 shadow-lg backdrop-blur-sm border border-gray-500/30">
                    <span class="mr-2">←</span>
                    Volver
                </a>
                
                @if(auth()->user()->canEditUser(auth()->user(), $targetUser))
                    <a href="{{ route('profile.edit.user', $targetUser->id) }}" 
                       class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-yellow-500/25 transform hover:scale-105">
                        <span class="mr-2">✏️</span>
                        Editar Perfil Legendario
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap');

.font-cinzel {
    font-family: 'Cinzel', serif;
}

/* Animaciones personalizadas */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Efecto de brillo en las tarjetas */
.bg-white\/10:hover {
    background: rgba(255, 255, 255, 0.15);
    transition: all 0.3s ease;
}
</style>
@endsection