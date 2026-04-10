<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LegendaryClass - {{ auth()->user()->character_class ?? auth()->user()->name }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Playfair Display', serif;
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.85) 0%,
                rgba(255, 255, 255, 0.75) 25%,
                rgba(255, 255, 255, 0.8) 50%,
                rgba(255, 255, 255, 0.75) 75%,
                rgba(255, 255, 255, 0.85) 100%);
            z-index: 0;
            pointer-events: none;
        }
        
        .main-content {
            position: relative;
            z-index: 1;
        }
        
        /* Header épico mejorado */
        .epic-header {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.98) 0%, 
                rgba(88, 28, 135, 0.95) 30%,
                rgba(124, 58, 237, 0.92) 50%,
                rgba(88, 28, 135, 0.95) 70%,
                rgba(15, 23, 42, 0.98) 100%);
            backdrop-filter: blur(25px);
            border-bottom: 4px solid transparent;
            border-image: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706, #92400e) 1;
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.3),
                0 0 60px rgba(251, 191, 36, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .epic-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(251, 191, 36, 0.05) 0%,
                transparent 25%,
                transparent 75%,
                rgba(251, 191, 36, 0.05) 100%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .epic-title {
            font-family: 'Cinzel', serif;
            font-weight: 900;
            font-size: 3rem;
            background: linear-gradient(45deg, #fbbf24, #f59e0b, #d97706, #92400e, #fbbf24);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 6px 12px rgba(251, 191, 36, 0.4);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            position: relative;
            animation: gradientFlow 4s ease-in-out infinite;
        }
        
        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .epic-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #fbbf24, #f59e0b, #fbbf24, transparent);
            border-radius: 2px;
            box-shadow: 0 0 20px rgba(251, 191, 36, 0.6);
        }

        /* Sección de evolución del personaje */
        .character-evolution-section {
            background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.98) 0%,
                rgba(255, 255, 255, 0.95) 50%,
                rgba(255, 255, 255, 0.98) 100%);
            backdrop-filter: blur(25px);
            border: 3px solid rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.12),
                0 0 30px rgba(147, 51, 234, 0.08),
                inset 0 2px 0 rgba(255, 255, 255, 1);
            height: 650px;
            overflow: hidden;
        }

        /* Panel de estadísticas */
        .character-stats-panel {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(51, 65, 85, 0.9));
            border: 2px solid rgba(148, 163, 184, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(15px);
            height: 100%;
            overflow-y: auto;
        }

        .stats-panel-title {
            font-family: 'Cinzel', serif;
            font-weight: bold;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1rem;
            color: #fbbf24;
            text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
        }

        /* Perfil del personaje sin recuadro */
        .character-profile-circle {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            padding: 0;
            background: none;
            border: none;
            border-radius: 0;
        }

        .profile-image-container {
            position: relative;
            margin-right: 0.8rem;
            margin-bottom: 0;
        }

        .profile-image {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 3px solid #fbbf24;
    box-shadow: 0 0 15px rgba(251, 191, 36, 0.4);
    object-fit: cover;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    overflow: hidden;
    padding: 5px; /* AGREGAR ESTA LÍNEA */
}

        .profile-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-name {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
            margin-bottom: 0.1rem;
        }

        .profile-class {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .available-points {
            background: linear-gradient(135deg, #1f2937, #374151);
            border: 2px solid #fbbf24;
            border-radius: 8px;
            padding: 0.4rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 0 15px rgba(251, 191, 36, 0.3);
        }

        .points-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
        }

        .points-left {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .points-icon {
            font-size: 1rem;
        }

        .points-number {
            font-family: 'Cinzel', serif;
            font-size: 1.2rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
        }

        .points-label {
            font-size: 0.6rem;
            opacity: 0.8;
            color: rgba(255, 255, 255, 0.8);
        }

        .stats-list-compact {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .stat-item-compact {
            background: rgba(55, 65, 81, 0.4);
            border: 1px solid rgba(107, 114, 128, 0.25);
            border-radius: 8px;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .stat-item-compact:hover {
            background: rgba(55, 65, 81, 0.6);
            border-color: rgba(251, 191, 36, 0.4);
            transform: scale(1.01);
        }

        .stat-header-compact {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.3rem;
        }

        .stat-info-compact {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .stat-icon-compact {
            font-size: 0.9rem;
        }

        .stat-name-compact {
            flex: 1;
            margin-left: 0.3rem;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .stat-value-compact {
            font-family: 'Cinzel', serif;
            font-weight: bold;
            color: #fbbf24;
            font-size: 0.85rem;
            margin-right: 0.4rem;
        }

        .stat-bar-compact {
            background: rgba(31, 41, 55, 0.8);
            height: 5px;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.3rem;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        .stat-progress-compact {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s ease;
            position: relative;
        }

        .stat-progress-compact::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .upgrade-btn-compact {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            border: none;
            border-radius: 4px;
            width: 36px;
            height: 30px;
            font-size: 0.55rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            line-height: 1;
        }

        .upgrade-btn-compact:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }

        /* Display del personaje */
        .character-game-display-compact {
            position: relative;
            background: linear-gradient(135deg, #1e293b, #334155);
            border: 3px solid #475569;
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.1);
        }

        .character-background-area-compact {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .character-bg-image-compact {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
        }

        .missing-background-compact {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #94a3b8;
            text-align: center;
        }

        .missing-bg-icon-compact {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .missing-bg-text-compact {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .missing-bg-subtext-compact {
            font-size: 1rem;
            opacity: 0.7;
        }

        .character-main-display-compact {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

        .character-image-compact {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 8px 25px rgba(0, 0, 0, 0.4));
    transition: all 0.5s ease;
    max-width: none;
    max-height: none;
}

        .missing-character-compact {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-align: center;
        }

        .missing-char-placeholder-compact {
            font-size: 8rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.5));
        }

        .missing-char-text-compact {
            background: rgba(0, 0, 0, 0.7);
            padding: 0.8rem 1.2rem;
            border-radius: 6px;
            font-size: 1rem;
        }

        .character-overlay-info-compact {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            pointer-events: none;
        }

        .character-tier-badge-compact {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, 
                {{ auth()->user()->level >= 75 ? '#dc2626, #ef4444' : (auth()->user()->level >= 50 ? '#7c3aed, #8b5cf6' : (auth()->user()->level >= 25 ? '#0891b2, #06b6d4' : '#f59e0b, #d97706')) }});
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 20px;
            font-family: 'Cinzel', serif;
            font-weight: bold;
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .character-level-display-compact {
            position: absolute;
            bottom: 120px;
            left: 20px;
            background: linear-gradient(135deg, #1f2937, #374151);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-family: 'Cinzel', serif;
            border: 2px solid rgba(251, 191, 36, 0.5);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            min-width: 100px;
        }

        .level-text-compact {
            display: block;
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.3rem;
        }

        .level-number-compact {
            display: block;
            font-size: 2rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
        }

        .character-info-bottom-compact {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 4;
        }

        .character-name-plate {
            background: rgba(0, 0, 0, 0.8);
            padding: 1rem 2rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            text-align: center;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .character-name-compact {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
            margin-bottom: 0.5rem;
        }

        /* SISTEMA DE EVOLUCIÓN - ANIMACIONES */
        
        /* Overlay de evolución */
        .evolution-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c, #667eea);
            background-size: 400% 400%;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: evolutionGradient 4s ease-in-out;
        }

        .evolution-content {
            text-align: center;
            color: white;
            font-family: 'Cinzel', serif;
            position: relative;
        }

        .evolution-character {
            font-size: 10rem;
            margin-bottom: 2rem;
            animation: evolutionPulse 1.5s ease-in-out infinite;
            filter: drop-shadow(0 0 30px rgba(255, 255, 255, 0.8));
        }

        .evolution-text {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(255, 255, 255, 1);
            animation: evolutionGlow 2s ease-in-out infinite;
        }

        .evolution-tier {
            font-size: 2rem;
            opacity: 0.9;
            margin-bottom: 1rem;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }

        .evolution-message {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.4;
        }

        .evolution-bonus {
            margin-top: 1.5rem;
            font-size: 1.5rem;
            color: #fbbf24;
            text-shadow: 0 0 20px rgba(251, 191, 36, 0.8);
            animation: evolutionBounce 1s ease-in-out infinite;
        }

        @keyframes evolutionGradient {
            0% { 
                background-position: 0% 50%; 
                opacity: 0; 
            }
            10% { 
                opacity: 1; 
            }
            90% { 
                opacity: 1; 
                background-position: 100% 50%; 
            }
            100% { 
                opacity: 0; 
                background-position: 0% 50%; 
            }
        }

        @keyframes evolutionPulse {
            0%, 100% { 
                transform: scale(1) rotate(0deg); 
            }
            50% { 
                transform: scale(1.2) rotate(5deg); 
            }
        }

        @keyframes evolutionGlow {
            0%, 100% { 
                text-shadow: 0 0 30px rgba(255, 255, 255, 1); 
            }
            50% { 
                text-shadow: 0 0 50px rgba(255, 255, 255, 1), 0 0 80px rgba(251, 191, 36, 0.8); 
            }
        }

        @keyframes evolutionBounce {
            0%, 100% { 
                transform: translateY(0); 
            }
            50% { 
                transform: translateY(-10px); 
            }
        }

        /* Animación de aparición del nuevo personaje */
        .character-evolved {
            animation: characterEvolution 3s ease-in-out;
        }

        @keyframes characterEvolution {
            0% { 
                transform: scale(0.3) rotate(-20deg);
                opacity: 0;
                filter: brightness(3) blur(10px) drop-shadow(0 0 50px rgba(255, 255, 255, 1));
            }
            30% {
                transform: scale(0.8) rotate(10deg);
                opacity: 0.6;
                filter: brightness(2) blur(5px) drop-shadow(0 0 30px rgba(251, 191, 36, 0.8));
            }
            70% {
                transform: scale(1.1) rotate(-5deg);
                opacity: 0.9;
                filter: brightness(1.5) blur(2px) drop-shadow(0 0 20px rgba(251, 191, 36, 0.6));
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
                filter: brightness(1) blur(0px) drop-shadow(0 8px 25px rgba(0, 0, 0, 0.4));
            }
        }

        /* Animación de partículas */
        .evolution-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #fbbf24;
            border-radius: 50%;
            animation: particleFloat 3s ease-out forwards;
        }

        @keyframes particleFloat {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-200px) scale(0);
            }
        }

        /* Cards de secciones */
        .adventure-card {
            backdrop-filter: blur(20px);
            background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 50%,
                rgba(255, 255, 255, 0.95) 100%);
            border: 3px solid rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.12),
                0 0 30px rgba(34, 197, 94, 0.1),
                inset 0 2px 0 rgba(255, 255, 255, 1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .adventure-card:hover {
            transform: translateY(-6px);
            box-shadow: 
                0 20px 50px rgba(0, 0, 0, 0.18),
                0 0 40px rgba(34, 197, 94, 0.15);
            border-color: rgba(34, 197, 94, 0.4);
        }
        
        .adventure-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #1f2937;
            text-shadow: 0 2px 4px rgba(255, 255, 255, 0.8);
        }
        
        /* Botones épicos */
        .quest-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-family: 'Cinzel', serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 2rem;
            border-radius: 15px;
            border: 3px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .quest-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .quest-button:hover::before {
            left: 100%;
        }
        
        .quest-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.6);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        /* Items de misiones */
        .quest-item {
            background: linear-gradient(135deg, rgba(255, 248, 220, 0.9), rgba(254, 243, 199, 0.8));
            border-left: 6px solid #f59e0b;
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.1);
        }
        
        .quest-item:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2);
            border-left-width: 8px;
        }
        
        /* Items de logros */
        .achievement-item {
            background: linear-gradient(135deg, rgba(236, 254, 255, 0.9), rgba(224, 242, 254, 0.8));
            border: 2px solid rgba(147, 51, 234, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .achievement-item:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(147, 51, 234, 0.2);
            border-color: rgba(147, 51, 234, 0.4);
        }
        
        /* Items de recompensas */
        .reward-item {
            background: linear-gradient(135deg, rgba(239, 246, 255, 0.9), rgba(219, 234, 254, 0.8));
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .reward-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
        }
        
        /* Estados vacíos */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }
        
        .empty-state-title {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #374151;
        }
        
        /* Grid responsivo */
        .grid {
            display: grid;
        }
        
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .lg\\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .lg\\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .lg\\:col-span-1 {
            grid-column: span 1 / span 1;
        }
        
        .lg\\:col-span-2 {
            grid-column: span 2 / span 2;
        }
        
        /* Forzar grid correcto para desktop */
        @media (min-width: 1024px) {
            .lg\\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
            
            .lg\\:col-span-1 {
                grid-column: span 1 / span 1 !important;
            }
            
            .lg\\:col-span-2 {
                grid-column: span 2 / span 2 !important;
            }
        }
        
        .gap-6 {
            gap: 1.5rem;
        }
        
        .gap-8 {
            gap: 2rem;
        }
        
        .max-w-7xl {
            max-width: 80rem;
        }
        
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .mb-8 {
            margin-bottom: 2rem;
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-white {
            color: white;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        
        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }
        
        .mr-3 {
            margin-right: 0.75rem;
        }
        
        .mr-4 {
            margin-right: 1rem;
        }
        
        .ml-4 {
            margin-left: 1rem;
        }
        
        .mt-6 {
            margin-top: 1.5rem;
        }
        
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }
        
        .from-green-50 {
            --tw-gradient-from: #f0fdf4;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgb(240 253 244 / 0));
        }
        
        .to-blue-50 {
            --tw-gradient-to: #eff6ff;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .border-2 {
            border-width: 2px;
        }
        
        .border-white {
            border-color: #ffffff;
        }
        
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .text-xs {
            font-size: 0.75rem;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .text-green-600 {
            color: #16a34a;
        }
        
        .text-gray-700 {
            color: #374151;
        }
        
        .text-purple-600 {
            color: #9333ea;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        .text-yellow-800 {
            color: #92400e;
        }
        
        .text-gray-500 {
            color: #6b7280;
        }
        
        .bg-yellow-200 {
            background-color: #fef3c7;
        }
        
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .rounded-full {
            border-radius: 9999px;
        }
        
        .mr-2 {
            margin-right: 0.5rem;
        }
        
        .mb-1 {
            margin-bottom: 0.25rem;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .mt-1 {
            margin-top: 0.25rem;
        }
        
        .mb-3 {
            margin-bottom: 0.75rem;
        }
        
        .flex-1 {
            flex: 1 1 0%;
        }
        
        .opacity-50 {
            opacity: 0.5;
        }
        
        /* Responsive */
        @media (max-width: 1023px) {
            .epic-title {
                font-size: 2.5rem;
            }
            
            .character-evolution-section {
                height: auto;
                min-height: 500px;
            }
            
            .character-image-compact {
                max-width: 250px;
                max-height: 320px;
            }
            
            .missing-char-placeholder-compact {
                font-size: 5rem;
            }
            
            .lg\\:grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .lg\\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .lg\\:col-span-1,
            .lg\\:col-span-2 {
                grid-column: span 1 / span 1;
            }
            
            .evolution-text {
                font-size: 2.5rem;
            }
            
            .evolution-character {
                font-size: 7rem;
            }
        }
        
        @media (max-width: 768px) {
            .epic-title {
                font-size: 2rem;
            }
            
            .character-evolution-section {
                height: auto;
            }
            
            .character-profile-circle {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .profile-image-container {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
            
            .profile-image {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .profile-name {
                font-size: 0.9rem;
            }
            
            .available-points {
                padding: 0.3rem;
                margin-bottom: 0.35rem;
            }
            
            .points-display {
                gap: 0.3rem;
            }
            
            .points-left {
                gap: 0.2rem;
            }
            
            .points-number {
                font-size: 1rem;
            }
            
            .points-icon {
                font-size: 0.8rem;
            }
            
            .points-label {
                font-size: 0.5rem;
            }
            
            .evolution-text {
                font-size: 2rem;
            }
            
            .evolution-character {
                font-size: 5rem;
            }
            
            .evolution-tier {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navegación incluida -->
    @include('layouts.navigation')
    
    <!-- Header épico mejorado -->
    <header class="epic-header">
        <div class="max-w-7xl mx-auto py-8 px-6">
            <h1 class="epic-title text-center">
                🏰 {{ auth()->user()->character_class ?? 'Aventurero' }} {{ strtoupper(auth()->user()->name) }}
            </h1>
            <div class="text-center" style="margin-top: 1rem;">
                <span class="text-white text-xl font-semibold" style="opacity: 0.8; font-family: 'Cinzel', serif;">
                    Nivel {{ auth()->user()->level ?? 3 }} • 
                    {{
                        auth()->user()->level >= 75 ? 'Legendario' : 
                        (auth()->user()->level >= 50 ? 'Épico' : 
                        (auth()->user()->level >= 25 ? 'Veterano' : 'Novato'))
                    }}
                </span>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content py-8">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Sección de evolución del personaje -->
            <div class="character-evolution-section p-6 mb-8">
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
                    
                    <!-- Panel izquierdo - Stats del personaje -->
                    <div>
                        <div class="character-stats-panel">
                            <h3 class="stats-panel-title">📊 ESTADÍSTICAS</h3>
                            
                            <!-- Perfil del personaje sin recuadro -->
                            <div class="character-profile-circle">
                                <div class="profile-image-container">
                                    <div class="profile-image">
    
    
    @if(auth()->user()->character_type)
        <img src="/images/escudos/escudo{{ auth()->user()->character_type }}.png" 
             alt="Escudo {{ auth()->user()->character_class }}" 
             style="width: 100%; height: 100%; object-fit: contain;"
             onerror="console.log('Error cargando escudo:', this.src);">
    @else
        {{ auth()->user()->character_icon ?? '🧙‍♂️' }}
    @endif
</div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-name">{{ strtoupper(auth()->user()->name) }}</div>
                                    @if(auth()->user()->character_class)
                                        <div class="profile-class">{{ auth()->user()->character_class }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Puntos disponibles con layout horizontal -->
                            <div class="available-points">
                                <div class="points-display">
                                    <div class="points-left">
                                        <span class="points-icon">💎</span>
                                        <span class="points-number">{{ auth()->user()->points ?? 250 }}</span>
                                    </div>
                                    <span class="points-label">Puntos Disponibles</span>
                                </div>
                            </div>
                            
                            <!-- Lista de stats compacta -->
                            <div class="stats-list-compact">
                                @php
                                    $stats = [
                                        'strength' => ['icon' => '💪', 'name' => 'Fuerza', 'color' => 'linear-gradient(90deg, #dc2626, #ef4444)'],
                                        'intelligence' => ['icon' => '🧠', 'name' => 'Inteligencia', 'color' => 'linear-gradient(90deg, #2563eb, #3b82f6)'],
                                        'agility' => ['icon' => '⚡', 'name' => 'Agilidad', 'color' => 'linear-gradient(90deg, #16a34a, #22c55e)'],
                                        'creativity' => ['icon' => '🎨', 'name' => 'Creatividad', 'color' => 'linear-gradient(90deg, #7c3aed, #8b5cf6)'],
                                        'leadership' => ['icon' => '👑', 'name' => 'Liderazgo', 'color' => 'linear-gradient(90deg, #ea580c, #f97316)'],
                                        'resilience' => ['icon' => '🛡️', 'name' => 'Resistencia', 'color' => 'linear-gradient(90deg, #0891b2, #06b6d4)']
                                    ];
                                @endphp
                                
                                @foreach($stats as $statKey => $stat)
                                    <div class="stat-item-compact">
                                        <div class="stat-header-compact">
                                            <div class="stat-info-compact">
                                                <span class="stat-icon-compact">{{ $stat['icon'] }}</span>
                                                <span class="stat-name-compact">{{ $stat['name'] }}</span>
                                            </div>
                                            <span class="stat-value-compact">{{ auth()->user()->{$statKey} ?? 10 }}</span>
                                            <button onclick="upgradeStat('{{ $statKey }}')" class="upgrade-btn-compact">
                                                +1<br>5💎
                                            </button>
                                        </div>
                                        <div class="stat-bar-compact">
                                            <div class="stat-progress-compact" 
                                                 style="width: {{ min(100, ((auth()->user()->{$statKey} ?? 10) / 50) * 100) }}%; background: {{ $stat['color'] }};"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Panel derecho - Display del personaje (ocupa 2/3 del espacio) -->
                    <div>
                        <div class="character-game-display-compact">
                           
                            
                            <!-- Personaje principal -->
                            <div class="character-main-display-compact">
    @if(auth()->user()->character_type && file_exists(public_path('/images/characters/' . strtolower(auth()->user()->character_type) . '_tier_' . (auth()->user()->level >= 75 ? 4 : (auth()->user()->level >= 50 ? 3 : (auth()->user()->level >= 25 ? 2 : 1))) . '.png')))
        <img src="/images/characters/{{ strtolower(auth()->user()->character_type) }}_tier_{{ auth()->user()->level >= 75 ? 4 : (auth()->user()->level >= 50 ? 3 : (auth()->user()->level >= 25 ? 2 : 1)) }}.png" 
             alt="Personaje" class="character-image-compact" id="character-main-image"
             style="width: 100%; height: 100%; object-fit: contain; max-width: none; max-height: none;">
    @else
        <div class="missing-character-compact">
            <div class="missing-char-placeholder-compact">
                {{ auth()->user()->character_icon ?? '🧙‍♂️' }}
            </div>
            <div class="missing-char-text-compact">Imagen del personaje no disponible</div>
        </div>
    @endif
</div>
                            
                            <!-- Overlay con información del personaje -->
                            <div class="character-overlay-info-compact">
                                <!-- Badge de tier -->
                                <div class="character-tier-badge-compact" id="tier-badge">
                                    {{
                                        auth()->user()->level >= 75 ? 'LEGENDARIO' : 
                                        (auth()->user()->level >= 50 ? 'ÉPICO' : 
                                        (auth()->user()->level >= 25 ? 'VETERANO' : 'NOVATO'))
                                    }}
                                </div>
                                
                                <!-- Display de nivel -->
                                <div class="character-level-display-compact">
                                    <span class="level-text-compact">NIVEL</span>
                                    <span class="level-number-compact" id="level-display">{{ auth()->user()->level ?? 3 }}</span>
                                </div>
                            </div>
                            
                            <!-- Información del personaje en la parte inferior -->
                            <div class="character-info-bottom-compact">
                                <div class="character-name-plate">
                                    <div class="character-name-compact">{{ auth()->user()->character_class ?? 'Aventurero' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secciones principales -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                <!-- Mis dominios (aulas) -->
                <div class="adventure-card p-6">
                    <h3 class="text-2xl font-bold adventure-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏰</span>
                        Mis Dominios Legendarios
                    </h3>
                    <div class="space-y-4">
                        @forelse($myClassrooms ?? [] as $classroom)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg border-2 border-white shadow-sm">
                                <div>
                                    <div class="font-bold adventure-title">{{ $classroom->name ?? 'Aula de Ejemplo' }}</div>
                                    <div class="text-sm text-gray-600">Maestro: {{ $classroom->teacher->name ?? 'Profesor Ejemplo' }}</div>
                                    <div class="text-xs text-green-600 mt-1">{{ $classroom->students_count ?? 25 }} aventureros</div>
                                </div>
                                <a href="{{ route('students.classroom.show', $classroom->_id) }}" class="quest-button">Entrar</a>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon">🏰</div>
                                <h4 class="empty-state-title">¡Aún no tienes dominios!</h4>
                                <p class="text-gray-600 mb-6">Únete a un aula para comenzar tu aventura educativa</p>
                                <a href="{{ route('students.join-classroom') }}" class="quest-button">🚪 Unirse a un Dominio</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Misiones activas -->
                <div class="adventure-card p-6">
                    <h3 class="text-2xl font-bold adventure-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🗡️</span>
                        Misiones Activas
                    </h3>
                    <div class="space-y-4">
                        @forelse($activeQuests ?? [] as $quest)
                            <div class="quest-item">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="font-bold adventure-title mb-1">{{ $quest->title ?? 'Misión de Ejemplo' }}</div>
                                        <div class="text-sm text-gray-700 mb-2">{{ $quest->description ?? 'Descripción de la misión' }}</div>
                                        <div class="flex items-center text-xs">
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full mr-2">
                                                +{{ $quest->xp_reward ?? 50 }} XP
                                            </span>
                                            <span class="text-gray-500">{{ $quest->type ?? 'general' }}</span>
                                        </div>
                                    </div>
                                    <button onclick="completeQuest({{ $quest->id ?? 1 }})" class="quest-button ml-4">✅ Completar</button>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon">🗡️</div>
                                <h4 class="empty-state-title">¡No hay misiones activas!</h4>
                                <p class="text-gray-600">Las misiones aparecerán cuando tus maestros las asignen</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Logros y tienda -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Logros recientes -->
                <div class="adventure-card p-6">
                    <h3 class="text-2xl font-bold adventure-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏆</span>
                        Logros Recientes
                    </h3>
                    <div class="space-y-3">
                        @forelse($recentAchievements ?? [] as $achievement)
                            <div class="achievement-item">
                                <div class="flex items-center">
                                    <div class="text-3xl mr-4">{{ $achievement->icon ?? '🏆' }}</div>
                                    <div class="flex-1">
                                        <div class="font-bold adventure-title">{{ $achievement->name ?? 'Logro de Ejemplo' }}</div>
                                        <div class="text-sm text-gray-600">{{ $achievement->description ?? 'Descripción del logro' }}</div>
                                        <div class="text-xs text-purple-600 mt-1">
                                            +{{ $achievement->xp_reward ?? 25 }} XP • {{ $achievement->unlocked_at ? $achievement->unlocked_at->diffForHumans() : 'Recientemente' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon">🏆</div>
                                <h4 class="empty-state-title">¡Próximamente tendrás logros!</h4>
                                <p class="text-gray-600">Completa misiones y tareas para desbloquear logros épicos</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @if(count($recentAchievements ?? []) > 0)
                        <div class="text-center mt-6">
                            <button onclick="alert('🏆 Próximamente: Ver todos los logros')" class="quest-button">
                                Ver Todos los Logros
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Tienda de recompensas -->
                <div class="adventure-card p-6">
                    <h3 class="text-2xl font-bold adventure-title mb-6 flex items-center">
                        <span class="text-3xl mr-3">🛒</span>
                        Tienda Legendaria
                    </h3>
                    <div class="space-y-3">
                        @forelse($availableRewards ?? [] as $reward)
                            <div class="reward-item">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <div class="text-3xl mr-4">{{ $reward->icon ?? '🎁' }}</div>
                                        <div>
                                            <div class="font-bold adventure-title">{{ $reward->name ?? 'Recompensa de Ejemplo' }}</div>
                                            <div class="text-sm text-gray-600">{{ $reward->description ?? 'Descripción de la recompensa' }}</div>
                                            <div class="text-xs text-blue-600 mt-1">
                                                💰 {{ $reward->cost ?? 50 }} puntos
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="buyReward({{ $reward->id ?? 1 }})" 
                                            class="quest-button {{ (auth()->user()->points ?? 0) < ($reward->cost ?? 50) ? 'opacity-50' : '' }}">
                                        {{ (auth()->user()->points ?? 0) >= ($reward->cost ?? 50) ? '🛒 Canjear' : '🔒 Bloqueado' }}
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon">🛒</div>
                                <h4 class="empty-state-title">¡Tienda en construcción!</h4>
                                <p class="text-gray-600">Pronto habrá recompensas increíbles disponibles</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @if(count($availableRewards ?? []) > 0)
                        <div class="text-center mt-6">
                            <div class="text-sm text-gray-600 mb-3">
                                Tienes {{ auth()->user()->points ?? 0 }} puntos disponibles
                            </div>
                            <button onclick="alert('🎁 Próximamente: Ver mis recompensas')" class="quest-button">
                                Ver Mis Recompensas
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts épicos con sistema de evolución -->
    <script>
        // Función para completar misiones CON SISTEMA DE EVOLUCIÓN
        function completeQuest(questId) {
            if (!confirm('¿Estás seguro de que has completado esta misión?')) return;
            
            const button = event.target;
            button.disabled = true;
            button.innerHTML = '⏳ Completando...';
            
            fetch(`/students/quests/${questId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Verificar si hay evolución
                    if (data.evolution) {
                        showEvolutionAnimation(data);
                    } else if (data.level_up) {
                        showLevelUpNotification(data);
                    } else {
                        showEpicNotification(`🎉 ¡Misión completada! +${data.xp} XP ganados`, 'success');
                    }
                    
                    setTimeout(() => {
                        location.reload();
                    }, data.evolution ? 6000 : 2000);
                } else {
                    showEpicNotification('❌ ' + (data.message || 'Error al completar la misión'), 'error');
                    button.disabled = false;
                    button.innerHTML = '✅ Completar';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showEpicNotification('❌ Error de conexión al completar la misión', 'error');
                button.disabled = false;
                button.innerHTML = '✅ Completar';
            });
        }

        // NUEVA FUNCIÓN: Animación épica de evolución
        function showEvolutionAnimation(data) {
            // Crear overlay de evolución
            const overlay = document.createElement('div');
            overlay.className = 'evolution-overlay';
            
            overlay.innerHTML = `
                <div class="evolution-content">
                    <div class="evolution-particles" id="particles-container"></div>
                    <div class="evolution-character">✨🌟✨</div>
                    <div class="evolution-text">¡EVOLUCIÓN!</div>
                    <div class="evolution-tier">${data.tier_name}</div>
                    <div class="evolution-message">
                        ${data.evolution_message || 'Tu personaje ha evolucionado y es más poderoso'}
                    </div>
                    <div class="evolution-bonus">
                        +${data.evolution_bonus || 50} puntos de bonificación
                    </div>
                </div>
            `;
            
            document.body.appendChild(overlay);
            
            // Crear partículas
            createEvolutionParticles();
            
            // Actualizar imagen del personaje si existe
            if (data.character_image) {
                setTimeout(() => {
                    const characterImg = document.getElementById('character-main-image');
                    if (characterImg) {
                        characterImg.src = data.character_image;
                        characterImg.classList.add('character-evolved');
                    }
                }, 3000);
            }
            
            // Actualizar badge de tier
            setTimeout(() => {
                const tierBadge = document.getElementById('tier-badge');
                if (tierBadge) {
                    tierBadge.textContent = data.tier_name.toUpperCase();
                }
            }, 3500);
            
            // Actualizar nivel
            setTimeout(() => {
                const levelDisplay = document.getElementById('level-display');
                if (levelDisplay) {
                    levelDisplay.textContent = data.new_level;
                }
            }, 4000);
            
            // Remover overlay después de 6 segundos
            setTimeout(() => {
                overlay.remove();
            }, 6000);
        }

        // Función para crear partículas de evolución
        function createEvolutionParticles() {
            const container = document.getElementById('particles-container');
            if (!container) return;
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 3 + 's';
                container.appendChild(particle);
                
                setTimeout(() => particle.remove(), 4000);
            }
        }

        // Función para subir de nivel sin evolución
        function showLevelUpNotification(data) {
            showEpicNotification(
                `🌟 ¡FELICIDADES! ¡Has subido al nivel ${data.new_level}! +${data.xp} XP ganados`, 
                'level-up'
            );
            
            // Actualizar nivel en pantalla
            setTimeout(() => {
                const levelDisplay = document.getElementById('level-display');
                if (levelDisplay) {
                    levelDisplay.textContent = data.new_level;
                }
            }, 1000);
        }

        // Función para comprar recompensas
        function buyReward(rewardId) {
            if (!confirm('¿Quieres canjear esta recompensa?')) return;
            
            const button = event.target;
            button.disabled = true;
            button.innerHTML = '⏳ Canjeando...';
            
            fetch(`/students/rewards/${rewardId}/buy`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showEpicNotification('🎁 ¡Recompensa canjeada con éxito!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showEpicNotification('❌ ' + (data.message || 'No tienes suficientes puntos'), 'error');
                    button.disabled = false;
                    button.innerHTML = '🛒 Canjear';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showEpicNotification('❌ Error de conexión al canjear la recompensa', 'error');
                button.disabled = false;
                button.innerHTML = '🛒 Canjear';
            });
        }

        // Función para subir estadísticas
        function upgradeStat(statName) {
            const cost = 5;
            const userPoints = {{ auth()->user()->points ?? 250 }};
            
            if (userPoints < cost) {
                showEpicNotification('❌ No tienes suficientes puntos. Necesitas ' + cost + ' 💎', 'error');
                return;
            }
            
            if (!confirm(`¿Subir ${statName} por ${cost} puntos?`)) return;
            
            const button = event.target;
            button.disabled = true;
            button.innerHTML = '⏳ Subiendo...';
            
            fetch('/students/upgrade-stat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    stat: statName,
                    cost: cost
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showEpicNotification(`🎉 ¡${statName} mejorado! +1 punto`, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showEpicNotification('❌ ' + (data.message || 'Error al mejorar estadística'), 'error');
                    button.disabled = false;
                    button.innerHTML = '+1<br>5💎';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showEpicNotification('❌ Error de conexión', 'error');
                button.disabled = false;
                button.innerHTML = '+1<br>5💎';
            });
        }

        // Función para mostrar notificaciones épicas
        function showEpicNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `epic-notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <span class="notification-text">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="notification-close">×</button>
                </div>
            `;
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 
                            type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' :
                            type === 'level-up' ? 'linear-gradient(135deg, #f59e0b, #d97706)' :
                            'linear-gradient(135deg, #3b82f6, #2563eb)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                font-family: 'Cinzel', serif;
                font-weight: bold;
                animation: slideInRight 0.5s ease, fadeOut 0.5s ease 4s forwards;
                max-width: 400px;
                border: 2px solid rgba(255, 255, 255, 0.3);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Animaciones CSS para las notificaciones
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            .notification-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .notification-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                margin-left: 1rem;
                opacity: 0.8;
                transition: opacity 0.3s;
            }
            .notification-close:hover {
                opacity: 1;
            }
        `;
        document.head.appendChild(notificationStyle);

        // Efectos de entrada para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.adventure-card, .stat-item-compact');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            const avatar = document.querySelector('.character-main-display-compact');
            if (avatar) {
                avatar.addEventListener('mouseenter', function() {
                    createParticles(this);
                });
            }
        });

        // Función para crear partículas épicas
        function createParticles(element) {
            for (let i = 0; i < 6; i++) {
                const particle = document.createElement('div');
                particle.innerHTML = ['✨', '⭐', '🌟', '💫'][Math.floor(Math.random() * 4)];
                particle.style.cssText = `
                    position: absolute;
                    font-size: 1.5rem;
                    pointer-events: none;
                    animation: particleFloat 2s ease-out forwards;
                    z-index: 1000;
                `;
                
                const rect = element.getBoundingClientRect();
                particle.style.left = (rect.left + Math.random() * rect.width) + 'px';
                particle.style.top = (rect.top + Math.random() * rect.height) + 'px';
                
                document.body.appendChild(particle);
                
                setTimeout(() => particle.remove(), 2000);
            }
        }

        // Animación de partículas
        const particleStyle = document.createElement('style');
        particleStyle.textContent = `
            @keyframes particleFloat {
                0% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
                100% {
                    opacity: 0;
                    transform: translateY(-100px) scale(0.5);
                }
            }
        `;
        document.head.appendChild(particleStyle);
    </script>
</body>
</html>