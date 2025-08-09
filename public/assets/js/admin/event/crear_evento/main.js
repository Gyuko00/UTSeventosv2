document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("crearEventoForm");
  if (!form) return;

  configurarValidaciones();

  form.addEventListener("submit", manejarSubmitEvento);
});

function configurarValidaciones() {
  const fechaEvento = document.getElementById("fecha");
  const horaInicio = document.getElementById("hora_inicio");
  const horaFin = document.getElementById("hora_fin");
  const cupoMaximo = document.getElementById("cupo_maximo");

  if (fechaEvento) {
    const today = new Date().toISOString().split("T")[0];
    fechaEvento.min = today;
  }

  if (horaInicio && horaFin) {
    horaInicio.addEventListener("change", validarHorarios);
    horaFin.addEventListener("change", validarHorarios);
  }

  if (cupoMaximo) {
    cupoMaximo.addEventListener("input", function () {
      const valor = parseInt(this.value);
      if (valor < 1) this.value = 1;
      if (valor > 9999) this.value = 9999;
    });
  }
}

function validarHorarios() {
  const horaInicio = document.getElementById("hora_inicio");
  const horaFin = document.getElementById("hora_fin");

  if (horaInicio.value && horaFin.value) {
    const inicio = new Date(`2000-01-01T${horaInicio.value}`);
    const fin = new Date(`2000-01-01T${horaFin.value}`);

    if (fin <= inicio) {
      mostrarError(
        "La hora de finalización debe ser posterior a la hora de inicio."
      );
      horaFin.value = "";
      return false;
    }
  }
  return true;
}

async function manejarSubmitEvento(e) {
  e.preventDefault();
  limpiarErrores();

  mostrarLoading(true);

  const form = e.target;
  const formData = new FormData(form);

  const eventData = {
    event: {
      titulo_evento: formData.get("titulo_evento") || "",
      tema: formData.get("tema") || "",
      descripcion: formData.get("descripcion") || "",
      fecha: formData.get("fecha") || "",
      hora_inicio: formData.get("hora_inicio") || "",
      hora_fin: formData.get("hora_fin") || "",
      departamento_evento: formData.get("departamento_evento") || "",
      municipio_evento: formData.get("municipio_evento") || "",
      institucion_evento: formData.get("institucion_evento") || "",
      lugar_detallado: formData.get("lugar_detallado") || "",
      cupo_maximo: formData.get("cupo_maximo") || "0",
      id_usuario_creador: formData.get("id_usuario_creador") || "",
    },
  };

  try {
    const response = await fetch(form.action, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(eventData),
    });

    const responseText = await response.text();
    if (responseText.trim().startsWith("<")) {
      throw new Error("El servidor devolvió una respuesta HTML inesperada.");
    }

    let data;
    try {
      data = JSON.parse(responseText);
    } catch (parseError) {
      throw new Error("La respuesta del servidor no es JSON válido.");
    }

    if (data.status === "error") {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: data.message || "Ocurrió un error al crear el evento.",
      });
      mostrarLoading(false);
      return;
    }

    await Swal.fire({
      icon: "success",
      title: "Evento creado",
      text: data.message || "El evento fue creado exitosamente",
    });

    window.location.href = data.redirect || URL_PATH + "/admin/listarEventos";
  } catch (error) {
    console.error("[ERROR]:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: error.message || "No se pudo completar la solicitud.",
    });
  } finally {
    mostrarLoading(false);
  }
}


function mostrarLoading(mostrar) {
  const submitButton = document.querySelector(
    '#crearEventoForm button[type="submit"]'
  );
  if (submitButton) {
    submitButton.disabled = mostrar;
    submitButton.innerHTML = mostrar
      ? '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Procesando...</span>'
      : "Crear Evento";
  }
}

function resaltarError(elemento) {
  if (elemento) {
    elemento.classList.add("border-red-500");
    elemento.addEventListener("input", function () {
      if (this.value.trim()) {
        this.classList.remove("border-red-500");
      }
    });
  }
}

function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}

function mostrarError(mensaje) {
  const errorDiv = document.createElement("div");
  errorDiv.className =
    "error-message bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4";
  errorDiv.innerHTML = `<p>${mensaje}</p>`;

  const form = document.getElementById("crearEventoForm");
  if (form) {
    form.insertBefore(errorDiv, form.firstChild);
    errorDiv.scrollIntoView({ behavior: "smooth" });
  }
}

function mostrarErrores(errores) {
  if (errores.length === 0) return;

  const errorDiv = document.createElement("div");
  errorDiv.className =
    "error-message bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4";
  errorDiv.innerHTML = `
      <p class="font-bold">Errores encontrados:</p>
      <ul class="list-disc pl-5 mt-2">
          ${errores.map((error) => `<li>${error}</li>`).join("")}
      </ul>
  `;

  const form = document.getElementById("crearEventoForm");
  if (form) {
    form.insertBefore(errorDiv, form.firstChild);
    errorDiv.scrollIntoView({ behavior: "smooth" });
  }
}
