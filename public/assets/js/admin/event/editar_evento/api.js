// api.js - Con debug visual mejorado
import { mostrarLoading } from './helpers.js';

export async function manejarSubmitEvento(e) {
  e.preventDefault();
  limpiarErrores();

  mostrarLoading(true);

  const form = e.target;
  const formData = new FormData(form);

  // SOLUCIÓN 1: Limpiar FormData de campos duplicados
  const cleanFormData = new FormData();
  const processedKeys = new Set();
  
  for (let [key, value] of formData.entries()) {
    // Si el campo ya fue procesado, saltar
    if (processedKeys.has(key)) {
      console.log(`Campo duplicado ignorado: ${key} = ${value}`);
      continue;
    }
    
    // Si es id_usuario_creador, no agregarlo al FormData limpio
    // (se manejará en el backend)
    if (key === 'id_usuario_creador') {
      console.log(`Campo id_usuario_creador ignorado: ${value}`);
      continue;
    }
    
    cleanFormData.append(key, value);
    processedKeys.add(key);
    console.log(`Campo agregado: ${key} = ${value}`);
  }

  // DEBUG: Ver FormData limpio
  console.log("=== FormData LIMPIO ===");
  for (let [key, value] of cleanFormData.entries()) {
    console.log(`${key}: ${value}`);
  }

  try {
    const response = await fetch(form.action, {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      body: cleanFormData, // Usar FormData limpio
    });

    const responseText = await response.text();
    console.log("=== RESPUESTA DEL SERVIDOR ===");
    console.log(responseText);

    if (responseText.trim().startsWith("<")) {
      throw new Error("El servidor devolvió una respuesta HTML inesperada.");
    }

    let data;
    try {
      data = JSON.parse(responseText);
    } catch (parseError) {
      console.error("Error parseando JSON:", parseError);
      console.error("Respuesta que causó el error:", responseText);
      throw new Error("La respuesta del servidor no es JSON válido.");
    }

    // DEBUG: Mostrar información de debug del servidor
    if (data.debug) {
      console.log("=== DEBUG DEL SERVIDOR ===");
      console.log(data.debug);
    }

    if (data.status === "error") {
      // Mostrar debug en el modal de error también
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

function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}