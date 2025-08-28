// calendar.register.js corregido
import { state, groupEvents } from "./calendar.core.js";
import { renderDayList } from "./calendar.daylist.js";
import { updateDayButtons } from "./calendar.ui.js";

export function escapeHtml(s = "") {
  return String(s)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

export function renderActionButton(evento) {
  if (!evento.inscrito) {
    return `
      <button 
        class="inscribirse-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
        data-evento-id="${evento.id_evento}"
        data-evento-titulo="${escapeHtml(evento.titulo_evento)}"
      >
        Inscribirme
      </button>
    `;
  } else {
    return `
      <div class="flex gap-2">
        <span class="bg-green-100 text-green-800 px-3 py-2 rounded-lg text-sm font-medium">
          ✓ Inscrito
        </span>
        <button 
          class="cancelar-btn bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
          data-evento-id="${evento.id_evento}"
        >
          Cancelar
        </button>
      </div>
    `;
  }
}

export async function confirmarEInscripcion(idEvento, titulo) {
  if (!idEvento || isNaN(idEvento)) {
    await Swal.fire({
      icon: "error",
      title: "Error",
      text: "ID de evento inválido",
    });
    return;
  }

  const { value: accepted } = await Swal.fire({
    title: "Términos y condiciones",
    html: `
      <div class="text-left text-sm leading-relaxed">
        <p class="mb-3">Para inscribirte en <strong>${escapeHtml(
          titulo
        )}</strong> debes aceptar los términos y condiciones de participación.</p>
        <div class="p-3 rounded bg-gray-50 border text-xs text-gray-600">
          <p class="mb-2"><strong>Resumen:</strong> Tu inscripción se registrará con tu usuario. La asistencia podrá ser verificada y se emitirá certificado si aplica.</p>
          <p>Al aceptar, autorizas el tratamiento de datos según la política institucional.</p>
        </div>
      </div>
      <label class="mt-4 inline-flex items-center gap-2 text-sm">
        <input type="checkbox" id="tcCheck" class="w-4 h-4 text-lime-600 border-gray-300 rounded">
        <span>Acepto los términos y condiciones</span>
      </label>
    `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: "Inscribirme",
    cancelButtonText: "Cancelar",
    customClass: { popup: "swal-popup-custom" },
    preConfirm: () => {
      const ok = document.getElementById("tcCheck")?.checked;
      if (!ok) {
        Swal.showValidationMessage(
          "Debes aceptar los términos y condiciones para continuar."
        );
        return false;
      }
      return true;
    },
  });

  if (!accepted) return;

  const loadingSwal = Swal.fire({
    title: "Inscribiendo...",
    html: "Por favor espera mientras procesamos tu inscripción",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    didOpen: () => Swal.showLoading(),
  });

  const timeoutId = setTimeout(() => {
    Swal.close();
    Swal.fire({
      icon: "error",
      title: "Tiempo agotado",
      text: "La inscripción tardó demasiado. Intenta de nuevo.",
    });
  }, 30000);

  try {
    if (typeof URL_PATH === "undefined") {
      throw new Error("URL_PATH no está definido");
    }

    const url = `${URL_PATH}/user/inscribirme/${idEvento}`;
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
      },
      credentials: "same-origin",
      body: JSON.stringify({}), 
    });

    clearTimeout(timeoutId);

    let data = null;
    try {
      data = await response.json();
    } catch {
      data = null; 
    }

    Swal.close();

    const msg = data?.message || "Ocurrió un problema procesando tu solicitud.";

    if (response.status === 200 && data?.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "¡Inscripción exitosa!",
        text: data.message || "Te has inscrito correctamente.",
      });

      state.events = (state.events || []).map((e) =>
        e.id_evento == idEvento ? { ...e, inscrito: true } : e
      );
      state.eventsByDate = groupEvents(state.events);

      const day = state.selectedDate || state.today;
      renderDayList(day);
      updateDayButtons();
      return;
    }

    if (response.status === 409) {
      await Swal.fire({
        icon: "warning",
        title: "Conflicto",
        text: msg || "Ya estás inscrito o no hay cupos disponibles.",
      });
    } else if (response.status === 404) {
      await Swal.fire({
        icon: "error",
        title: "Evento no encontrado",
        text: msg || "El evento no existe.",
      });
    } else if (response.status === 403) {
      await Swal.fire({
        icon: "error",
        title: "Permiso denegado",
        text: msg || "No tienes permisos para inscribirte.",
      });
    } else if (response.status === 401) {
      await Swal.fire({
        icon: "error",
        title: "Sesión requerida",
        text: msg || "Debes iniciar sesión para inscribirte.",
      });
    } else if (response.status === 400) {
      await Swal.fire({
        icon: "warning",
        title: "Solicitud inválida",
        text: msg || "Verifica los datos e intenta nuevamente.",
      });
    } else if (response.status >= 500) {
      await Swal.fire({
        icon: "error",
        title: "Error del servidor",
        text: msg || "Intenta nuevamente más tarde.",
      });
    } else {
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: msg,
      });
    }
  } catch (error) {
    clearTimeout(timeoutId);
    Swal.close();
    await Swal.fire({
      icon: "error",
      title: "Error al inscribirte",
      text: error?.message || "No se pudo conectar con el servidor.",
    });
  }
}

export async function cancelarInscripcionCalendario(idEvento) {
  const { value: confirmed } = await Swal.fire({
    title: '¿Cancelar inscripción?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, cancelar',
    cancelButtonText: 'No, mantener',
    confirmButtonColor: '#dc2626'
  });
  
  if (!confirmed) return;

  const loadingSwal = Swal.fire({
    title: "Cancelando...",
    html: "Por favor espera mientras procesamos tu solicitud",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    didOpen: () => Swal.showLoading(),
  });

  try {
    const url = `${URL_PATH}/user/cancelarInscripcion/${idEvento}`;
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
      },
      credentials: "same-origin",
    });

    const data = await response.json();
    Swal.close();

    if (response.status === 200 && data?.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "Inscripción cancelada",
        text: data.message || "Tu inscripción ha sido cancelada exitosamente.",
      });

      state.events = (state.events || []).map((e) =>
        e.id_evento == idEvento ? { ...e, inscrito: false } : e
      );
      state.eventsByDate = groupEvents(state.events);

      const day = state.selectedDate || state.today;
      renderDayList(day);
      updateDayButtons();
      
    } else {
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: data.message || "No se pudo cancelar la inscripción",
      });
    }

  } catch (error) {
    Swal.close();
    await Swal.fire({
      icon: "error",
      title: "Error al cancelar",
      text: error?.message || "No se pudo conectar con el servidor.",
    });
  }
}

window.confirmarEInscripcion = confirmarEInscripcion;
window.cancelarInscripcionCalendario = cancelarInscripcionCalendario;