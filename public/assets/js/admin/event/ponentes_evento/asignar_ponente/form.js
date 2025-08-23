// form.js
import { showMessage, showLoading } from './services.js';

export function initializeForm() {
  const form = document.getElementById("asignarPonenteForm");
  const btnLimpiar = document.getElementById("btnLimpiar");

  if (!form) {
    showMessage("Error de inicialización del formulario", "error");
    return;
  }

  form.addEventListener("submit", handleFormSubmit);

  if (btnLimpiar) {
    btnLimpiar.addEventListener("click", e => {
      e.preventDefault();
      if (confirm("¿Seguro que deseas limpiar el formulario?")) {
        form.reset();
        setCurrentDateTime();
        if (window.ponenteTimelineManager) {
          window.ponenteTimelineManager.selectedSlots = [];
          window.ponenteTimelineManager.hideTimeline();
        }
      }
    });
  }
}

export function setCurrentDateTime() {
  const fechaRegistro = document.querySelector('input[name="speaker_event[fecha_registro]"]');
  if (fechaRegistro) {
    fechaRegistro.value = new Date().toISOString().slice(0, 16);
  }
}

async function handleFormSubmit(e) {
  e.preventDefault();
  
  if (!validateForm()) {
    return;
  }

  const formData = new FormData(e.target);
  
  if (!formData.has('speaker_event[certificado_generado]')) {
    formData.append('speaker_event[certificado_generado]', '0');
  }

  const url = `${URL_PATH}/admin/asignarPonente`;

  showLoading(true);
  
  try {
    
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    const contentType = response.headers.get("content-type");
    
    if (contentType?.includes("application/json")) {
      
      const result = await response.json();
      
      if (result.status === "success") {
        showMessage("Ponente asignado exitosamente", "success");
        setTimeout(() => { 
          window.location.href = `${URL_PATH}/admin/listarPonentes`; 
        }, 2000);
      } else {
        showMessage(result.message || "Error al asignar ponente", "error");
      }
    } else {
      
      const text = await response.text();
      
      const successIndicators = [
        'success',
        'exitoso',
        'correctamente',
        'asignado',
        'listarPonentes'
      ];
      
      const errorIndicators = [
        'error',
        'failed',
        'exception',
        'warning',
        'undefined',
        'fatal'
      ];
      
      let hasSuccess = false;
      let hasError = false;
      
      successIndicators.forEach(indicator => {
        if (text.toLowerCase().includes(indicator)) {
          hasSuccess = true;
        }
      });
      
      errorIndicators.forEach(indicator => {
        if (text.toLowerCase().includes(indicator)) {
          hasError = true;
        }
      });
      
      if (response.url.includes('listarPonentes') || hasSuccess) {
        showMessage("Ponente asignado exitosamente", "success");
        setTimeout(() => { 
          window.location.href = `${URL_PATH}/admin/listarPonentes`; 
        }, 2000);
      } else if (hasError) {
        showMessage("Error al procesar la solicitud. Revisa la consola para más detalles.", "error");
      } else {
        showMessage("Respuesta inesperada del servidor. Revisa la consola.", "warning");
      }
    }
  } catch (err) {
    showMessage("Error de conexión. Inténtalo de nuevo.", "error");
  } finally {
    showLoading(false);
  }
}

function validateForm() {
  
  const required = [
    { name: 'speaker_event[id_evento]', label: 'Evento' },
    { name: 'speaker_event[id_ponente]', label: 'Ponente' },
    { name: 'speaker_event[hora_participacion]', label: 'Hora de Participación' },
    { name: 'speaker_event[estado_asistencia]', label: 'Estado de Asistencia' },
    { name: 'speaker_event[fecha_registro]', label: 'Fecha de Registro' }
  ];

  for (const field of required) {
    const el = document.querySelector(`[name="${field.name}"]`);
    
    if (!el) { 
      showMessage(`Campo '${field.label}' no encontrado`, "error"); 
      return false; 
    }
    
    const value = el.value.trim();
    if (!value) { 
      showMessage(`El campo ${field.label} es requerido`, "error"); 
      el.focus(); 
      return false; 
    }
  }

  const hora = document.querySelector('[name="speaker_event[hora_participacion]"]');
  if (hora && hora.value) {
    const horaRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    if (!horaRegex.test(hora.value)) {
      showMessage("Hora inválida (HH:MM)", "error");
      hora.focus();
      return false;
    }
  }
  
  return true;
}