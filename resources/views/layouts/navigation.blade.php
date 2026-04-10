<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&display=swap');
    
    .legendary-nav {
        background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 0.95) 0%,
            rgba(255, 255, 255, 0.9) 50%,
            rgba(255, 255, 255, 0.95) 100%
        );
        backdrop-filter: blur(20px);
        border-bottom: 2px solid rgba(184, 83, 9, 0.3);
        box-shadow: 
            0 2px 15px rgba(0, 0, 0, 0.08),
            0 0 15px rgba(217, 119, 6, 0.08);
        position: relative;
        z-index: 50;
    }
    
    .legendary-logo {
        font-family: 'Cinzel Decorative', serif;
        font-weight: 900;
        font-size: 1.25rem;
        background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 1px 2px rgba(184, 83, 9, 0.2);
        letter-spacing: 0.03em;
    }
    
    .nav-link {
        font-family: 'Cinzel', serif;
        font-weight: 600;
        color: #374151 !important;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1rem;
        text-decoration: none;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        height: 100%;
        position: relative;
    }
    
    .nav-link:hover {
        color: #b45309 !important;
        border-bottom-color: rgba(217, 119, 6, 0.5);
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8), 0 0 6px rgba(217, 119, 6, 0.2);
        transform: translateY(-1px);
    }
    
    .nav-link.active {
        color: #b45309 !important;
        border-bottom-color: #d97706;
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.12) 0%, rgba(245, 158, 11, 0.08) 100%);
        border-radius: 8px 8px 0 0;
    }
    
    /* Efecto especial para la tienda */
    .nav-link.store-link {
        position: relative;
        overflow: hidden;
    }
    
    .nav-link.store-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(147, 51, 234, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .nav-link.store-link:hover::before {
        left: 100%;
    }
    
    .dropdown-button {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(203, 213, 225, 0.5);
        border-radius: 8px;
        color: #374151;
        font-family: 'Cinzel', serif;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        z-index: 60;
    }
    
    .dropdown-button:hover {
        border-color: rgba(217, 119, 6, 0.4);
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 2px 10px rgba(217, 119, 6, 0.15);
    }
    
    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 6px;
        width: 280px;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(25px);
        border: 2px solid rgba(217, 119, 6, 0.3);
        border-radius: 12px;
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.12),
            0 0 25px rgba(217, 119, 6, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        padding: 12px;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.3s ease;
    }
    
    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-header {
        padding: 10px;
        border-bottom: 1px solid rgba(203, 213, 225, 0.3);
        margin-bottom: 10px;
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 6px 10px;
        color: #374151;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        font-family: 'Cinzel', serif;
        font-weight: 500;
        margin-bottom: 2px;
        font-size: 0.9rem;
    }
    
    .dropdown-item:hover {
        background: rgba(217, 119, 6, 0.1);
        color: #b45309;
        transform: translateX(2px);
    }
    
    .character-info {
        display: flex;
        align-items: center;
        background: rgba(34, 197, 94, 0.1);
        border: 2px solid rgba(34, 197, 94, 0.3);
        border-radius: 16px;
        padding: 0.375rem 0.75rem;
        margin-right: 0.75rem;
    }
    
    .character-avatar-small {
        font-size: 1.25rem;
        margin-right: 0.375rem;
    }
    
    .character-level {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #059669;
        font-size: 0.8rem;
    }
    
    .nav-xp-bar {
        width: 80px;
        height: 4px;
        background: rgba(203, 213, 225, 0.3);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.2rem;
    }
    
    .nav-xp-progress {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 2px;
        transition: width 0.5s ease;
    }
    
    .mobile-menu {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-top: 2px solid rgba(217, 119, 6, 0.3);
        z-index: 40;
    }
    
    .mobile-nav-link {
        display: block;
        padding: 0.75rem;
        color: #374151;
        text-decoration: none;
        font-family: 'Cinzel', serif;
        font-weight: 600;
        border-bottom: 1px solid rgba(203, 213, 225, 0.2);
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    
    .mobile-nav-link:hover {
        background: rgba(217, 119, 6, 0.1);
        color: #b45309;
    }
    
    /* Indicador de puntos en navegación */
    .points-indicator {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #92400e;
        font-size: 0.7rem;
        font-weight: bold;
        padding: 0.2rem 0.4rem;
        border-radius: 10px;
        margin-left: 0.3rem;
        box-shadow: 0 2px 4px rgba(251, 191, 36, 0.3);
    }
</style>

<nav class="legendary-nav border-b border-gray-100 relative z-50" 
     x-data="{ open: false }">
     
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <span class="legendary-logo">⚔️ LEGENDARYCLASS</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex items-center h-full">
                    @if(auth()->user()->role === 'director')
                        <a href="{{ route('director.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('director.dashboard') ? 'active' : '' }}">
                            👑 Mi Reino
                        </a>
                        <a href="{{ route('director.teachers') }}" 
                           class="nav-link {{ request()->routeIs('director.teachers') ? 'active' : '' }}">
                            🧙‍♂️ Maestros
                        </a>
                        <a href="{{ route('director.students') }}" 
                           class="nav-link {{ request()->routeIs('director.students') ? 'active' : '' }}">
                            ⚔️ Estudiantes
                        </a>
                        <a href="{{ route('director.classrooms') }}" 
                           class="nav-link {{ request()->routeIs('director.classrooms') ? 'active' : '' }}">
                            🏰 Aulas
                        </a>
                        <a href="{{ route('director.reports') }}" 
                           class="nav-link {{ request()->routeIs('director.reports') ? 'active' : '' }}">
                            📊 Reportes
                        </a>
                        <a href="{{ route('director.user-management') }}" 
                           class="nav-link {{ request()->routeIs('director.user-management') ? 'active' : '' }}">
                            👥 Usuarios
                        </a>
                    @elseif(auth()->user()->role === 'teacher')
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            🧙‍♂️ Mis Dominios
                        </a>
                        <a href="{{ route('teacher.classrooms.index') }}" 
                           class="nav-link {{ request()->routeIs('teacher.classrooms.*') ? 'active' : '' }}">
                            🏰 Aulas Mágicas
                        </a>
                        <a href="{{ route('teacher.behaviors.index') }}" 
                           class="nav-link {{ request()->routeIs('teacher.behaviors.*') ? 'active' : '' }}">
                            ⭐ Comportamientos
                        </a>
                        <a href="{{ route('teacher.rewards.index') }}" 
                           class="nav-link {{ request()->routeIs('teacher.rewards.*') ? 'active' : '' }}">
                            🎁 Recompensas
                        </a>
                    @elseif(auth()->user()->role === 'student')
                        <a href="{{ route('students.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('students.dashboard') ? 'active' : '' }}">
                            ⚔️ Mi Aventura
                        </a>
                        <a href="{{ route('students.classrooms.index') }}" 
                           class="nav-link {{ request()->routeIs('students.classrooms.*') ? 'active' : '' }}">
                            🏰 Mis Dominios
                        </a>
                        <a href="{{ route('students.store') }}" 
                           class="nav-link store-link {{ request()->routeIs('students.store*') ? 'active' : '' }}">
                            🛒 Tienda
                            <span class="points-indicator">{{ auth()->user()->points ?? 0 }}💎</span>
                        </a>
                        <a href="{{ route('students.my-rewards') }}" 
                           class="nav-link {{ request()->routeIs('students.my-rewards*') ? 'active' : '' }}">
                            🎒 Mis Recompensas
                        </a>
                        <a href="{{ route('students.achievements') }}" 
                           class="nav-link {{ request()->routeIs('students.achievements*') ? 'active' : '' }}">
                            🏆 Logros
                        </a>
                    @elseif(auth()->user()->role === 'parent')
                        <a href="{{ route('parent.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                            🛡️ Mis Hijos
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if(auth()->user()->role === 'student' && auth()->user()->character_class)
                    <div class="character-info mr-3">
                        <span class="character-avatar-small">{{ auth()->user()->character_icon ?? '⚔️' }}</span>
                        <div>
                            <div class="character-level">Nv.{{ auth()->user()->level ?? 1 }}</div>
                            <div class="nav-xp-bar">
                                <div class="nav-xp-progress" style="width: {{ min(100, ((auth()->user()->experience_points ?? 0) / ((auth()->user()->level ?? 1) * 100)) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="relative">
                    <button @click="open = !open" class="dropdown-button">
                        <div class="flex items-center">
                            @if(auth()->user()->role === 'director')
                                <div class="text-xl mr-2">👑</div>
                            @elseif(auth()->user()->role === 'teacher')
                                <div class="text-xl mr-2">🧙‍♂️</div>
                            @elseif(auth()->user()->role === 'student')
                                <div class="text-xl mr-2">{{ auth()->user()->character_icon ?? '⚔️' }}</div>
                            @elseif(auth()->user()->role === 'parent')
                                <div class="text-xl mr-2">🛡️</div>
                            @else
                                <div class="text-xl mr-2">👤</div>
                            @endif
                            <div>
                                <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-xs opacity-75">
                                    @if(auth()->user()->role === 'director')
                                        Director{{ (auth()->user()->gender ?? '') === 'female' ? 'a' : '' }}
                                    @elseif(auth()->user()->role === 'teacher')
                                        Profesor{{ (auth()->user()->gender ?? '') === 'female' ? 'a' : '' }}
                                    @elseif(auth()->user()->role === 'student')
                                        {{ auth()->user()->character_class ?? 'Estudiante' }}
                                    @elseif(auth()->user()->role === 'parent')
                                        Padre/Madre
                                    @else
                                        Usuario
                                    @endif
                                </div>
                            </div>
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200" 
                                 :class="{'rotate-180': open}" 
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-1 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-1 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="dropdown-menu"
                         style="display: none;">
                        
                        <div class="dropdown-header">
                            <div class="flex items-center">
                                @if(auth()->user()->role === 'director')
                                    <div class="text-xl mr-2">👑</div>
                                @elseif(auth()->user()->role === 'teacher')
                                    <div class="text-xl mr-2">🧙‍♂️</div>
                                @elseif(auth()->user()->role === 'student')
                                    <div class="text-xl mr-2">{{ auth()->user()->character_icon ?? '⚔️' }}</div>
                                @elseif(auth()->user()->role === 'parent')
                                    <div class="text-xl mr-2">🛡️</div>
                                @else
                                    <div class="text-xl mr-2">👤</div>
                                @endif
                                <div>
                                    <div class="font-bold text-sm" style="font-family: 'Cinzel', serif;">{{ Auth::user()->name }}</div>
                                    <div class="text-xs opacity-75">{{ Auth::user()->email }}</div>
                                    @if(auth()->user()->role === 'student')
                                        <div class="text-xs opacity-75 mt-1">
                                            💎 {{ auth()->user()->points ?? 0 }} puntos • Nv.{{ auth()->user()->level ?? 1 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <span class="text-sm mr-2">👤</span>
                            <span>Mi Perfil</span>
                        </a>

                        <a href="{{ route('profile.edit.user', auth()->id()) }}" class="dropdown-item">
                            <span class="text-sm mr-2">⚙️</span>
                            <span>Configuración</span>
                        </a>

                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('students.store') }}" class="dropdown-item">
                                <span class="text-sm mr-2">🛒</span>
                                <span>Tienda Legendaria</span>
                            </a>
                            <a href="{{ route('students.my-rewards') }}" class="dropdown-item">
                                <span class="text-sm mr-2">🎒</span>
                                <span>Mis Recompensas</span>
                            </a>
                            <a href="{{ route('students.character.profile') }}" class="dropdown-item">
                                <span class="text-sm mr-2">🛡️</span>
                                <span>Mi Personaje</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'director')
                            <a href="{{ route('teacher.behaviors.index') }}" class="dropdown-item">
                                <span class="text-sm mr-2">📝</span>
                                <span>Gestión</span>
                            </a>
                        @endif

                        <hr class="my-2 border-gray-200">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item w-full text-left">
                                <span class="text-sm mr-2">🚪</span>
                                <span>Salir</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="dropdown-button">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'director')
                <a href="{{ route('director.dashboard') }}" class="mobile-nav-link">👑 Mi Reino</a>
                <a href="{{ route('director.teachers') }}" class="mobile-nav-link">🧙‍♂️ Maestros</a>
                <a href="{{ route('director.students') }}" class="mobile-nav-link">⚔️ Estudiantes</a>
                <a href="{{ route('director.classrooms') }}" class="mobile-nav-link">🏰 Aulas</a>
                <a href="{{ route('director.reports') }}" class="mobile-nav-link">📊 Reportes</a>
                <a href="{{ route('director.user-management') }}" class="mobile-nav-link">👥 Usuarios</a>
            @elseif(auth()->user()->role === 'teacher')
                <a href="{{ route('dashboard') }}" class="mobile-nav-link">🧙‍♂️ Mis Dominios</a>
                <a href="{{ route('teacher.classrooms.index') }}" class="mobile-nav-link">🏰 Aulas Mágicas</a>
                <a href="{{ route('teacher.behaviors.index') }}" class="mobile-nav-link">⭐ Comportamientos</a>
                <a href="{{ route('teacher.rewards.index') }}" class="mobile-nav-link">🎁 Recompensas</a>
            @elseif(auth()->user()->role === 'student')
                <a href="{{ route('students.dashboard') }}" class="mobile-nav-link">⚔️ Mi Aventura</a>
                <a href="{{ route('students.classrooms.index') }}" class="mobile-nav-link">🏰 Mis Dominios</a>
                <a href="{{ route('students.store') }}" class="mobile-nav-link">
                    🛒 Tienda <span class="points-indicator">{{ auth()->user()->points ?? 0 }}💎</span>
                </a>
                <a href="{{ route('students.my-rewards') }}" class="mobile-nav-link">🎒 Mis Recompensas</a>
                <a href="{{ route('students.achievements') }}" class="mobile-nav-link">🏆 Logros</a>
            @elseif(auth()->user()->role === 'parent')
                <a href="{{ route('parent.dashboard') }}" class="mobile-nav-link">🛡️ Mis Hijos</a>
            @endif
        </div>

        <div class="pt-3 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                @if(auth()->user()->role === 'student')
                    <div class="font-medium text-xs text-gray-500 mt-1">
                        💎 {{ auth()->user()->points ?? 0 }} puntos • Nv.{{ auth()->user()->level ?? 1 }}
                    </div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.show') }}" class="mobile-nav-link">👤 Mi Perfil</a>
                @if(auth()->user()->role === 'student')
                    <a href="{{ route('students.character.profile') }}" class="mobile-nav-link">🛡️ Mi Personaje</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link w-full text-left">🚪 Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.querySelector('.dropdown-button');
        const dropdownMenu = document.querySelector('.dropdown-menu');
        
        if (dropdownButton && dropdownMenu) {
            let isOpen = false;
            
            function toggleDropdown(e) {
                e.preventDefault();
                e.stopPropagation();
                
                isOpen = !isOpen;
                
                if (isOpen) {
                    dropdownMenu.style.display = 'block';
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.visibility = 'visible';
                    dropdownMenu.style.transform = 'translateY(-8px)';
                    
                    dropdownMenu.offsetHeight;
                    
                    dropdownMenu.style.transition = 'all 0.3s ease';
                    dropdownMenu.style.opacity = '1';
                    dropdownMenu.style.transform = 'translateY(0)';
                    
                    const arrow = dropdownButton.querySelector('svg');
                    if (arrow) {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                } else {
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.transform = 'translateY(-8px)';
                    
                    setTimeout(() => {
                        dropdownMenu.style.display = 'none';
                        dropdownMenu.style.visibility = 'hidden';
                    }, 300);
                    
                    const arrow = dropdownButton.querySelector('svg');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            }
            
            dropdownButton.addEventListener('click', toggleDropdown);
            
            document.addEventListener('click', function(e) {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    if (isOpen) {
                        isOpen = true;
                        toggleDropdown({ preventDefault: () => {}, stopPropagation: () => {} });
                    }
                }
            });
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isOpen) {
                    isOpen = true;
                    toggleDropdown({ preventDefault: () => {}, stopPropagation: () => {} });
                }
            });
        }

        // Efecto especial para la tienda con animación de partículas
        const storeLink = document.querySelector('.store-link');
        if (storeLink) {
            storeLink.addEventListener('mouseenter', function() {
                // Crear partículas mágicas alrededor del enlace de la tienda
                for (let i = 0; i < 5; i++) {
                    setTimeout(() => {
                        createMagicParticle(this);
                    }, i * 100);
                }
            });
        }

        function createMagicParticle(element) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: linear-gradient(45deg, #9333ea, #7c3aed);
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                animation: magicFloat 2s ease-out forwards;
            `;
            
            const rect = element.getBoundingClientRect();
            particle.style.left = (rect.left + Math.random() * rect.width) + 'px';
            particle.style.top = (rect.top + Math.random() * rect.height) + 'px';
            
            document.body.appendChild(particle);
            
            setTimeout(() => {
                if (particle.parentNode) {
                    particle.remove();
                }
            }, 2000);
        }

        // Agregar animación CSS para las partículas
        if (!document.querySelector('#magic-particles-style')) {
            const style = document.createElement('style');
            style.id = 'magic-particles-style';
            style.textContent = `
                @keyframes magicFloat {
                    0% {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }
                    100% {
                        opacity: 0;
                        transform: translateY(-30px) scale(0.5);
                    }
                }
                
                @keyframes shimmerEffect {
                    0% { background-position: -200% 0; }
                    100% { background-position: 200% 0; }
                }
                
                .store-link {
                    background: linear-gradient(
                        90deg,
                        transparent 0%,
                        rgba(147, 51, 234, 0.1) 50%,
                        transparent 100%
                    );
                    background-size: 200% 100%;
                    animation: shimmerEffect 3s infinite;
                }
                
                .points-indicator {
                    animation: pointsPulse 2s ease-in-out infinite;
                }
                
                @keyframes pointsPulse {
                    0%, 100% { 
                        transform: scale(1);
                        box-shadow: 0 2px 4px rgba(251, 191, 36, 0.3);
                    }
                    50% { 
                        transform: scale(1.05);
                        box-shadow: 0 4px 8px rgba(251, 191, 36, 0.5);
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Actualizar puntos en tiempo real (si hay sistema de WebSocket o polling)
        function updatePointsDisplay() {
            const pointsElements = document.querySelectorAll('.points-indicator');
            pointsElements.forEach(element => {
                element.style.animation = 'none';
                element.offsetHeight; // Trigger reflow
                element.style.animation = 'pointsPulse 1s ease-in-out';
            });
        }

        // Efecto de hover mejorado para todos los nav-links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>