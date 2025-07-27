/**
 * SCRIPT DE AUTENTICACIÓN Y ACCESO DE USUARIOS
 * 
 * Controla el formulario de inicio de sesión con validaciones básicas
 * y manejo de visibilidad de contraseñas. Incluye autenticación
 * asíncrona y redirección basada en roles de usuario.
 * 
 * Funcionalidades incluidas:
 * - Toggle de visibilidad de contraseña con iconos
 * - Validación de usuario y contraseña
 * - Autenticación asíncrona con manejo de errores
 * - Sistema de redirección por roles (Admin, Speaker, Usuario)
 * - Integración con SweetAlert2 para notificaciones
 * 
 * Elementos requeridos:
 * - Formulario con ID 'loginForm'
 * - Campo de contraseña con ID 'contrasenia'
 * - Botón toggle con ID 'togglePassword'
 * - Iconos de ojo con IDs 'eyeOpen' y 'eyeClosed'
 * - Librería SweetAlert2 para alertas
 * 
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  if (!form) return;

  const passwordInput = document.getElementById("contrasenia");
  const toggleBtn = document.getElementById("togglePassword");
  const eyeOpen = document.getElementById("eyeOpen");
  const eyeClosed = document.getElementById("eyeClosed");

  toggleBtn.addEventListener("click", () => {
    const isPassword = passwordInput.getAttribute("type") === "password";
    passwordInput.setAttribute("type", isPassword ? "text" : "password");
    eyeOpen.classList.toggle("hidden", !isPassword);
    eyeClosed.classList.toggle("hidden", isPassword);
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const errors = [];
    const getValue = (name) =>
      form.querySelector(`[name="${name}"]`)?.value.trim() || "";

    const username = getValue("usuario");
    if (!/^[a-zA-Z0-9_.-]{4,20}$/.test(username)) {
      errors.push(
        "El usuario debe tener entre 4 y 20 caracteres alfanuméricos. Puede incluir guiones, puntos y guiones bajos."
      );
    }

    const password = getValue("contrasenia");
    if (!password || password.length < 6) {
      errors.push("La contraseña debe tener mínimo 6 caracteres.");
    }

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
        console.log("Respuesta del servidor:", text);
        result = JSON.parse(text);
      } catch {
        throw new Error("Respuesta no es JSON válida");
      }
      console.log(result);

      if (result.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "Bienvenido",
          text: result.message,
          confirmButtonColor: "#3085d6",
        });

        let redirectUrl = "/utseventos/public/auth/login";
        console.log(parseInt(result.id_rol))
        switch (parseInt(result.id_rol)) {
          case 1:
            redirectUrl = "/utseventos/public/admin/home";
            break;
          case 2:
            redirectUrl = "/utseventos/public/speakers/home";
            break;
          case 3:
            redirectUrl = "/utseventos/public/user/home";
            break;
          default:
            redirectUrl = "/utseventos/public/auth/login";
        }

        window.location.href = redirectUrl;
      } else {
        let alertConfig = {
          icon: "error",
          title: "Error",
          text: result.message || "Credenciales inválidas.",
          confirmButtonColor: "#d33",
        };

        switch (result.code) {
          case 'USER_INACTIVE':
            alertConfig = {
              icon: "warning",
              title: "Cuenta Desactivada",
              text: result.message,
              confirmButtonColor: "#f39c12",
              footer: '<span style="color: #666;">Si crees que esto es un error, contacta al administrador.</span>'
            };
            break;
          
          case 'USER_NOT_FOUND':
            alertConfig = {
              icon: "error",
              title: "Usuario No Encontrado",
              text: result.message,
              confirmButtonColor: "#d33"
            };
            break;
          
          case 'INVALID_PASSWORD':
            alertConfig = {
              icon: "error",
              title: "Contraseña Incorrecta",
              text: result.message,
              confirmButtonColor: "#d33"
            };
            break;
          
          case 'EMPTY_FIELDS':
            alertConfig = {
              icon: "info",
              title: "Campos Requeridos",
              text: result.message,
              confirmButtonColor: "#3085d6"
            };
            break;
        }

        Swal.fire(alertConfig);
      }
    } catch (err) {
      console.error("Error en fetch:", err);
      Swal.fire({
        icon: "error",
        title: "Error de red",
        text: "No se pudo conectar con el servidor.",
        confirmButtonColor: "#d33",
      });
    }
  });
});
