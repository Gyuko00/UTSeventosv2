// assets/js/admin/event/ponentes_evento/editar_asignacion/form.js

export function initializeForm() {
    console.log('📋 Inicializando formulario de editar asignación');
    
    const form = document.getElementById('editarAsignacionForm');
    const btnLimpiar = document.getElementById('btnLimpiar');
    
    if (!form) {
        console.error('❌ No se encontró el formulario editarAsignacionForm');
        window.showMessage('Error de inicialización del formulario', 'error');
        return;
    }
    
    form.addEventListener('submit', handleFormSubmit);
    
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', handleRestore);
    }
    
    console.log('✅ Formulario inicializado correctamente');
}

async function handleFormSubmit(e) {
    e.preventDefault();
    console.log('📋 === ENVIANDO FORMULARIO DE EDICIÓN ===');
    
    if (!validateForm()) {
        console.log('❌ Validación fallida');
        return;
    }
    
    const formData = new FormData(e.target);
    
    if (!formData.has('speaker_event[certificado_generado]')) {
        formData.append('speaker_event[certificado_generado]', '0');
        console.log('📎 Certificado establecido como 0');
    }
    
    console.log('📊 === DATOS A ENVIAR ===');
    for (let [key, value] of formData.entries()) {
        console.log(`   ${key}: ${value}`);
    }
    console.log('==========================');
    
    const url = e.target.action;
    console.log('🌐 URL destino:', url);
    
    showLoading(true);
    
    try {
        console.log('📡 Enviando request...');
        
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });
        
        console.log('📬 Response recibida:');
        console.log('   Status:', response.status);
        console.log('   OK:', response.ok);
        console.log('   URL final:', response.url);
        
        if (!response.ok) {
            console.error('❌ Response no OK');
            throw new Error(`HTTP ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        console.log('📄 Content-Type:', contentType);
        
        if (contentType?.includes('application/json')) {
            console.log('✅ Respuesta es JSON, parseando...');
            
            const result = await response.json();
            console.log('📦 Resultado JSON:', result);
            
            if (result.status === 'success') {
                console.log('🎉 Éxito reportado por backend');
                window.showMessage('Asignación actualizada exitosamente', 'success');
                setTimeout(() => {
                    console.log('🔄 Redirigiendo...');
                    window.location.href = `${URL_PATH}/admin/listarPonentes`;
                }, 2000);
            } else {
                console.error('❌ Backend reportó error:', result.message);
                window.showMessage(result.message || 'Error al actualizar la asignación', 'error');
            }
        } else {
            console.log('⚠️ Respuesta NO es JSON, analizando contenido...');
            
            const text = await response.text();
            console.log('📄 Contenido (primeros 500 chars):', text.substring(0, 500));
            
            const successIndicators = ['success', 'exitoso', 'correctamente', 'actualizada', 'listar_ponentes'];
            const errorIndicators = ['error', 'failed', 'exception', 'warning', 'undefined', 'fatal'];
            
            let hasSuccess = false;
            let hasError = false;
            
            successIndicators.forEach(indicator => {
                if (text.toLowerCase().includes(indicator)) {
                    console.log(`✅ Indicador de éxito encontrado: "${indicator}"`);
                    hasSuccess = true;
                }
            });
            
            errorIndicators.forEach(indicator => {
                if (text.toLowerCase().includes(indicator)) {
                    console.log(`❌ Indicador de error encontrado: "${indicator}"`);
                    hasError = true;
                }
            });
            
            const urlChanged = response.url !== url;
            console.log('🔄 URL cambió:', urlChanged);
            if (urlChanged) {
                console.log('   URL original:', url);
                console.log('   URL final:', response.url);
            }
            
            if (response.url.includes('listar_ponentes') || hasSuccess) {
                console.log('🎉 Detectado éxito por URL o contenido');
                window.showMessage('Asignación actualizada exitosamente', 'success');
                setTimeout(() => {
                    window.location.href = `${URL_PATH}/admin/listarPonentes`;
                }, 2000);
            } else if (hasError) {
                console.error('❌ Detectado error en contenido');
                window.showMessage('Error al actualizar la asignación. Revisa la consola para más detalles.', 'error');
            } else {
                console.warn('⚠️ Respuesta ambigua');
                window.showMessage('Respuesta inesperada del servidor. Revisa la consola.', 'warning');
            }
        }
    } catch (err) {
        console.error('💥 ERROR EN FETCH:', err);
        console.error('Stack trace:', err.stack);
        window.showMessage('Error de conexión. Inténtalo de nuevo.', 'error');
    } finally {
        console.log('🏁 Finalizando request');
        showLoading(false);
    }
}

function handleRestore(e) {
    e.preventDefault();
    console.log('🔄 Restaurando valores originales');
    
    if (confirm('¿Estás seguro de que deseas restaurar los valores originales?\n\nSe perderán todos los cambios no guardados.')) {
        const data = window.ponenteEventoData;
        if (!data) {
            console.warn('⚠️ No hay datos originales para restaurar');
            window.showMessage('No se pueden restaurar los valores originales', 'warning');
            return;
        }
        
        restoreFormValues(data);
        window.showMessage('Valores restaurados exitosamente', 'success');
    }
}

function restoreFormValues(data) {
    console.log('🔧 Restaurando valores del formulario:', data);
    
    const horaField = document.getElementById('hora_participacion');
    if (horaField && data.hora_participacion) {
        horaField.value = data.hora_participacion.substring(0, 5);
        console.log('   Hora restaurada:', horaField.value);
    }
    
    const estadoField = document.getElementById('estado_asistencia');
    if (estadoField && data.estado_asistencia) {
        estadoField.value = data.estado_asistencia;
        console.log('   Estado restaurado:', estadoField.value);
    }
    
    const certificadoField = document.getElementById('certificado_generado');
    if (certificadoField) {
        certificadoField.checked = data.certificado_generado == 1;
        console.log('   Certificado restaurado:', certificadoField.checked);
    }
    
    const fechaField = document.getElementById('fecha_registro');
    if (fechaField && data.fecha_registro) {
        const fechaFormatted = new Date(data.fecha_registro).toISOString().slice(0, 16);
        fechaField.value = fechaFormatted;
        console.log('   Fecha restaurada:', fechaField.value);
    }
    
    const warnings = document.querySelectorAll('.bg-yellow-50');
    warnings.forEach(warning => warning.remove());
}

function validateForm() {
    console.log('🔍 === VALIDANDO FORMULARIO ===');
    
    const required = [
        { name: 'speaker_event[hora_participacion]', label: 'Hora de Participación' },
        { name: 'speaker_event[estado_asistencia]', label: 'Estado de Asistencia' },
        { name: 'speaker_event[fecha_registro]', label: 'Fecha de Registro' }
    ];
    
    for (const field of required) {
        const el = document.querySelector(`[name="${field.name}"]`);
        
        if (!el) {
            console.error(`❌ Campo no encontrado: ${field.name}`);
            window.showMessage(`Campo '${field.label}' no encontrado`, 'error');
            return false;
        }
        
        const value = el.value.trim();
        console.log(`   ${field.label}: "${value}"`);
        
        if (!value) {
            console.error(`❌ Campo vacío: ${field.name}`);
            window.showMessage(`El campo ${field.label} es requerido`, 'error');
            el.focus();
            return false;
        }
    }
    
    const hora = document.querySelector('[name="speaker_event[hora_participacion]"]');
    if (hora && hora.value) {
        const horaRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
        if (!horaRegex.test(hora.value)) {
            console.error(`❌ Formato de hora inválido: ${hora.value}`);
            window.showMessage('Hora inválida (HH:MM)', 'error');
            hora.focus();
            return false;
        }
        console.log(`✅ Hora válida: ${hora.value}`);
    }
    
    console.log('✅ Validación exitosa');
    return true;
}

function showLoading(show) {
    let overlay = document.getElementById('loadingOverlay');
    
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        overlay.innerHTML = `
            <div class="bg-white p-6 rounded-lg flex items-center gap-3 shadow-xl">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
                <span class="text-gray-700">Actualizando asignación...</span>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    overlay.style.display = show ? 'flex' : 'none';
}