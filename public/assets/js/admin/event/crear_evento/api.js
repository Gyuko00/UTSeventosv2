// api.js
import { mostrarLoading } from "./helpers.js";

export async function manejarSubmitEvento(e) {
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

function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}
