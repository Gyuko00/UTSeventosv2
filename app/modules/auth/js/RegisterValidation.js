document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registroForm");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const errores = [];

    const getValue = (name) =>
      form.querySelector(`[name="${name}"]`)?.value.trim() || "";

    const hasEmoji = (text) =>
      /[\p{Emoji_Presentation}\p{Extended_Pictographic}]/gu.test(text);

    const tipo_documento = getValue("tipo_documento");
    if (!tipo_documento) {
      errores.push("Debe seleccionar un tipo de documento.");
    }

    const numero_documento = getValue("numero_documento");
    if (!/^\d{5,10}$/.test(numero_documento)) {
      errores.push(
        "El número de documento debe contener solo números, entre 5 y 10 dígitos. No se permiten letras, espacios ni emojis."
      );
    }

    const nombres = getValue("nombres");
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(nombres) || hasEmoji(nombres)) {
      errores.push(
        "Los nombres deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final."
      );
    }

    const apellidos = getValue("apellidos");
    if (
      !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(apellidos) ||
      hasEmoji(apellidos)
    ) {
      errores.push(
        "Los apellidos deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final."
      );
    }

    const telefono = getValue("telefono").replace(/\D/g, "");
    if (!/^\d{7,13}$/.test(telefono)) {
      errores.push(
        "El teléfono debe contener solo números (entre 7 y 13 dígitos)."
      );
    }

    const correo = getValue("correo_personal");
    if (!/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i.test(correo)) {
      errores.push("Ingrese un correo electrónico válido.");
    }

    const departamento = getValue("departamento");
    if (!departamento) {
      errores.push("Debe seleccionar un departamento.");
    }

    const municipio = getValue("municipio");
    if (!municipio) {
      errores.push("Debe seleccionar un municipio.");
    }

    const direccion = getValue("direccion");
    if (direccion.length < 5 || direccion.length > 100 || hasEmoji(direccion)) {
      errores.push(
        "La dirección debe tener entre 5 y 100 caracteres, sin emojis."
      );
    }

    const usuario = getValue("usuario");
    if (!/^[a-zA-Z0-9_.-]{4,20}$/.test(usuario)) {
      errores.push(
        "El nombre de usuario debe tener entre 4 y 20 caracteres. Solo se permiten letras, números, guiones, puntos y guiones bajos."
      );
    }

    const contrasenia = getValue("contrasenia");
    const contraseniaRegex =
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
    if (!contraseniaRegex.test(contrasenia) || hasEmoji(contrasenia)) {
      errores.push(
        "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos una letra mayúscula, una minúscula y un número. No se permiten emojis."
      );
    }

    if (errores.length > 0) {
      return Swal.fire({
        icon: "error",
        title: "Errores en el formulario",
        html:
          "<ul style='text-align:left'>" +
          errores.map((e) => `<li>${e}</li>`).join("") +
          "</ul>",
        confirmButtonColor: "#d33",
      });
    }

    // ✅ ENVIAR FORMULARIO POR FETCH SIN RECARGAR LA PÁGINA
    const formData = new FormData(form);

    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
      });

      const text = await response.text();
      console.log("Respuesta cruda:", text);

      let result;
      try {
        result = JSON.parse(text);
      } catch (err) {
        throw new Error("Respuesta no es JSON válida");
      }

      if (result.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Registro exitoso",
          text: result.message,
          confirmButtonColor: "#3085d6",
        }).then(() => {
          const loginUrl = form.dataset.loginUrl;
          window.location.href = loginUrl;
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result.message || "No se pudo registrar.",
          confirmButtonColor: "#d33",
        });
      }
    } catch (err) {
      try {
        const rawText = await err.response?.text?.();
        console.error("Error en fetch: contenido no JSON", rawText || err);
      } catch (innerErr) {
        console.error("Error en fetch:", err);
      }

      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo conectar con el servidor o la respuesta no fue válida.",
        confirmButtonColor: "#d33",
      });
    }
  });
});
