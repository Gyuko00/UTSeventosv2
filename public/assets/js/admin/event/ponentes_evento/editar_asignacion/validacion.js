// assets/js/admin/event/ponentes_evento/editar_asignacion/validaciones.js

export function initializeValidation() {
    console.log('🔍 Inicializando validaciones en tiempo real');
    
    setupTimeValidation();
    
    setupStateValidation();
    
    setupFormValidation();
}

function setupTimeValidation() {
    const horaField = document.getElementById('hora_participacion');
    if (!horaField) return;
    
    horaField.addEventListener('input', (e) => {
        validateParticipationTime(e.target.value);
    });
    
    horaField.addEventListener('blur', (e) => {
        validateParticipationTime(e.target.value);
    });
}

function validateParticipationTime(timeValue) {
    if (!timeValue) return;
    
    const data = window.ponenteEventoData;
    if (!data || !data.hora_inicio || !data.hora_fin) return;
    
    const eventStart = data.hora_inicio.substring(0, 5); 
    const eventEnd = data.hora_fin.substring(0, 5);
    
    clearTimeWarnings();
    
    if (timeValue < eventStart || timeValue > eventEnd) {
        showTimeWarning(eventStart, eventEnd, timeValue);
        return false;
    }
    
    showTimeSuccess();
    return true;
}

function showTimeWarning(eventStart, eventEnd, selectedTime) {
    const horaField = document.getElementById('hora_participacion');
    const container = horaField.closest('.space-y-3');
    
    const warning = document.createElement('div');
    warning.className = 'time-validation mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg';
    warning.innerHTML = `
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm">
                <p class="text-yellow-800 font-medium">Hora fuera del rango del evento</p>
                <p class="text-yellow-700 mt-1">
                    El evento es de <strong>${formatTime(eventStart)}</strong> a <strong>${formatTime(eventEnd)}</strong><br>
                    Has seleccionado: <strong>${formatTime(selectedTime)}</strong>
                </p>
                <p class="text-yellow-600 text-xs mt-1">
                    Puedes continuar, pero considera ajustar la hora dentro del rango del evento.
                </p>
            </div>
        </div>
    `;
    
    container.appendChild(warning);
}

function showTimeSuccess() {
    const horaField = document.getElementById('hora_participacion');
    const container = horaField.closest('.space-y-3');
    
    const success = document.createElement('div');
    success.className = 'time-validation mt-2 p-2 bg-green-50 border border-green-200 rounded-lg';
    success.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm text-green-800 font-medium">Hora dentro del rango del evento</span>
        </div>
    `;
    
    container.appendChild(success);
    
    setTimeout(() => {
        if (success.parentNode) {
            success.remove();
        }
    }, 2000);
}

function clearTimeWarnings() {
    const warnings = document.querySelectorAll('.time-validation');
    warnings.forEach(warning => warning.remove());
}

function setupStateValidation() {
    const estadoField = document.getElementById('estado_asistencia');
    const certificadoField = document.getElementById('certificado_generado');
    
    if (!estadoField || !certificadoField) return;
    
    estadoField.addEventListener('change', () => {
        validateStateAndCertificate();
    });
    
    certificadoField.addEventListener('change', () => {
        validateStateAndCertificate();
    });
}

function validateStateAndCertificate() {
    const estadoField = document.getElementById('estado_asistencia');
    const certificadoField = document.getElementById('certificado_generado');
    
    if (!estadoField || !certificadoField) return;
    
    const estado = estadoField.value;
    const certificadoChecked = certificadoField.checked;
    
    clearStateWarnings();
    
    if (certificadoChecked && estado !== 'confirmado') {
        showStateWarning(
            'Certificado marcado con estado no confirmado',
            'Generalmente los certificados se generan solo para ponentes confirmados.',
            'warning'
        );
    }
    
    if (estado === 'confirmado' && !certificadoChecked) {
        showStateInfo(
            'Ponente confirmado',
            'Considera generar el certificado de participación.',
            'info'
        );
    }
    
    if ((estado === 'cancelado' || estado === 'ausente') && certificadoChecked) {
        showStateWarning(
            'Certificado marcado para ponente no presente',
            `El estado es "${estado}" pero el certificado está marcado como generado.`,
            'error'
        );
    }
}

function showStateWarning(title, message, type) {
    const estadoField = document.getElementById('estado_asistencia');
    const container = estadoField.closest('.space-y-3').parentNode;
    
    const typeConfig = {
        warning: {
            bg: 'bg-yellow-50',
            border: 'border-yellow-200',
            text: 'text-yellow-800',
            icon: 'text-yellow-600',
            iconPath: 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z'
        },
        error: {
            bg: 'bg-red-50',
            border: 'border-red-200',
            text: 'text-red-800',
            icon: 'text-red-600',
            iconPath: 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'
        },
        info: {
            bg: 'bg-blue-50',
            border: 'border-blue-200',
            text: 'text-blue-800',
            icon: 'text-blue-600',
            iconPath: 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z'
        }
    };
    
    const config = typeConfig[type] || typeConfig.info;
    
    const warning = document.createElement('div');
    warning.className = `state-validation mt-4 p-3 ${config.bg} ${config.border} border rounded-lg`;
    warning.innerHTML = `
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 ${config.icon} mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="${config.iconPath}" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm">
                <p class="${config.text} font-medium">${title}</p>
                <p class="${config.text} mt-1">${message}</p>
            </div>
        </div>
    `;
    
    container.appendChild(warning);
}

function showStateInfo(title, message, type) {
    showStateWarning(title, message, type);
}

function clearStateWarnings() {
    const warnings = document.querySelectorAll('.state-validation');
    warnings.forEach(warning => warning.remove());
}

function setupFormValidation() {
    const form = document.getElementById('editarAsignacionForm');
    if (!form) return;
    
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', () => {
            validateRequiredField(field);
        });
        
        field.addEventListener('input', () => {
            clearFieldError(field);
        });
    });
}

function validateRequiredField(field) {
    if (!field.value.trim()) {
        showFieldError(field, 'Este campo es requerido');
        return false;
    }
    
    clearFieldError(field);
    return true;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    const error = document.createElement('div');
    error.className = 'field-error mt-1 text-sm text-red-600';
    error.textContent = message;
    
    field.parentNode.appendChild(error);
    field.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
}

function clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    field.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
}

function formatTime(timeString) {
    if (!timeString) return '';
    
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const period = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour > 12 ? hour - 12 : hour === 0 ? 12 : hour;
    
    return `${displayHour}:${minutes} ${period}`;
}