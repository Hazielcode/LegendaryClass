<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegendaryClass - Portal de Aventureros</title>
    
    <!-- Fuentes épicas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Cinzel', serif;
        }
        .epic-background {
            background-image: url('/fondo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
        }
        .super-clear-overlay {
            background: rgba(255, 255, 255, 0.8);
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
        }
        .super-clear-title {
            font-weight: 900;
            font-size: clamp(3rem, 7vw, 5rem);
            background: linear-gradient(45deg, #b45309, #d97706, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 1rem;
        }
        .super-clear-subtitle {
            text-align: center;
            font-size: clamp(1.2rem, 3vw, 2rem);
            color: #374151;
            margin-bottom: 3rem;
        }
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
            padding: 2rem;
        }
        .welcome-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .super-clear-button {
            display: block;
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            font-weight: 700;
            border-radius: 10px;
            text-transform: uppercase;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .super-clear-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59,130,246,0.4);
        }
        .super-clear-footer {
            position: fixed;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            color: #6b7280;
            font-size: 0.75rem;
            background: rgba(255,255,255,0.8);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <div class="epic-background">
        <div class="super-clear-overlay"></div>
        
        <div class="relative z-10">
            <div class="text-center pt-8 pb-4">
                <h1 class="super-clear-title">LEGENDARYCLASS</h1>
                <p class="super-clear-subtitle">⚔️ Bienvenido al Portal de Aventureros ⚔️</p>
            </div>

            <div class="centered-container">
                <div class="welcome-panel">
                    <h2 class="text-2xl font-bold mb-6">¡Únete a la aventura!</h2>
                    
                    <a href="{{ route('login') }}" class="super-clear-button">
                        Iniciar Sesión
                    </a>

                    <a href="{{ route('register') }}" class="super-clear-button bg-green-600 hover:bg-green-700 mt-4">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>

        <div class="super-clear-footer">
            🏰 LegendaryClass v2.0 🏰
        </div>
    </div>
</body>
</html>
