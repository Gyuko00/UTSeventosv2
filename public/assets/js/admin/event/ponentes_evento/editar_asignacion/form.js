// assets/js/admin/event/ponentes_evento/editar_asignacion/form.js
import { validateForm } from './validacion.js';

export function initializeForm() {
  const form = document.getElementById('editarAsignacionForm');
  const btnLimpiar = document.getElementById('btnLimpiar');

  if (!form) {
    window.showMessage('Error de inicialización del formulario', 'error');
    return;
  }

  form.addEventListener('submit', handleFormSubmit);
  if (btnLimpiar) btnLimpiar.addEventListener('click', handleRestore);
}

async function handleFormSubmit(e) {
  e.preventDefault();

  if (!validateForm()) return;

  const formData = new FormData(e.target);
  if (!formData.has('speaker_event[certificado_generado]')) {
    formData.append('speaker_event[certificado_generado]', '0');
  }

  const url = e.target.action;
  showLoading(true);

  try {
    const response = await fetch(url, { method: 'POST', body: formData });

    if (!response.ok) throw new Error(`HTTP ${response.status}`);

    const contentType = response.headers.get('content-type') || '';

    // Caso JSON
    if (contentType.includes('application/json')) {
      const result = await response.json();
      if (result?.status === 'success') {
        window.showMessage('Asignación actualizada exitosamente', 'success');
        setTimeout(() => { window.location.href = `${URL_PATH}/admin/listarPonentes`; }, 2000);
      } else {
        window.showMessage(result?.message || 'Error al actualizar la asignación', 'error');
      }
      return;
    }

    // Caso no JSON: heurística por contenido/URL final
    const text = await response.text();
    const lower = text.toLowerCase();

    const successIndicators = ['success', 'exitoso', 'correctamente', 'actualizada', 'listar_ponentes'];
    const errorIndicators   = ['error', 'failed', 'exception', 'warning', 'undefined', 'fatal'];

    const hasSuccess = successIndicators.some(k => lower.includes(k));
    const hasError   = errorIndicators.some(k => lower.includes(k));
    const urlChanged = response.url && response.url !== url;

    if ((response.url && response.url.includes('listar_ponentes')) || hasSuccess || urlChanged) {
      window.showMessage('Asignación actualizada exitosamente', 'success');
      setTimeout(() => { window.location.href = `${URL_PATH}/admin/listarPonentes`; }, 2000);
    } else if (hasError) {
      window.showMessage('Error al actualizar la asignación.', 'error');
    } else {
      window.showMessage('Respuesta inesperada del servidor.', 'warning');
    }
  } catch (_) {
    window.showMessage('Error de conexión. Inténtalo de nuevo.', 'error');
  } finally {
    showLoading(false);
  }
}

function handleRestore(e) {
  e.preventDefault();

  if (confirm('¿Estás seguro de que deseas restaurar los valores originales?\n\nSe perderán todos los cambios no guardados.')) {
    const data = window.ponenteEventoData;
    if (!data) {
      window.showMessage('No se pueden restaurar los valores originales', 'warning');
      return;
    }
    restoreFormValues(data);
    window.showMessage('Valores restaurados exitosamente', 'success');
  }
}

function restoreFormValues(data) {
  const horaField = document.getElementById('hora_participacion');
  if (horaField && data.hora_participacion) {
    horaField.value = String(data.hora_participacion).substring(0, 5);
  }

  const estadoField = document.getElementById('estado_asistencia');
  if (estadoField && data.estado_asistencia) {
    estadoField.value = data.estado_asistencia;
  }

  const certificadoField = document.getElementById('certificado_generado');
  if (certificadoField) {
    certificadoField.checked = Number(data.certificado_generado) === 1;
  }

  const fechaField = document.getElementById('fecha_registro');
  if (fechaField && data.fecha_registro) {
    const d = new Date(data.fecha_registro);
    if (!isNaN(d.valueOf())) {
      fechaField.value = d.toISOString().slice(0, 16);
    }
  }

  document.querySelectorAll('.bg-yellow-50').forEach(el => el.remove());
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
