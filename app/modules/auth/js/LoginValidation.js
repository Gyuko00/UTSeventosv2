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

    const errores = [];

    const getValue = (name) =>
      form.querySelector(`[name="${name}"]`)?.value.trim() || "";

    const usuario = getValue("usuario");
    if (!/^[a-zA-Z0-9_.-]{4,20}$/.test(usuario)) {
      errores.push(
        "El usuario debe tener entre 4 y 20 caracteres alfanuméricos. Puede incluir guiones, puntos y guiones bajos."
      );
    }

    const contrasenia = getValue("contrasenia");
    if (!contrasenia || contrasenia.length < 6) {
      errores.push("La contraseña debe tener mínimo 6 caracteres.");
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
        throw new Error("Respuesta no es JSON válida");
      }

      if (result.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Bienvenido",
          text: result.message,
          confirmButtonColor: "#3085d6",
        }).then(() => {
          let redirectUrl = "/";
          switch (parseInt(result.rol)) {
            case 1: redirectUrl = "/utseventos/admin/home"; break;
            case 2: redirectUrl = "/utseventos/speakers/home"; break;
            case 3: redirectUrl = "/utseventos/user/home"; break;
            default: redirectUrl = "/"; break;
          }
          window.location.href = redirectUrl;
        });
      }
      else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result.message || "Credenciales inválidas.",
          confirmButtonColor: "#d33",
        });
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
