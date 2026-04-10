// UBICACIÓN: resources/js/app.js 
// ACCIÓN: REEMPLAZAR COMPLETO

import './bootstrap';
import './gamification';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Funciones globales para uso en las vistas Blade
window.awardBehavior = function(studentId, behaviorId, classroomId = null) {
    const url = '/student-behaviors';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Obtener classroom_id si no se proporciona
    if (!classroomId) {
        const classroomElement = document.querySelector('[data-classroom-id]');
        classroomId = classroomElement ? classroomElement.dataset.classroomId : null;
    }
    
    if (!classroomId) {
        window.showToast('Error: No se pudo determinar el aula', 'error');
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            student_id: studentId,
            behavior_id: behaviorId,
            classroom_id: classroomId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Comportamiento otorgado exitosamente', 'success');
            
            // Actualizar la UI sin recargar
            updateStudentPoints(studentId, data.data.points_awarded);
            
            // Efecto visual de partículas
            const button = document.querySelector(`[onclick*="${studentId}"][onclick*="${behaviorId}"]`);
            if (button && window.gamification) {
                window.gamification.createParticleEffect(button);
            }
            
            // Recargar después de un delay para mostrar cambios
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast(data.message || 'Error al otorgar comportamiento', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.redeemReward = function(rewardId, classroomId = null) {
    const url = '/redeem-reward';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Obtener classroom_id si no se proporciona
    if (!classroomId) {
        const classroomElement = document.querySelector('[data-classroom-id]');
        classroomId = classroomElement ? classroomElement.dataset.classroomId : null;
    }

    if (!confirm('¿Estás seguro de que quieres canjear esta recompensa?')) {
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            reward_id: rewardId,
            classroom_id: classroomId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('¡Recompensa canjeada exitosamente!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            window.showToast(data.message || 'Error al canjear recompensa', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.updateRewardStatus = function(studentRewardId, status) {
    const url = `/student-rewards/${studentRewardId}/update-status`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const statusText = {
        'approved': 'aprobar',
        'cancelled': 'rechazar',
        'delivered': 'marcar como entregado'
    };

    if (!confirm(`¿Estás seguro de que quieres ${statusText[status]} esta solicitud?`)) {
        return;
    }

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Estado actualizado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast(data.message || 'Error al actualizar el estado', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.toggleRewardStatus = function(rewardId) {
    const url = `/rewards/${rewardId}/toggle-status`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Estado de la recompensa actualizado', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast('Error al cambiar el estado', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.approveAllPending = function(rewardId) {
    const url = `/rewards/${rewardId}/approve-all-pending`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!confirm('¿Estás seguro de aprobar todas las solicitudes pendientes?')) {
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast('Error al aprobar las solicitudes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.regenerateClassroomCode = function(classroomId) {
    const url = `/classrooms/${classroomId}/regenerate-code`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!confirm('¿Estás seguro? El código anterior dejará de funcionar.')) {
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Código regenerado exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast('Error al regenerar el código', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

window.removeStudent = function(classroomId, studentId) {
    const url = `/classrooms/${classroomId}/remove-student`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!confirm('¿Estás seguro de que quieres remover este estudiante del aula?')) {
        return;
    }

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ student_id: studentId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Estudiante removido exitosamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            window.showToast(data.message || 'Error al remover estudiante', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('Error de conexión', 'error');
    });
};

// Función auxiliar para actualizar puntos en la UI
function updateStudentPoints(studentId, pointsAwarded) {
    const studentCard = document.querySelector(`[data-student-id="${studentId}"]`);
    if (!studentCard) return;

    const pointsElement = studentCard.querySelector('.student-points');
    if (pointsElement) {
        const currentPoints = parseInt(pointsElement.textContent) || 0;
        const newPoints = currentPoints + pointsAwarded;
        pointsElement.textContent = newPoints;

        // Animar el cambio
        pointsElement.classList.add('animate-pulse');
        setTimeout(() => {
            pointsElement.classList.remove('animate-pulse');
        }, 1000);
    }

    // Actualizar barra de progreso si existe
    const progressBar = studentCard.querySelector('.progress-fill');
    if (progressBar) {
        // Calcular nuevo progreso (esto es una aproximación)
        const currentWidth = parseInt(progressBar.style.width) || 0;
        const increment = Math.min(pointsAwarded, 10); // Máximo 10% de incremento por acción
        const newWidth = Math.min(currentWidth + increment, 100);
        progressBar.style.width = newWidth + '%';
    }
}

// Funciones para formularios con previsualización
window.updatePreview = function() {
    if (window.gamification) {
        const form = document.querySelector('.preview-form');
        if (form) {
            window.gamification.updatePreview(form);
        }
    }
};

// Auto-uppercase para códigos de aula
document.addEventListener('input', function(e) {
    if (e.target.name === 'class_code' || e.target.id === 'class_code') {
        e.target.value = e.target.value.toUpperCase();
    }
});

// Confirmar acciones destructivas
document.addEventListener('click', function(e) {
    if (e.target.hasAttribute('data-confirm')) {
        e.preventDefault();
        if (window.gamification) {
            window.gamification.showConfirmDialog(e.target);
        } else {
            // Fallback a confirm nativo
            if (confirm(e.target.dataset.confirm)) {
                if (e.target.href) {
                    window.location.href = e.target.href;
                } else if (e.target.form) {
                    e.target.form.submit();
                }
            }
        }
    }
});

// Inicialización de contadores animados
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-counter]');
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.counter);
        if (window.gamification && target > 0) {
            window.gamification.animateCounter(counter, target);
        }
    });

    // Configurar lazy loading
    if (window.gamification) {
        window.gamification.setupLazyLoading();
    }
});

// Manejo de errores AJAX globales
window.addEventListener('unhandledrejection', function(event) {
    console.error('Error no manejado:', event.reason);
    window.showToast('Se produjo un error inesperado', 'error');
});

// Función para copiar código al portapapeles
window.copyToClipboard = function(text) {
    navigator.clipboard.writeText(text).then(function() {
        window.showToast('Código copiado al portapapeles', 'success');
    }).catch(function() {
        // Fallback para navegadores más antiguos
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        window.showToast('Código copiado al portapapeles', 'success');
    });
};

// ===============================================
// NUEVAS FUNCIONES PARA ALPINE.JS Y LEGENDARYCLASS
// ===============================================

// Configuraciones adicionales para LegendaryClass
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎮 LegendaryClass cargado correctamente');
    
    // Asegurar que los dropdowns funcionen correctamente
    setTimeout(() => {
        document.querySelectorAll('[x-data]').forEach(element => {
            if (!element._x_dataStack && window.Alpine) {
                try {
                    window.Alpine.initTree(element);
                    console.log('✅ Elemento Alpine inicializado:', element);
                } catch (error) {
                    console.warn('⚠️ Error al inicializar Alpine en elemento:', element, error);
                }
            }
        });
    }, 500);
    
    // Inicializar dropdowns manualmente si Alpine no los detecta
    const dropdowns = document.querySelectorAll('[x-data*="open"]');
    dropdowns.forEach(dropdown => {
        if (!dropdown._x_dataStack) {
            console.log('🔧 Inicializando dropdown manualmente');
            if (window.Alpine) {
                try {
                    window.Alpine.initTree(dropdown);
                } catch (error) {
                    console.warn('⚠️ Error al inicializar dropdown:', error);
                    // Usar fallback manual
                    initManualDropdown(dropdown);
                }
            } else {
                // Usar fallback manual
                initManualDropdown(dropdown);
            }
        }
    });
});

