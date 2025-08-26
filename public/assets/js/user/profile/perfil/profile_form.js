// profileForm.js
import { actualizarPerfil } from "./api.js";

function setBtnLoading(btn, text = "Guardando...") {
  if (!btn) return () => {};
  const original = btn.textContent;
  btn.disabled = true;
  btn.textContent = text;
  return () => { btn.disabled = false; btn.textContent = original; };
}

export function setupProfileForm(baseUrl, doc = document) {
  const form = doc.getElementById("form-perfil");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const btn = form.querySelector('button[type="submit"]');
    const restore = setBtnLoading(btn);

    try {
      const { ok, data } = await actualizarPerfil(baseUrl, formData);

      if (ok) {
        await Swal.fire({
          icon: "success",
          title: "¡Perfil actualizado!",
          text: data.message,
          timer: 1500,
          showConfirmButton: false,
        });
        window.location.assign(`${baseUrl}/user/home`);
      } else {
        await Swal.fire({
          icon: "error",
          title: "Error al actualizar",
          text: data?.message || "No se pudo actualizar el perfil",
        });
      }
    } catch (err) {
      await Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: "No se pudo conectar con el servidor",
      });
    } finally {
      restore();
    }
  });
}
