@extends('layouts.app')

@push('styles')
<style>
.join-section {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    backdrop-filter: blur(20px);
    border: 3px solid rgba(245, 158, 11, 0.3);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 30px rgba(245, 158, 11, 0.1);
}

.code-input {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
    border: 3px solid rgba(245, 158, 11, 0.3);
    font-family: 'Courier New', monospace;
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    letter-spacing: 0.5rem;
    transition: all 0.3s ease;
}

.code-input:focus {
    border-color: rgba(245, 158, 11, 0.6);
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
    transform: scale(1.02);
}

.join-button {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
}

.join-button:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 35px rgba(245, 158, 11, 0.4);
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
}

.join-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.back-button {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.back-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(107, 114, 128, 0.3);
    color: white;
    text-decoration: none;
}

.title-epic {
    font-family: 'Cinzel', serif;
    color: #1f2937;
    text-shadow: 0 2px 4px rgba(255, 255, 255, 0.8);
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

.floating-key {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
    100% { transform: translateY(0px) rotate(0deg); }
}

.magic-glow {
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from { box-shadow: 0 0 20px rgba(245, 158, 11, 0.2); }
    to { box-shadow: 0 0 40px rgba(245, 158, 11, 0.4); }
}

.error-message {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

.success-message {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    border: 2px solid rgba(16, 185, 129, 0.3);
    color: #059669;
}
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="floating-key text-8xl mb-6">🗝️</div>
                <h1 class="text-5xl font-bold title-epic mb-4" style="font-family: 'Cinzel Decorative', serif;">
                    UNIRSE A AULA MÁGICA
                </h1>
                <p class="text-xl text-gray-600" style="font-family: 'Playfair Display', serif;">
                    Ingresa el código secreto para acceder al reino del conocimiento
                </p>
            </div>

            <!-- Formulario principal -->
            <div class="join-section rounded-3xl p-12 max-w-2xl mx-auto magic-glow">
                
                <!-- Mensajes de error -->
                @if($errors->any())
                    <div class="error-message rounded-xl p-4 mb-8">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">❌</span>
                            <div>
                                <h4 class="font-bold mb-2">Error al unirse al aula:</h4>
                                @foreach($errors->all() as $error)
                                    <p class="text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="success-message rounded-xl p-4 mb-8">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">✅</span>
                            <div>
                                <h4 class="font-bold mb-2">¡Éxito!</h4>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('students.process-join') }}" method="POST" id="joinForm">
                    @csrf
                    
                    <!-- Campo de código -->
                    <div class="mb-8">
                        <label for="code" class="block text-xl font-bold text-gray-700 mb-4 title-epic text-center">
                            🔮 CÓDIGO MÁGICO DE ACCESO
                        </label>
                        <input type="text" 
                               name="code" 
                               id="code"
                               class="code-input w-full py-6 px-6 rounded-2xl"
                               placeholder="ABC123"
                               maxlength="10"
                               required
                               autocomplete="off"
                               style="text-transform: uppercase;">
                        <p class="text-center text-sm text-gray-500 mt-3" style="font-family: 'Playfair Display', serif;">
                            Solicita el código a tu maestro para acceder al aula
                        </p>
                    </div>

                    <!-- Información del estudiante -->
                    <div class="bg-indigo-50 rounded-2xl p-6 mb-8 border-2 border-indigo-200">
                        <h3 class="text-lg font-bold text-indigo-800 mb-4 title-epic text-center">
                            👤 Tu Información de Aventurero
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl mb-2">{{ auth()->user()->character_icon ?? '⚔️' }}</div>
                                <div class="font-semibold text-indigo-700">{{ auth()->user()->character_class ?? 'Aventurero' }}</div>
                                <div class="text-sm text-indigo-500">Personaje</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-indigo-600 mb-2">{{ auth()->user()->level ?? 1 }}</div>
                                <div class="font-semibold text-indigo-700">Nivel</div>
                                <div class="text-sm text-indigo-500">Actual</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-indigo-600 mb-2">{{ auth()->user()->points ?? 0 }}</div>
                                <div class="font-semibold text-indigo-700">Puntos</div>
                                <div class="text-sm text-indigo-500">Disponibles</div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('students.dashboard') }}" 
                           class="back-button flex-1 text-center py-4 px-6 rounded-xl font-bold transition-all duration-300">
                            ↩️ Volver al Dashboard
                        </a>
                        <button type="submit" 
                                class="join-button flex-1 py-4 px-6 rounded-xl font-bold transition-all duration-300"
                                id="submitBtn">
                            🚪 UNIRSE AL REINO
                        </button>
                    </div>
                </form>

                <!-- Instrucciones -->
                <div class="mt-12 text-center">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 title-epic">
                        📜 Instrucciones para Aventureros
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                        <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-200">
                            <div class="text-2xl mb-2">🎯</div>
                            <h4 class="font-semibold mb-2">Paso 1: Obtén el Código</h4>
                            <p>Solicita a tu maestro el código secreto del aula a la que deseas unirte.</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                            <div class="text-2xl mb-2">⚡</div>
                            <h4 class="font-semibold mb-2">Paso 2: Acceso Instantáneo</h4>
                            <p>Una vez ingresado correctamente, tendrás acceso inmediato al aula y sus misiones.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('joinForm');

    // Auto-formatear código mientras se escribe
    codeInput.addEventListener('input', function(e) {
        // Convertir a mayúsculas y limitar caracteres
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        
        // Habilitar/deshabilitar botón según longitud
        if (this.value.length >= 3) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50');
        }
    });

    // Animación al enviar formulario
    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '🔄 CONECTANDO...';
        submitBtn.disabled = true;
        
        // Mostrar animación de carga
        setTimeout(() => {
            if (codeInput.value.length < 3) {
                e.preventDefault();
                submitBtn.innerHTML = '🚪 UNIRSE AL REINO';
                submitBtn.disabled = false;
                alert('Por favor ingresa un código válido de al menos 3 caracteres');
            }
        }, 100);
    });

    // Focus automático en el campo de código
    codeInput.focus();
    
    // Inicializar estado del botón
    submitBtn.disabled = true;
    submitBtn.classList.add('opacity-50');
});

// Efecto de partículas mágicas (opcional)
function createMagicParticle() {
    const particle = document.createElement('div');
    particle.style.cssText = `
        position: fixed;
        width: 4px;
        height: 4px;
        background: gold;
        border-radius: 50%;
        pointer-events: none;
        z-index: 1000;
        animation: sparkle 1s ease-out forwards;
    `;
    
    particle.style.left = Math.random() * window.innerWidth + 'px';
    particle.style.top = Math.random() * window.innerHeight + 'px';
    
    document.body.appendChild(particle);
    
    setTimeout(() => particle.remove(), 1000);
}

// Crear partículas cada 2 segundos
setInterval(createMagicParticle, 2000);

// CSS para animación de partículas
const style = document.createElement('style');
style.textContent = `
    @keyframes sparkle {
        0% { opacity: 1; transform: scale(0) rotate(0deg); }
        50% { opacity: 1; transform: scale(1) rotate(180deg); }
        100% { opacity: 0; transform: scale(0) rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@endpush