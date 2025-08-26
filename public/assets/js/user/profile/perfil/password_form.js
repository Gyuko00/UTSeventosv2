// passwordForm.js
import { cambiarContrasena } from "./api.js";
import { validatePasswordFields, attachLivePasswordValidation } from "./validators.js";

const spinner = `
  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
  </svg>`;

function setBtnBusy(btn, label = "Cambiando...") {
  if (!btn) return () => {};
  const original = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = `${spinner} ${label}`;
  return () => { btn.disabled = false; btn.innerHTML = original; };
}

export function setupPasswordForm(baseUrl, doc = document) {
  const form = doc.getElementById("form-contrasena");
  if (!form) return;

  attachLivePasswordValidation(doc);

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const actual = doc.getElementById("contrasena_actual")?.value;
    const nueva  = doc.getElementById("nueva_contrasena")?.value;
    const conf   = doc.getElementById("confirmar_contrasena")?.value;

    const v = validatePasswordFields(actual, nueva, conf);
    if (!v.ok) {
      await Swal.fire({
        icon: v.type || "error",
        title: v.type === "warning" ? "Atención" : (v.type === "info" ? "Sin cambios" : "Error"),
        text: v.msg,
        timer: v.type === "info" ? 2500 : undefined,
        showConfirmButton: v.type !== "info",
      });
      if (v.focus) doc.getElementById(v.focus)?.focus();
      if (v.type === "info") form.reset();
      return;
    }

    const formData = new FormData(form);
    const btn = form.querySelector('button[type="submit"]');
    const restore = setBtnBusy(btn);

    try {
      const { ok, data } = await cambiarContrasena(baseUrl, formData);

      if (data?.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "¡Excelente!",
          text: data.message,
          timer: 3000,
          showConfirmButton: false,
        });
        form.reset();
        doc.getElementById("contrasena_actual")?.focus();
      } else if (data?.status === "info") {
        await Swal.fire({
          icon: "info",
          title: "Sin cambios",
          text: data.message,
          timer: 2500,
          showConfirmButton: false,
        });
      } else {
        await Swal.fire({
          icon: "error",
          title: "Error",
          text: data?.message || "No se pudo cambiar la contraseña",
        });
        if (data?.message?.toLowerCase().includes("contraseña actual")) {
          doc.getElementById("contrasena_actual")?.focus();
        }
      }
    } catch {
      await Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: "No se pudo conectar con el servidor. Verifica tu conexión.",
      });
    } finally {
      restore();
    }
  });
}
