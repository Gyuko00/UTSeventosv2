// assets/js/admin/ponentes_evento/asignar_ponente/main.js

document.addEventListener("DOMContentLoaded", function () {
  initializeForm();
  loadEventosAndPonentes();
});

function initializeForm() {
  const form = document.getElementById("asignarPonenteForm");
  const btnLimpiar = document.getElementById("btnLimpiar");

  form.addEventListener("submit", handleFormSubmit);

  btnLimpiar.addEventListener("click", function () {
    if (confirm("¿Estás seguro de que deseas limpiar el formulario?")) {
      form.reset();
      document.getElementById("fecha_registro").value = new Date()
        .toISOString()
        .slice(0, 16);
    }
  });
}

async function loadEventosAndPonentes() {
  try {
    const [eventosResponse, ponentesResponse] = await Promise.all([
      fetch(`${URL_PATH}/admin/listarEventos`),
      fetch(`${URL_PATH}/admin/listarPonentes`),
    ]);

    if (!eventosResponse.ok || !ponentesResponse.ok) {
      throw new Error("Error al cargar los datos");
    }

    const eventosData = await eventosResponse.json();
    const ponentesData = await ponentesResponse.json();

    if (!eventosData.data) {
      await loadEventosFromView();
    } else {
      populateEventosSelect(eventosData.data);
    }

    if (!ponentesData.data) {
      await loadPonentesFromView();
    } else {
      populatePonentesSelect(ponentesData.data);
    }
  } catch (error) {
    showMessage(
      "Error al cargar los datos. Por favor, recarga la página.",
      "error"
    );
  }
}

async function loadEventosFromView() {
  try {
    const response = await fetch(`${URL_PATH}/admin/listarEventos`);
    const text = await response.text();

  } catch (error) {
    showMessage(
      "Error al cargar los datos. Por favor, recarga la página.",
      "error"
    );
  }
}

async function loadPonentesFromView() {
  try {
    const response = await fetch(`${URL_PATH}/admin/listarPonentes`);
    const text = await response.text();

  } catch (error) {
    showMessage(
      "Error al cargar los datos. Por favor, recarga la página.",
      "error"
    );
  }
}

function populateEventosSelect(eventos) {
  const selectEvento = document.getElementById("id_evento");

  selectEvento.innerHTML = '<option value="">Seleccionar evento...</option>';

  eventos.forEach((evento) => {
    const option = document.createElement("option");
    option.value = evento.id_evento;
    option.textContent = `${evento.titulo_evento} - ${evento.fecha}`;
    selectEvento.appendChild(option);
  });
}

function populatePonentesSelect(ponentes) {
  const selectPonente = document.getElementById("id_ponente");

  selectPonente.innerHTML = '<option value="">Seleccionar ponente...</option>';

  const ponentesUnicos = {};
  ponentes.forEach((ponente) => {
    if (!ponentesUnicos[ponente.id_ponente]) {
      ponentesUnicos[ponente.id_ponente] = ponente;
    }
  });

  Object.values(ponentesUnicos).forEach((ponente) => {
    const option = document.createElement("option");
    option.value = ponente.id_ponente;
    option.textContent = `${ponente.nombres} ${ponente.apellidos} - ${ponente.tema}`;
    selectPonente.appendChild(option);
  });
}

async function handleFormSubmit(e) {
  e.preventDefault();

  if (!validateForm()) {
    return;
  }

  const formData = new FormData(e.target);

  showLoading(true);

  try {
    const response = await fetch(e.target.action, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Error en la respuesta del servidor");
    }

    const result = await response.json();

    if (result.status === "success") {
      showMessage("Ponente asignado exitosamente", "success");
      setTimeout(() => {
        e.target.reset();
        document.getElementById("fecha_registro").value = new Date()
          .toISOString()
          .slice(0, 16);
      }, 2000);
    } else {
      showMessage(result.message || "Error al asignar el ponente", "error");
    }
  } catch (error) {
    showMessage("Error de conexión. Inténtalo de nuevo.", "error");
  } finally {
    showLoading(false);
  }
}

function validateForm() {
  const requiredFields = [
    "id_evento",
    "id_ponente",
    "hora_participacion",
    "estado_asistencia",
  ];

  for (const fieldName of requiredFields) {
    const field = document.getElementById(fieldName);
    if (!field || !field.value.trim()) {
      showMessage(`El campo ${getFieldLabel(fieldName)} es requerido`, "error");
      field?.focus();
      return false;
    }
  }

  return true;
}

function getFieldLabel(fieldName) {
  const labels = {
    id_evento: "Evento",
    id_ponente: "Ponente",
    hora_participacion: "Hora de Participación",
    estado_asistencia: "Estado de Asistencia",
  };

  return labels[fieldName] || fieldName;
}

function showMessage(message, type = "info") {
  let messageContainer = document.getElementById("messageContainer");

  if (!messageContainer) {
    messageContainer = document.createElement("div");
    messageContainer.id = "messageContainer";
    messageContainer.className = "fixed top-4 right-4 z-50";
    document.body.appendChild(messageContainer);
  }

  const messageElement = document.createElement("div");
  const bgColor =
    type === "success"
      ? "bg-green-50 border-green-200 text-green-700"
      : type === "error"
      ? "bg-red-50 border-red-200 text-red-700"
      : "bg-blue-50 border-blue-200 text-blue-700";

  const icon =
    type === "success"
      ? "fas fa-check-circle"
      : type === "error"
      ? "fas fa-exclamation-circle"
      : "fas fa-info-circle";

  messageElement.className = `${bgColor} border px-4 py-3 rounded-lg shadow-lg mb-2 max-w-md`;
  messageElement.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="${icon}"></i>
            <span>${message}</span>
        </div>
    `;

  messageContainer.appendChild(messageElement);

  setTimeout(() => {
    messageElement.remove();
  }, 5000);
}

function showLoading(show) {
  let loadingOverlay = document.getElementById("loadingOverlay");

  if (!loadingOverlay) {
    loadingOverlay = document.createElement("div");
    loadingOverlay.id = "loadingOverlay";
    loadingOverlay.className =
      "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50";
    loadingOverlay.innerHTML = `
            <div class="bg-white p-6 rounded-lg flex items-center gap-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
                <span>Procesando...</span>
            </div>
        `;
    document.body.appendChild(loadingOverlay);
  }

  loadingOverlay.style.display = show ? "flex" : "none";
}
