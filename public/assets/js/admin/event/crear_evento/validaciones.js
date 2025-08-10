// validaciones.js
export function resaltarError(elemento) {
  if (elemento) {
    elemento.classList.add("border-red-500");
    elemento.addEventListener("input", function () {
      if (this.value.trim()) {
        this.classList.remove("border-red-500");
      }
    });
  }
}

export function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}

export function mostrarError(mensaje) {
  const errorDiv = document.createElement("div");
  errorDiv.className =
    "error-message bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4";
  errorDiv.innerHTML = `<p>${mensaje}</p>`;

  const form = document.getElementById("crearEventoForm");
  if (form) {
    form.insertBefore(errorDiv, form.firstChild);
    errorDiv.scrollIntoView({ behavior: "smooth" });
  }
}

export function mostrarErrores(errores) {
  if (errores.length === 0) return;

  const errorDiv = document.createElement("div");
  errorDiv.className =
    "error-message bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4";
  errorDiv.innerHTML = `
        <p class="font-bold">Errores encontrados:</p>
        <ul class="list-disc pl-5 mt-2">
            ${errores.map((error) => `<li>${error}</li>`).join("")}
        </ul>
    `;

  const form = document.getElementById("crearEventoForm");
  if (form) {
    form.insertBefore(errorDiv, form.firstChild);
    errorDiv.scrollIntoView({ behavior: "smooth" });
  }
}
