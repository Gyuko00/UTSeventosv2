// assets/js/admin/event/ponentes_evento/editar_asignacion/main.js

import { initializeForm } from './form.js';
import { initializeValidation } from './validacion.js';

document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Inicializando editar asignación ponente');
    console.log('📊 Datos del ponente evento:', window.ponenteEventoData);
    console.log('🆔 ID:', PONENTE_EVENTO_ID);
    
    initializeForm();
    initializeValidation();
    
    initializeFormValues();
});

function initializeFormValues() {
    console.log('🔧 Inicializando valores del formulario');
    
    const data = window.ponenteEventoData;
    if (!data) {
        console.warn('⚠️ No hay datos del ponente evento');
        return;
    }
    
    validateTimeRange();
}

function validateTimeRange() {
    const horaParticipacion = document.getElementById('hora_participacion');
    if (!horaParticipacion || !horaParticipacion.value) return;
    
    const data = window.ponenteEventoData;
    if (!data.hora_inicio || !data.hora_fin) return;
    
    const horaEvento = {
        inicio: data.hora_inicio.substring(0, 5), 
        fin: data.hora_fin.substring(0, 5)
    };
    
    const horaSeleccionada = horaParticipacion.value;
    
    if (horaSeleccionada < horaEvento.inicio || horaSeleccionada > horaEvento.fin) {
        console.warn('⚠️ Hora de participación fuera del rango del evento');
        showTimeWarning(horaEvento);
    }
}

function showTimeWarning(horaEvento) {
    const warning = document.createElement('div');
    warning.className = 'mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg';
    warning.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm text-yellow-800">
                <strong>Advertencia:</strong> La hora seleccionada está fuera del horario del evento 
                (${horaEvento.inicio} - ${horaEvento.fin})
            </span>
        </div>
    `;
    
    const horaField = document.getElementById('hora_participacion');
    const existingWarning = horaField.parentNode.querySelector('.bg-yellow-50');
    if (existingWarning) {
        existingWarning.remove();
    }
    
    horaField.parentNode.appendChild(warning);
}

document.addEventListener('change', (e) => {
    if (e.target.id === 'hora_participacion') {
        validateTimeRange();
    }
});

// Función para mostrar mensajes globales
window.showMessage = function(message, type = 'info') {
    let container = document.getElementById('messageContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'messageContainer';
        container.className = 'fixed top-4 right-4 z-50';
        document.body.appendChild(container);
    }
    
    const div = document.createElement('div');
    const styles = {
        success: 'bg-green-50 border-green-200 text-green-700',
        error: 'bg-red-50 border-red-200 text-red-700',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-700',
        info: 'bg-blue-50 border-blue-200 text-blue-700',
    };
    
    div.className = `${styles[type]} border px-4 py-3 rounded-lg shadow-lg mb-2 max-w-md transition-all duration-300`;
    div.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(div);
    setTimeout(() => {
        if (div.parentNode) {
            div.remove();
        }
    }, 5000);
};

window.formatTime = function(timeString) {
    if (!timeString) return '';
    
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const period = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour > 12 ? hour - 12 : hour === 0 ? 12 : hour;
    
    return `${displayHour}:${minutes} ${period}`;
};

window.debugFormState = function() {
    console.log('🐛 === DEBUG ESTADO DEL FORMULARIO ===');
    console.log('📊 Datos originales:', window.ponenteEventoData);
    
    const form = document.getElementById('editarAsignacionForm');
    if (form) {
        const formData = new FormData(form);
        console.log('📋 Datos actuales del formulario:');
        for (let [key, value] of formData.entries()) {
            console.log(`   ${key}: ${value}`);
        }
    }
    
    const horaField = document.getElementById('hora_participacion');
    if (horaField) {
        console.log('⏰ Hora actual:', horaField.value);
        validateTimeRange();
    }
    
    console.log('================================');
};

window.editorAsignacion = {
    validateTimeRange,
    showTimeWarning,
    debugFormState: window.debugFormState,
    showMessage: window.showMessage,
    formatTime: window.formatTime
};