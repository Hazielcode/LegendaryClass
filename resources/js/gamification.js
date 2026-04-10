/**
 * Sistema de Gamificación - JavaScript
 * Funciones para mejorar la experiencia de usuario
 */

class GamificationSystem {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupTooltips();
        this.initializeProgressBars();
    }

    setupEventListeners() {
        // Botones de comportamiento
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('behavior-btn')) {
                this.handleBehaviorClick(e.target);
            }
        });

        // Formularios con previsualización
        document.addEventListener('input', (e) => {
            if (e.target.closest('.preview-form')) {
                this.updatePreview(e.target.closest('.preview-form'));
            }
        });

        // Confirmaciones mejoradas
        document.addEventListener('click', (e) => {
            if (e.target.hasAttribute('data-confirm')) {
                e.preventDefault();
                this.showConfirmDialog(e.target);
            }
        });
    }

    initializeAnimations() {
        // Observador para animaciones de entrada
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        });

        document.querySelectorAll('.student-card, .reward-card, .card-gamified').forEach(el => {
            observer.observe(el);
        });
    }

    setupTooltips() {
        // Tooltips simples para botones
        document.querySelectorAll('[data-tooltip]').forEach(el => {
            el.addEventListener('mouseenter', (e) => {
                this.showTooltip(e.target, e.target.dataset.tooltip);
            });
            
            el.addEventListener('mouseleave', () => {
                this.hideTooltip();
            });
        });
    }

    initializeProgressBars() {
        document.querySelectorAll('.progress-bar-animated').forEach(bar => {
            const width = bar.dataset.width || '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
    }

    handleBehaviorClick(button) {
        // Efecto visual inmediato
        button.classList.add('scale-125');
        setTimeout(() => {
            button.classList.remove('scale-125');
        }, 150);

        // Efecto de partículas (simple)
        this.createParticleEffect(button);
    }

    createParticleEffect(element) {
        const rect = element.getBoundingClientRect();
        const particle = document.createElement('div');
        
        particle.style.cssText = `
            position: fixed;
            left: ${rect.left + rect.width/2}px;
            top: ${rect.top + rect.height/2}px;
            width: 4px;
            height: 4px;
            background: ${element.classList.contains('positive') ? '#10B981' : '#EF4444'};
            border-radius: 50%;
            pointer-events: none;
            z-index: 1000;
            animation: particle-float 1s ease-out forwards;
        `;

        document.body.appendChild(particle);
        
        setTimeout(() => {
            particle.remove();
        }, 1000);
    }

    updatePreview(form) {
        const previewElement = form.querySelector('.preview-container');
        if (!previewElement) return;

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Actualizar vista previa según el tipo de formulario
        if (form.classList.contains('behavior-form')) {
            this.updateBehaviorPreview(previewElement, data);
        } else if (form.classList.contains('reward-form')) {
            this.updateRewardPreview(previewElement, data);
        }
    }

    updateBehaviorPreview(preview, data) {
        const nameEl = preview.querySelector('.preview-name');
        const descEl = preview.querySelector('.preview-description');
        const badgeEl = preview.querySelector('.preview-badge');
        const categoryEl = preview.querySelector('.preview-category');

        if (nameEl) nameEl.textContent = data.name || 'Nombre del comportamiento';
        if (descEl) descEl.textContent = data.description || 'Descripción del comportamiento';
        if (categoryEl) categoryEl.textContent = data.category || 'Categoría';
        
        if (badgeEl) {
            const points = data.points || '5';
            const type = data.type || 'positive';
            
            badgeEl.textContent = (parseInt(points) > 0 && type === 'positive' ? '+' : '') + points;
            badgeEl.className = `preview-badge w-10 h-10 rounded-full flex items-center justify-center font-bold ${
                type === 'positive' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'
            }`;
        }
    }

    updateRewardPreview(preview, data) {
        const nameEl = preview.querySelector('.preview-name');
        const descEl = preview.querySelector('.preview-description');
        const costEl = preview.querySelector('.preview-cost');
        const typeEl = preview.querySelector('.preview-type');

        if (nameEl) nameEl.textContent = data.name || 'Nombre de la recompensa';
        if (descEl) descEl.textContent = data.description || 'Descripción de la recompensa';
        if (costEl) costEl.textContent = (data.cost_points || '50') + ' puntos';
        if (typeEl) typeEl.textContent = data.type || 'privilege';
    }

    showTooltip(element, text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip-popup';
        tooltip.textContent = text;
        tooltip.style.cssText = `
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        `;

        document.body.appendChild(tooltip);

        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';

        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);

        this.currentTooltip = tooltip;
    }

    hideTooltip() {
        if (this.currentTooltip) {
            this.currentTooltip.remove();
            this.currentTooltip = null;
        }
    }

    showConfirmDialog(element) {
        const message = element.dataset.confirm;
        const isDestructive = element.classList.contains('btn-danger') || 
                            element.classList.contains('text-red-600');

        // Crear modal de confirmación personalizado
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md mx-4 transform scale-95 transition-transform duration-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full ${isDestructive ? 'bg-red-100' : 'bg-blue-100'} flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 ${isDestructive ? 'text-red-600' : 'text-blue-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${isDestructive ? 
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            }
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Confirmar acción</h3>
                </div>
                <p class="text-gray-600 mb-6">${message}</p>
                <div class="flex justify-end space-x-3">
                    <button class="cancel-btn px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                        Cancelar
                    </button>
                    <button class="confirm-btn px-4 py-2 ${isDestructive ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700'} text-white rounded-md transition-colors">
                        Confirmar
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Animar entrada
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);

        // Event listeners
        modal.querySelector('.cancel-btn').addEventListener('click', () => {
            this.closeModal(modal);
        });

        modal.querySelector('.confirm-btn').addEventListener('click', () => {
            this.closeModal(modal);
            // Ejecutar la acción original
            if (element.href) {
                window.location.href = element.href;
            } else if (element.type === 'submit') {
                element.form.submit();
            } else {
                element.click();
            }
        });

        // Cerrar con ESC o clic fuera
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeModal(modal);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal(modal);
            }
        });
    }

    closeModal(modal) {
        modal.querySelector('div').classList.add('scale-95');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.remove();
        }, 200);
    }

    // Función para mostrar notificaciones toast
    showToast(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = this.getToastIcon(type);
        toast.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${icon}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="close-toast inline-flex text-white hover:text-gray-200 focus:outline-none">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(toast);

        // Event listener para cerrar
        toast.querySelector('.close-toast').addEventListener('click', () => {
            this.closeToast(toast);
        });

        // Auto cerrar
        setTimeout(() => {
            this.closeToast(toast);
        }, duration);
    }

    getToastIcon(type) {
        const icons = {
            success: '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>',
            error: '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>',
            info: '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>'
        };
        return icons[type] || icons.info;
    }

    closeToast(toast) {
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    // Función para animar contadores
    animateCounter(element, finalValue, duration = 1000) {
        const startValue = 0;
        const increment = finalValue / (duration / 16);
        let currentValue = startValue;

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            element.textContent = Math.floor(currentValue);
        }, 16);
    }

    // Función para efectos de logros
    triggerAchievementEffect(achievementName) {
        const achievementModal = document.createElement('div');
        achievementModal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
        achievementModal.innerHTML = `
            <div class="bg-white rounded-lg p-8 text-center max-w-md mx-4 achievement-effect">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl">
                    🏆
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Logro Desbloqueado!</h2>
                <p class="text-lg text-gray-700 mb-4">${achievementName}</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition-colors">
                    ¡Genial!
                </button>
            </div>
        `;

        document.body.appendChild(achievementModal);

        // Efecto de sonido (si está disponible)
        this.playAchievementSound();

        // Cerrar modal
        achievementModal.querySelector('button').addEventListener('click', () => {
            achievementModal.remove();
        });

        // Auto cerrar después de 5 segundos
        setTimeout(() => {
            if (achievementModal.parentNode) {
                achievementModal.remove();
            }
        }, 5000);
    }

    playAchievementSound() {
        // Reproducir sonido de logro si está disponible
        try {
            const audio = new Audio('/sounds/achievement.mp3');
            audio.volume = 0.3;
            audio.play().catch(() => {
                // Ignore si no se puede reproducir
            });
        } catch (e) {
            // Ignore si no hay archivo de sonido
        }
    }

    // Función para formatear números grandes
    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }

    // Función para lazy loading de imágenes
    setupLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('opacity-0');
                    img.classList.add('opacity-100');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Función para debounce (útil para búsquedas)
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Funciones globales para uso en templates
window.GamificationSystem = GamificationSystem;

// Instanciar el sistema cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.gamification = new GamificationSystem();
});

// Funciones de utilidad globales
window.showToast = (message, type, duration) => {
    if (window.gamification) {
        window.gamification.showToast(message, type, duration);
    }
};

window.showAchievement = (name) => {
    if (window.gamification) {
        window.gamification.triggerAchievementEffect(name);
    }
};

// Agregar estilos CSS para las animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes particle-float {
        0% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        100% {
            transform: translateY(-30px) scale(0);
            opacity: 0;
        }
    }
    
    .tooltip-popup {
        animation: tooltip-fade-in 0.2s ease-out;
    }
    
    @keyframes tooltip-fade-in {
        from {
            opacity: 0;
            transform: translateY(5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);