// Funciones globales adicionales para LegendaryClass
window.LegendaryClass = window.LegendaryClass || {};

// Extender LegendaryClass con nuevas funciones
Object.assign(window.LegendaryClass, {
    // Función para mostrar notificaciones épicas
    showNotification: function(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white font-bold shadow-lg`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="text-2xl mr-2">${type === 'success' ? '🎉' : '⚠️'}</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 100);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    },
    
    // Función para confirmar acciones
    confirm: function(message, callback) {
        if (confirm(`🤔 ${message}`)) {
            callback();
        }
    },
    
    // Debug de Alpine.js
    debugAlpine: function() {
        console.log('=== 🔍 DEBUG ALPINE.JS ===');
        console.log('Alpine.js disponible:', !!window.Alpine);
        console.log('Alpine.js versión:', window.Alpine?.version || 'No disponible');
        console.log('Elementos con x-data:', document.querySelectorAll('[x-data]').length);
        
        document.querySelectorAll('[x-data]').forEach((el, index) => {
            console.log(`Elemento ${index}:`, {
                hasDataStack: !!el._x_dataStack,
                xData: el.getAttribute('x-data'),
                element: el
            });
        });
        console.log('=== 🔍 FIN DEBUG ===');
    }
});

// Inicialización manual de dropdown (fallback)
function initManualDropdown(element) {
    console.log('🔧 Inicializando dropdown manual para:', element);
    
    const button = element.querySelector('[\\@click]') || element.querySelector('button');
    const menu = element.querySelector('.dropdown-menu');
    
    if (!button || !menu) {
        console.warn('⚠️ No se encontraron elementos button/menu para dropdown manual');
        return;
    }
    
    let isOpen = false;
    
    function toggle() {
        isOpen = !isOpen;
        console.log('🔄 Dropdown manual toggle:', isOpen);
        
        if (isOpen) {
            menu.style.display = 'block';
            menu.style.opacity = '0';
            menu.style.visibility = 'visible';
            menu.style.transform = 'translateY(-10px)';
            
            // Forzar reflow
            menu.offsetHeight;
            
            // Animar entrada
            setTimeout(() => {
                menu.style.opacity = '1';
                menu.style.transform = 'translateY(0)';
            }, 10);
            
            // Rotar flecha si existe
            const arrow = button.querySelector('svg');
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
                arrow.style.transition = 'transform 0.2s';
            }
        } else {
            menu.style.opacity = '0';
            menu.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                menu.style.display = 'none';
                menu.style.visibility = 'hidden';
            }, 200);
            
            // Rotar flecha si existe
            const arrow = button.querySelector('svg');
            if (arrow) {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    }
    
    // Event listeners
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggle();
    });
    
    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!element.contains(e.target) && isOpen) {
            isOpen = true; // Para que toggle() lo cierre
            toggle();
        }
    });
    
    // Cerrar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) {
            isOpen = true; // Para que toggle() lo cierre
            toggle();
        }
    });
    
    console.log('✅ Dropdown manual configurado');
}

// Forzar inicialización de Alpine.js en elementos problemáticos
function forceAlpineInit() {
    if (!window.Alpine) {
        console.warn('⚠️ Alpine.js no está disponible para forzar inicialización');
        return;
    }
    
    // Buscar elementos con x-data que no estén inicializados
    const unInitialized = document.querySelectorAll('[x-data]:not([x-data=""])');
    let fixed = 0;
    
    unInitialized.forEach(element => {
        if (!element._x_dataStack) {
            try {
                window.Alpine.initTree(element);
                fixed++;
                console.log('✅ Elemento Alpine inicializado manualmente:', element);
            } catch (error) {
                console.error('❌ Error al inicializar elemento Alpine:', error, element);
                // Si Alpine falla, usar fallback manual para dropdowns
                if (element.querySelector('.dropdown-menu')) {
                    initManualDropdown(element);
                }
            }
        }
    });
    
    if (fixed > 0) {
        console.log(`✅ Se inicializaron ${fixed} elementos Alpine.js manualmente`);
    }
}

// Ejecutar después de que Alpine esté listo
document.addEventListener('alpine:init', () => {
    console.log('🎉 Alpine.js inicializado correctamente');
    setTimeout(forceAlpineInit, 100);
});

// Fallback si alpine:init no se dispara
setTimeout(() => {
    if (window.Alpine) {
        console.log('🔄 Forzando inicialización tardía de Alpine.js...');
        forceAlpineInit();
    } else {
        console.warn('⚠️ Alpine.js no disponible después de timeout, usando fallbacks manuales');
        // Inicializar todos los dropdowns manualmente
        document.querySelectorAll('[x-data*="open"]').forEach(initManualDropdown);
    }
}, 2000);

// Debugging para desarrollo
if (typeof process !== 'undefined' && process.env.NODE_ENV === 'development') {
    // Solo en desarrollo, agregar debugging
    window.debugLegendary = function() {
        console.log('=== 🔍 DEBUG LEGENDARYCLASS ===');
        window.LegendaryClass.debugAlpine();
        console.log('Funciones globales disponibles:', Object.keys(window).filter(key => 
            typeof window[key] === 'function' && (
                key.includes('award') || 
                key.includes('redeem') || 
                key.includes('update') ||
                key.includes('LegendaryClass')
            )
        ));
        console.log('=== 🔍 FIN DEBUG ===');
    };
} else {
    // Para producción, versión simplificada
    window.debugLegendary = function() {
        console.log('🎮 LegendaryClass funcionando correctamente');
        console.log('Alpine.js:', !!window.Alpine ? '✅' : '❌');
        console.log('Dropdowns:', document.querySelectorAll('[x-data*="open"]').length);
    };
}

// Función específica para debug del dropdown
window.debugDropdown = function() {
    console.log('=== 🔍 DEBUG DROPDOWN ===');
    console.log('Alpine disponible:', !!window.Alpine);
    console.log('Botón dropdown:', document.querySelector('.dropdown-button'));
    console.log('Menu dropdown:', document.querySelector('.dropdown-menu'));
    console.log('Elementos x-data:', document.querySelectorAll('[x-data]').length);
    
    const nav = document.querySelector('nav[x-data]');
    if (nav) {
        console.log('Nav x-data:', nav.getAttribute('x-data'));
        console.log('Nav tiene _x_dataStack:', !!nav._x_dataStack);
        console.log('Nav style display:', getComputedStyle(nav).display);
    }
    
    const menu = document.querySelector('.dropdown-menu');
    if (menu) {
        console.log('Menu visibility:', getComputedStyle(menu).visibility);
        console.log('Menu opacity:', getComputedStyle(menu).opacity);
        console.log('Menu display:', getComputedStyle(menu).display);
    }
    
    console.log('=== 🔍 FIN DEBUG ===');
};

// Asegurar que Alpine funcione después de navegación AJAX
document.addEventListener('turbo:load', forceAlpineInit);
document.addEventListener('livewire:load', forceAlpineInit);

console.log('🎮 LegendaryClass app.js cargado completamente');