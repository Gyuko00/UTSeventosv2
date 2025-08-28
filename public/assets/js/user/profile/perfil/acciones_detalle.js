window.addEventListener("load", function () {
  document.addEventListener("click", function (e) {
    const target = e.target;

    if (
      target.classList.contains("btn-inscribirse") ||
      target.closest(".btn-inscribirse")
    ) {
      e.preventDefault();

      const button = target.classList.contains("btn-inscribirse")
        ? target
        : target.closest(".btn-inscribirse");
      const eventoId = parseInt(button.dataset.eventoId);
      const eventoTitulo = button.dataset.eventoTitulo || "";

      if (typeof window.confirmarEInscripcion === "function") {
        window.confirmarEInscripcion(eventoId, eventoTitulo).then(() => {
          setTimeout(() => location.reload(), 1000);
        });
      } else {
        console.error("Función confirmarEInscripcion no está disponible");
        fallbackInscripcion(eventoId, eventoTitulo);
      }
    }

    if (
      target.classList.contains("btn-cancelar") ||
      target.closest(".btn-cancelar")
    ) {
      e.preventDefault();

      const button = target.classList.contains("btn-cancelar")
        ? target
        : target.closest(".btn-cancelar");
      const eventoId = parseInt(button.dataset.eventoId);

      if (typeof window.cancelarInscripcionCalendario === "function") {
        window.cancelarInscripcionCalendario(eventoId).then(() => {
          setTimeout(() => location.reload(), 1000);
        });
      } else {
        console.error(
          "Función cancelarInscripcionCalendario no está disponible"
        );
        fallbackCancelar(eventoId);
      }
    }
  });
});

async function fallbackInscripcion(eventoId, titulo) {
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

async function fallbackCancelar(eventoId) {
  const { value: confirmed } = await Swal.fire({
    title: "¿Cancelar inscripción?",
    text: "Esta acción no se puede deshacer",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "No, mantener",
    confirmButtonColor: "#dc2626",
  });

  if (!confirmed) return;

  try {
    const response = await fetch(
      `${URL_PATH}/user/cancelarInscripcion/${eventoId}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
      }
    );

    const result = await response.json();

    if (result.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "Inscripción cancelada",
        text: result.message,
      });
      location.reload();
    } else {
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: result.message || "No se pudo cancelar la inscripción",
      });
    }
  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: "No se pudo procesar la solicitud",
    });
  }
}

// assets/js/user/profile/perfil/acciones_detalle.js
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-entrada');
    if (!btn) return;
    e.preventDefault();

    const eventoId = btn.dataset.eventoId;
    if (!eventoId) return;

    // Mostrar loading
    btn.disabled = true;
    btn.innerHTML = 'Generando...';

    const a = document.createElement('a');
    a.href = `${URL_PATH}/user/generarEntrada/${eventoId}`;
    // No especificar download para que use el nombre del servidor
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();

    // Restaurar botón después de un momento
    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '📱 Entrada (QR)';
        a.remove();
    }, 2000);
});
  
