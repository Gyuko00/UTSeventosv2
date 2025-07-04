document.addEventListener("DOMContentLoaded", () => {
  
  const form = document.getElementById("formEditarPerfil");
  if (!form) return;

  // Mostrar/ocultar sección de contraseña al hacer clic en el botón
  const btnCambiar = document.getElementById("btnCambiarContrasena");
  const seccionContrasena = document.getElementById("seccionContrasena");

  btnCambiar?.addEventListener("click", () => {
    const visible = !seccionContrasena.classList.contains("hidden");
    seccionContrasena.classList.toggle("hidden", visible);
    btnCambiar.textContent = visible
      ? "¿Cambiar contraseña?"
      : "Ocultar cambio de contraseña";
  });

  const getValue = (name) =>
    form.querySelector(`[name="${name}"]`)?.value.trim() || "";
  const hasEmoji = (text) =>
    /[\p{Emoji_Presentation}\p{Extended_Pictographic}]/gu.test(text);

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const errores = [];

    const tipo_documento = getValue("tipo_documento");
    if (!tipo_documento) errores.push("Debe indicar el tipo de documento.");

    const numero_documento = getValue("numero_documento");
    if (!/^\d{5,10}$/.test(numero_documento)) {
      errores.push(
        "El número de documento debe tener entre 5 y 10 dígitos numéricos."
      );
    }

    const nombres = getValue("nombres");
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(nombres) || hasEmoji(nombres)) {
      errores.push(
        "Los nombres deben tener entre 2 y 50 letras sin emojis ni caracteres especiales."
      );
    }

    const apellidos = getValue("apellidos");
    if (
      !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/.test(apellidos) ||
      hasEmoji(apellidos)
    ) {
      errores.push(
        "Los apellidos deben tener entre 2 y 50 letras sin emojis ni caracteres especiales."
      );
    }

    const telefono = getValue("telefono").replace(/\D/g, "");
    if (!/^\d{7,13}$/.test(telefono)) {
      errores.push("El teléfono debe tener entre 7 y 13 dígitos numéricos.");
    }

    const correo = getValue("correo_personal");
    if (!/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i.test(correo)) {
      errores.push("Ingrese un correo electrónico válido.");
    }

    const departamento = getValue("departamento");
    if (!departamento) errores.push("Debe ingresar el departamento.");

    const municipio = getValue("municipio");
    if (!municipio) errores.push("Debe ingresar el municipio.");

    const direccion = getValue("direccion");
    if (direccion.length < 5 || direccion.length > 100 || hasEmoji(direccion)) {
      errores.push(
        "La dirección debe tener entre 5 y 100 caracteres sin emojis."
      );
    }

    const usuario = getValue("usuario");
    if (!/^[a-zA-Z0-9_.-]{4,20}$/.test(usuario)) {
      errores.push(
        "El usuario debe tener entre 4 y 20 caracteres alfanuméricos o símbolos válidos (_, ., -)."
      );
    }

    // Validación de cambio de contraseña (si la sección está visible)
    const seccionContrasena = document.getElementById("seccionContrasena");
    if (!seccionContrasena.classList.contains("hidden")) {
      const actual = getValue("contrasenia_actual");
      const nueva = getValue("nueva_contrasenia");

      if (!actual || hasEmoji(actual)) {
        errores.push("Debe ingresar la contraseña actual (sin emojis).");
      }

      const regexNueva =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
      if (!regexNueva.test(nueva) || hasEmoji(nueva)) {
        errores.push(
          "La nueva contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula y un número. Sin emojis."
        );
      }
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
        throw new Error("Respuesta no válida del servidor.");
      }

      if (result.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Perfil actualizado",
          text: result.message,
          confirmButtonColor: "#3085d6",
        }).then(() => {
          window.location.href = "/utseventos/user/perfil";
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result.message || "No se pudo actualizar el perfil.",
          confirmButtonColor: "#d33",
        });
      }
    } catch (err) {
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo conectar con el servidor.",
        confirmButtonColor: "#d33",
      });
    }
  });

  document.querySelectorAll(".togglePassword").forEach((btn) => {
    btn.addEventListener("click", () => {
      const inputId = btn.getAttribute("data-target");
      const input = document.getElementById(inputId);
      const isPassword = input.type === "password";

      input.type = isPassword ? "text" : "password";

      const eyeOpen = btn.querySelector(".eyeOpen");
      const eyeClosed = btn.querySelector(".eyeClosed");

      eyeOpen.classList.toggle("hidden", !isPassword);
      eyeClosed.classList.toggle("hidden", isPassword);
    });
  });
});
