/**
 * SCRIPT DE VALIDACIÓN Y REGISTRO DE USUARIOS
 * 
 * Controla el formulario de registro con validaciones del lado del cliente
 * para todos los campos requeridos. Incluye validación de formatos,
 * detección de emojis y envío asíncrono de datos.
 * 
 * Funcionalidades incluidas:
 * - Validación de documentos, nombres, teléfonos y correos
 * - Validación de credenciales con políticas de seguridad
 * - Detección y prevención de emojis en campos
 * - Envío asíncrono con manejo de errores
 * - Integración con SweetAlert2 para notificaciones
 * 
 * Elementos requeridos:
 * - Formulario con ID 'registroForm'
 * - Campos con atributos name correspondientes
 * - Librería SweetAlert2 para alertas
 * 
 */

import { validations } from "../../../../utils/validations/register_form_validations.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registroForm");
  if (!form) return;

  const hasEmoji = (text) =>
    /[\p{Emoji_Presentation}\p{Extended_Pictographic}]/gu.test(text);

  const getValue = (name) =>
    form.querySelector(`[name="${name}"]`)?.value.trim() || "";

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const errors = [];

    validations.forEach(({ field, validation, error }) => {
      const value = getValue(field);
      if (validation(value) || hasEmoji(value)) {
        errors.push(error);
      }
    });

    if (errors.length > 0) {
      return Swal.fire({
        icon: "error",
        title: "Errores en el formulario",
        html: `<ul style='text-align:left'>${errors
          .map((e) => `<li>${e}</li>`)
          .join("")}</ul>`,
        confirmButtonColor: "#d33",
      });
    }

    const formData = new FormData(form);
    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
      });

      const text = await response.text();
      let result;

      try {
        result = JSON.parse(text);
      } catch {
        throw new Error("Respuesta no es JSON válida");
      }

      if (result.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "Registro exitoso",
          text: result.message,
          confirmButtonColor: "#3085d6",
        });
        const loginUrl = form.dataset.loginUrl;
        window.location.href = loginUrl;
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result.message || "No se pudo registrar.",
          confirmButtonColor: "#d33",
        });
      }
    } catch (err) {
      console.error("Error en fetch:", err);
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo conectar con el servidor o la respuesta no fue válida.",
        confirmButtonColor: "#d33",
      });
    }
  });
});
