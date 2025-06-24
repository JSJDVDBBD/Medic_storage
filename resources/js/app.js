// resources/js/app.js
import './bootstrap';
import 'flowbite';

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar tooltips de Flowbite
    if (window.tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tooltip-target]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new window.tooltip(tooltipTriggerEl);
        });
    }
    
    // Cerrar alertas automáticamente después de 5 segundos
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert-auto-dismiss');
        alerts.forEach(alert => {
            alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});