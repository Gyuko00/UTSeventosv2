// api.js - Con debug visual mejorado
import { mostrarLoading } from './helpers.js';

export async function manejarSubmitEvento(e) {
  e.preventDefault();
  limpiarErrores();

  mostrarLoading(true);

  const form = e.target;
  const formData = new FormData(form);

  const cleanFormData = new FormData();
  const processedKeys = new Set();
  
  for (let [key, value] of formData.entries()) {
    if (processedKeys.has(key)) {
      continue;
    }
    
    if (key === 'id_usuario_creador') {
      continue;
    }
    
    cleanFormData.append(key, value);
    processedKeys.add(key);
  }

  try {
    const response = await fetch(form.action, {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      body: cleanFormData, 
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
      let errorMessage = data.message || "Ocurrió un error al actualizar el evento.";
      if (data.debug) {
        errorMessage += "\n\nInformación de debug disponible en la consola.";
      }
      
      Swal.fire({
        icon: "error",
        title: "Error",
        text: errorMessage,
      });
      mostrarLoading(false);
      return;
    }

    await Swal.fire({
      icon: "success",
      title: "Evento actualizado",
      text: data.message || "El evento fue actualizado exitosamente",
    });

    window.location.href = data.redirect || URL_PATH + "/admin/eventos";
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: error.message || "No se pudo completar la solicitud.",
    });
  } finally {
    mostrarLoading(false);
  }
}

function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}