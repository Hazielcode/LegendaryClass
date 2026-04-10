<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 -mx-6 -mt-6 px-6 pt-6 pb-4">
            <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600" style="font-family: 'Cinzel', serif;">
                🎭 PERFIL DE {{ strtoupper($user->character_class ?? $user->name) }}
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
        
        .character-background {
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        .character-overlay {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.88) 0%,
                rgba(255, 255, 255, 0.82) 25%,
                rgba(255, 255, 255, 0.85) 50%,
                rgba(255, 255, 255, 0.82) 75%,
                rgba(255, 255, 255, 0.88) 100%
            );
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        /* Menú lateral */
        .character-sidebar {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 100%
            );
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.1),
                0 0 20px rgba(147, 51, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 1);
            position: sticky;
            top: 2rem;
            height: fit-content;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #374151;
            text-decoration: none;
            border-radius: 12px;
            margin: 0.5rem;
            transition: all 0.3s ease;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            cursor: pointer;
        }

        .sidebar-menu-item:hover {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.1), rgba(168, 85, 247, 0.05));
            color: #7c3aed;
            transform: translateX(4px);
        }

        .sidebar-menu-item.active {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        /* Panel principal */
        .character-main-panel {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 100%
            );
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.1),
                0 0 20px rgba(34, 197, 94, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        /* Avatar del personaje */
        .character-avatar-large {
            width: 200px;
            height: 200px;
            border-radius: 20px;
            border: 4px solid rgba(147, 51, 234, 0.6);
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.9), 
                rgba(147, 51, 234, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            margin: 0 auto;
            position: relative;
            box-shadow: 
                0 15px 40px rgba(147, 51, 234, 0.2),
                inset 0 2px 4px rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            background-image: var(--character-image);
            background-size: cover;
            background-position: center;
        }

        .tier-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-family: 'Cinzel', serif;
            font-weight: bold;
            font-size: 0.9rem;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .level-display {
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-family: 'Cinzel', serif;
            font-weight: bold;
            font-size: 1.2rem;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        /* Stats */
        .stat-bar {
            background: rgba(229, 231, 235, 0.8);
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.6);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-progress {
            height: 100%;
            border-radius: 8px;
            transition: width 0.8s ease;
            position: relative;
            background: var(--stat-gradient);
            box-shadow: 0 0 10px var(--stat-glow);
        }

        .stat-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Evolution cards */
        .evolution-card {
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.8) 100%
            );
            border: 2px solid rgba(203, 213, 225, 0.4);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .evolution-card.unlocked {
            border-color: rgba(34, 197, 94, 0.6);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.2);
        }

        .evolution-card.current {
            border-color: #7c3aed;
            background: linear-gradient(
                135deg,
                rgba(124, 58, 237, 0.1) 0%,
                rgba(168, 85, 247, 0.05) 100%
            );
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
        }

        .evolution-card.locked {
            opacity: 0.6;
            filter: grayscale(0.5);
        }

        .evolution-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            background-image: var(--evolution-image);
            background-size: cover;
            background-position: center;
        }

        /* Power meter */
        .power-meter {
            background: linear-gradient(135deg, #1f2937, #374151);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .power-meter::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(124, 58, 237, 0.1), 
                rgba(34, 197, 94, 0.1), 
                rgba(245, 158, 11, 0.1));
            opacity: 0.8;
        }

        .power-meter-content {
            position: relative;
            z-index: 1;
        }

        .power-number {
            font-family: 'Cinzel', serif;
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(45deg, #fbbf24, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
        }

        /* Content sections */
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Experience history */
        .exp-history-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            transition: all 0.3s ease;
        }

        .exp-history-item:hover {
            background: rgba(147, 51, 234, 0.05);
        }

        .exp-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        /* Achievement cards */
        .achievement-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
            border: 2px solid rgba(245, 158, 11, 0.4);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .achievement-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2);
        }

        .achievement-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .character-sidebar {
                position: static;
                margin-bottom: 2rem;
            }
            
            .character-avatar-large {
                width: 150px;
                height: 150px;
                font-size: 4rem;
            }
            
            .power-number {
                font-size: 2rem;
            }
        }
    </style>

    <div class="character-background">
        <div class="character-overlay"></div>
        
        <div class="relative z-10 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    
                    <!-- Menú lateral -->
                    <div class="lg:col-span-1">
                        <div class="character-sidebar p-6">
                            <h3 class="text-xl font-bold mb-6 text-center" style="font-family: 'Cinzel', serif;">
                                📋 Panel de Control
                            </h3>
                            
                            <nav class="space-y-2">
                                <div class="sidebar-menu-item active" data-section="overview">
                                    <span class="text-xl mr-3">👤</span>
                                    <span>Resumen</span>
                                </div>
                                <div class="sidebar-menu-item" data-section="stats">
                                    <span class="text-xl mr-3">📊</span>
                                    <span>Estadísticas</span>
                                </div>
                                <div class="sidebar-menu-item" data-section="evolution">
                                    <span class="text-xl mr-3">🔄</span>
                                    <span>Evoluciones</span>
                                </div>
                                <div class="sidebar-menu-item" data-section="achievements">
                                    <span class="text-xl mr-3">🏆</span>
                                    <span>Logros</span>
                                </div>
                                <div class="sidebar-menu-item" data-section="history">
                                    <span class="text-xl mr-3">📜</span>
                                    <span>Historial</span>
                                </div>
                            </nav>
                            
                            <!-- Medidor de poder total -->
                            <div class="power-meter mt-8">
                                <div class="power-meter-content">
                                    <div class="text-sm mb-2">PODER TOTAL</div>
                                    <div class="power-number">{{ $characterStats['total_power'] }}</div>
                                    <div class="text-xs opacity-80">Nivel {{ $characterStats['level'] }} {{ $characterStats['tier_name'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel principal -->
                    <div class="lg:col-span-3">
                        <div class="character-main-panel p-8">
                            
                            <!-- Sección: Resumen -->
                            <div id="overview" class="content-section active">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    
                                    <!-- Avatar del personaje -->
                                    <div class="text-center">
                                        <div class="character-avatar-large mb-6" 
                                             style="--character-image: url('{{ $evolutionData[($characterStats['tier'] - 1)]['image'] ?? '/images/characters/default_tier_1.png' }}');">
                                            @if(!file_exists(public_path($evolutionData[($characterStats['tier'] - 1)]['image'] ?? '')))
                                                {{ $user->character_icon ?? '⚔️' }}
                                            @endif
                                            <div class="tier-badge">{{ $characterStats['tier_name'] }}</div>
                                            <div class="level-display">NIV {{ $characterStats['level'] }}</div>
                                        </div>
                                        
                                        <h2 class="text-3xl font-bold mb-2" style="font-family: 'Cinzel', serif;">
                                            {{ $user->character_class ?? $user->name }}
                                        </h2>
                                        <p class="text-gray-600 mb-4">
                                            {{ $evolutionData[($characterStats['tier'] - 1)]['description'] ?? 'Un aventurero legendario' }}
                                        </p>
                                        
                                        @if($characterStats['next_evolution'])
                                            <div class="bg-gradient-to-r from-purple-100 to-blue-100 p-4 rounded-lg">
                                                <div class="text-sm font-bold text-purple-700 mb-1">
                                                    Próxima Evolución
                                                </div>
                                                <div class="text-lg font-bold text-purple-800">
                                                    {{ $characterStats['next_evolution']['tier_name'] }}
                                                </div>
                                                <div class="text-sm text-purple-600">
                                                    Faltan {{ $characterStats['next_evolution']['levels_remaining'] }} niveles
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Información y progreso -->
                                    <div>
                                        <h3 class="text-2xl font-bold mb-6" style="font-family: 'Cinzel', serif;">
                                            📈 Progreso de Aventurero
                                        </h3>
                                        
                                        <!-- Barra de XP -->
                                        <div class="mb-6">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="font-bold text-lg">Experiencia</span>
                                                <span class="text-sm font-semibold">
                                                    {{ number_format($characterStats['experience_points']) }} / 
                                                    {{ number_format($characterStats['next_level_xp']) }} XP
                                                </span>
                                            </div>
                                            <div class="stat-bar">
                                                <div class="stat-progress" 
                                                     style="width: {{ $characterStats['progress_percentage'] }}%; 
                                                            --stat-gradient: linear-gradient(90deg, #10b981, #34d399, #6ee7b7);
                                                            --stat-glow: rgba(16, 185, 129, 0.3);">
                                                </div>
                                            </div>
                                            <div class="text-center mt-2">
                                                <span class="text-sm text-gray-600">
                                                    {{ number_format($characterStats['next_level_xp'] - $characterStats['experience_points']) }} XP para el siguiente nivel
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Estadísticas rápidas -->
                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div class="text-center p-3 bg-blue-50 rounded-lg">
                                                <div class="text-2xl mb-1">🏆</div>
                                                <div class="font-bold text-blue-600">{{ $user->achievements_count ?? 0 }}</div>
                                                <div class="text-xs text-blue-500">Logros</div>
                                            </div>
                                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                                <div class="text-2xl mb-1">🗡️</div>
                                                <div class="font-bold text-green-600">{{ $user->quests_completed ?? 0 }}</div>
                                                <div class="text-xs text-green-500">Misiones</div>
                                            </div>
                                            <div class="text-center p-3 bg-yellow-50 rounded-lg">
                                                <div class="text-2xl mb-1">⭐</div>
                                                <div class="font-bold text-yellow-600">{{ $user->positive_points ?? 0 }}</div>
                                                <div class="text-xs text-yellow-500">Puntos +</div>
                                            </div>
                                            <div class="text-center p-3 bg-purple-50 rounded-lg">
                                                <div class="text-2xl mb-1">🎁</div>
                                                <div class="font-bold text-purple-600">{{ $user->rewards_earned ?? 0 }}</div>