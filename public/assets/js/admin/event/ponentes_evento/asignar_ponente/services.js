// services.js
export function loadEventosAndPonentes() {
  
  try {

    if (window.eventosData && Array.isArray(window.eventosData)) {
      if (window.eventosData.length > 0) {

        populateEventosSelect(window.eventosData);
      } else {
        showMessage("No hay eventos disponibles", "warning");
      }
    } else {
      showMessage("Error: Datos de eventos no válidos", "error");
    }

    if (window.ponentesData && Array.isArray(window.ponentesData)) {
      if (window.ponentesData.length > 0) {

        populatePonentesSelect(window.ponentesData);
      } else {
        showMessage("No hay ponentes disponibles", "warning");
        
        const select = document.querySelector('select[name="speaker_event[id_ponente]"]');
        if (select) {
          select.innerHTML = '<option value="">No hay ponentes disponibles</option>';
        }
      }
    } else {
      showMessage("Error: Datos de ponentes no válidos", "error");
    }

  } catch (err) {
    showMessage("Error al procesar los datos", "error");
  }
}

function populateEventosSelect(eventos) {
  
  const selectors = [
    'select[name="speaker_event[id_evento]"]',
    'select[name="id_evento"]',
    '#id_evento',
    'select.evento-select'
  ];
  
  let select = null;
  for (const selector of selectors) {
    select = document.querySelector(selector);
    if (select) {
      break;
    }
  }
  
  if (!select) {
    showMessage("Error: Select de eventos no encontrado", "error");
    return;
  }

  select.innerHTML = '<option value="">Seleccionar evento...</option>';

  eventos.forEach((evento) => {    
    const option = document.createElement("option");
    option.value = evento.id_evento;
    option.textContent = `${evento.titulo_evento} - ${new Date(evento.fecha).toLocaleDateString()}`;
    select.appendChild(option);
  });
  
}

function populatePonentesSelect(ponentes) {
  
  const selectors = [
    'select[name="speaker_event[id_ponente]"]',
    'select[name="id_ponente"]',
    '#id_ponente',
    'select.ponente-select'
  ];
  
  let select = null;
  for (const selector of selectors) {
    select = document.querySelector(selector);
    if (select) {
      break;
    }
  }
  
  if (!select) {
    showMessage("Error: Select de ponentes no encontrado", "error");
    return;
  }

  select.innerHTML = '<option value="">Seleccionar ponente...</option>';

  if (ponentes.length === 0) {
    select.innerHTML = '<option value="">No hay ponentes disponibles</option>';
    return;
  }

  const ponentesUnicos = ponentes.reduce((acc, ponente) => {
    if (!acc[ponente.id_ponente]) {
      acc[ponente.id_ponente] = ponente;
    }
    return acc;
  }, {});

  const ponentesArray = Object.values(ponentesUnicos);

  ponentesArray.forEach((ponente, index) => {
    
    const option = document.createElement("option");
    option.value = ponente.id_ponente;
    option.textContent = `${ponente.nombres} ${ponente.apellidos} - ${ponente.tema || "Sin tema asignado"}`;
    select.appendChild(option);
  });
  
}

export function showMessage(msg, type = "info") {
  let container = document.getElementById("messageContainer");
  if (!container) {
    container = document.createElement("div");
    container.id = "messageContainer";
    container.className = "fixed top-4 right-4 z-50";
    document.body.appendChild(container);
  }
  
  const div = document.createElement("div");
  const styles = {
    success: "bg-green-50 border-green-200 text-green-700",
    error: "bg-red-50 border-red-200 text-red-700",
    warning: "bg-yellow-50 border-yellow-200 text-yellow-700",
    info: "bg-blue-50 border-blue-200 text-blue-700",
  };
  
  div.className = `${styles[type]} border px-4 py-3 rounded-lg shadow-lg mb-2 max-w-md`;
  div.innerHTML = `<span>${msg}</span>`;
  container.appendChild(div);
  setTimeout(() => div.remove(), 4000);
}

export function showLoading(show) {
  let overlay = document.getElementById("loadingOverlay");
  if (!overlay) {
    overlay = document.createElement("div");
    overlay.id = "loadingOverlay";
    overlay.className = "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50";
    overlay.innerHTML = `<div class="bg-white p-6 rounded-lg flex items-center gap-3 shadow-xl">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
        <span class="text-gray-700">Procesando...</span></div>`;
    document.body.appendChild(overlay);
  }
  overlay.style.display = show ? "flex" : "none";
}

