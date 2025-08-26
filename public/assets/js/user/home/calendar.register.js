// calendar.register.js
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
      body: JSON.stringify({}), // asegura POST con body
    });

    clearTimeout(timeoutId);

    // Intenta parsear JSON SIEMPRE (aunque no sea ok) para leer 'message'
    let data = null;
    try {
      data = await response.json();
    } catch {
      data = null; // dejar que caiga a mensaje genérico
    }

    Swal.close();

    const msg = data?.message || "Ocurrió un problema procesando tu solicitud.";

    if (response.status === 200 && data?.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "¡Inscripción exitosa!",
        text: data.message || "Te has inscrito correctamente.",
      });

      // Actualizar estado local
      state.events = (state.events || []).map((e) =>
        e.id_evento == idEvento ? { ...e, inscrito: 1 } : e
      );
      state.eventsByDate = groupEvents(state.events);

      const day = state.selectedDate || state.today;
      renderDayList(day);
      updateDayButtons();
      return;
    }

    // Manejo por códigos
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
