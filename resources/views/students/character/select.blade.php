<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selecciona tu Aventurero - LegendaryClass</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .epic-title {
            font-family: 'Cinzel', serif;
            font-weight: 900;
            font-size: 4rem;
            background: linear-gradient(45deg, #fbbf24, #f59e0b, #d97706, #92400e, #fbbf24);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 8px 16px rgba(251, 191, 36, 0.4);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            animation: gradientFlow 4s ease-in-out infinite;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .character-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transition: all 0.4s ease;
            cursor: pointer;
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .character-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--character-gradient));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }
        
        .character-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.8);
        }
        
        .character-card:hover::before {
            opacity: 0.1;
        }
        
        .character-card.selected {
            border-color: #fbbf24;
            box-shadow: 0 0 40px rgba(251, 191, 36, 0.6);
            transform: scale(1.08);
        }
        
        .character-card.selected::before {
            opacity: 0.15;
        }
        
        .character-content {
            position: relative;
            z-index: 1;
        }
        
        .character-avatar {
            text-align: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .character-image-container {
            position: relative;
            display: inline-block;
        }
        
        .character-shield {
            position: absolute;
            top: -10px;
            right: -10px;
            z-index: 2;
            animation: float 3s ease-in-out infinite;
        }
        
        .character-card:hover .character-avatar {
            transform: scale(1.1);
        }
        
        .character-card:hover .character-shield {
            animation: floatFast 1.5s ease-in-out infinite;
        }
        
        @keyframes floatFast {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(5deg); }
        }
        
        .character-name {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            color: #1f2937;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .character-description {
            text-align: center;
            color: #4b5563;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 1rem;
        }
        
        .character-bonus {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
            border: 2px solid #d1d5db;
        }
        
        .bonus-text {
            font-weight: bold;
            color: #059669;
            font-size: 0.9rem;
        }
        
        .character-stats {
            margin-bottom: 1.5rem;
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #374151;
        }
        
        .select-button {
            width: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-family: 'Cinzel', serif;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .select-button:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6);
        }
        
        .select-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .welcome-text {
            text-align: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 3rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .floating-particles {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        
        .loading-content {
            color: white;
            text-align: center;
            font-family: 'Cinzel', serif;
        }
        
        .loading-spinner {
            font-size: 3rem;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .epic-title {
                font-size: 2.5rem;
            }
            
            .characters-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .character-card {
                padding: 1.5rem;
            }
            
            .character-avatar {
                font-size: 4rem;
            }
        }
    </style>
</head>
<body>
    <!-- Partículas flotantes -->
    <div class="floating-particles" id="particles"></div>
    
    <!-- Overlay de carga -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner">⭐</div>
            <h3 style="margin-top: 1rem; font-size: 1.5rem;">Preparando tu aventura...</h3>
        </div>
    </div>

    <div class="container">
        <!-- Título épico -->
        <h1 class="epic-title">Elige tu Aventurero</h1>
        
        <!-- Texto de bienvenida -->
        <div class="welcome-text">
            <p>¡Bienvenido a <strong>LegendaryClass</strong>, {{ auth()->user()->name }}!</p>
            <p>Elige el aventurero que representará tu camino hacia el conocimiento.</p>
            <p>Cada personaje tiene habilidades únicas que te ayudarán en tu aprendizaje.</p>
        </div>

        <!-- Grid de personajes -->
        <div class="characters-grid">
            @foreach($characters as $type => $character)
                <div class="character-card" 
                     data-character="{{ $type }}"
                     style="--character-gradient: {{ $character['color'] }};">
                    <div class="character-content">
                        <!-- Avatar del personaje -->
                        <div class="character-avatar">
                            <div class="character-image-container" style="position: relative; display: inline-block;">
                                <!-- Escudo del personaje -->
                                <div class="character-shield" style="position: absolute; top: -10px; right: -10px; z-index: 2;">
                                    <img src="/images/escudos/escudo{{ $type }}.png" 
                                         alt="Escudo {{ $character['name'] }}" 
                                         style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));"
                                         onerror="this.style.display='none'">
                                </div>
                                <!-- Imagen principal del personaje -->
                                <img src="/images/characters/{{ $type }}_tier_1.png" 
                                     alt="{{ $character['name'] }}" 
                                     style="width: 140px; height: 140px; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));">
                            </div>
                        </div>

                        <!-- Nombre del personaje -->
                        <h3 class="character-name">{{ $character['name'] }}</h3>

                        <!-- Descripción -->
                        <p class="character-description">{{ $character['description'] }}</p>

                        <!-- Bonus especial -->
                        <div class="character-bonus">
                            <div class="bonus-text">🎯 {{ $character['bonus_description'] }}</div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="character-stats">
                            @foreach($character['stats'] as $stat)
                                <div class="stat-item">
                                    <span>{{ $stat }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón de selección -->
                        <button class="select-button" onclick="selectCharacter('{{ $type }}', this)">
                            Elegir {{ $character['name'] }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        let selectedCharacter = null;
        let isSelecting = false;

        // Crear partículas flotantes
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.width = (Math.random() * 4 + 2) + 'px';
                particle.style.height = particle.style.width;
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 4) + 's';
                container.appendChild(particle);
            }
        }

        // Seleccionar personaje
        function selectCharacter(characterType, button) {
            if (isSelecting) return;
            
            isSelecting = true;
            selectedCharacter = characterType;
            
            // Marcar tarjeta como seleccionada
            document.querySelectorAll('.character-card').forEach(card => {
                card.classList.remove('selected');
            });
            button.closest('.character-card').classList.add('selected');
            
            // Deshabilitar todos los botones
            document.querySelectorAll('.select-button').forEach(btn => {
                btn.disabled = true;
                btn.textContent = btn === button ? '✓ Seleccionado' : 'No disponible';
            });
            
            // Mostrar overlay de carga
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            // Enviar selección al servidor
            fetch('{{ route("students.character.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    character_type: characterType
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    showSuccessMessage(data.character);
                    
                    // Redirigir al dashboard después de 3 segundos
                    setTimeout(() => {
                        window.location.href = '{{ route("students.dashboard") }}';
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Error al seleccionar personaje');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al seleccionar personaje: ' + error.message);
                
                // Rehabilitar botones en caso de error
                isSelecting = false;
                document.querySelectorAll('.select-button').forEach(btn => {
                    btn.disabled = false;
                    btn.textContent = btn.textContent.replace('✓ Seleccionado', 'Elegir').replace('No disponible', 'Elegir');
                });
                document.getElementById('loadingOverlay').style.display = 'none';
            });
        }

        // Mostrar mensaje de éxito
        function showSuccessMessage(character) {
            const overlay = document.getElementById('loadingOverlay');
            const content = overlay.querySelector('.loading-content');
            
            content.innerHTML = `
                <div style="font-size: 4rem; margin-bottom: 1rem;">${character.icon}</div>
                <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #fbbf24;">¡Perfecto!</h2>
                <p style="font-size: 1.2rem; margin-bottom: 0.5rem;">Has elegido ser un <strong>${character.class}</strong></p>
                <p style="font-size: 1rem; opacity: 0.8;">Preparando tu aventura educativa...</p>
                <div style="margin-top: 2rem; font-size: 1rem; opacity: 0.6;">
                    Serás redirigido en unos segundos...
                </div>
            `;
        }

        // Efectos de entrada
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Animar entrada de las tarjetas
            const cards = document.querySelectorAll('.character-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Efectos de hover para las tarjetas
        document.querySelectorAll('.character-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                if (!isSelecting) {
                    this.style.zIndex = '10';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.zIndex = '1';
            });
        });
    </script>
</body>
</html>