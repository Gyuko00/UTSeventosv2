// campos_dinamicos.js
export function configurarValidaciones() {
  const fechaEvento = document.getElementById("fecha");
  const horaInicio = document.getElementById("hora_inicio");
  const horaFin = document.getElementById("hora_fin");
  const cupoMaximo = document.getElementById("cupo_maximo");

  if (fechaEvento) {
    const today = new Date().toISOString().split("T")[0];
    fechaEvento.min = today;
  }

  if (horaInicio && horaFin) {
    horaInicio.addEventListener("change", validarHorarios);
    horaFin.addEventListener("change", validarHorarios);
  }

  if (cupoMaximo) {
    cupoMaximo.addEventListener("input", function () {
      const valor = parseInt(this.value);
      if (valor < 1) this.value = 1;
      if (valor > 9999) this.value = 9999;
    });
  }
}

export function validarHorarios() {
  const horaInicio = document.getElementById("hora_inicio");
  const horaFin = document.getElementById("hora_fin");

  if (horaInicio.value && horaFin.value) {
    const inicio = new Date(`2000-01-01T${horaInicio.value}`);
    const fin = new Date(`2000-01-01T${horaFin.value}`);

    if (fin <= inicio) {
      mostrarError(
        "La hora de finalización debe ser posterior a la hora de inicio."
      );
      horaFin.value = "";
      return false;
    }
  }
  return true;
}

function mostrarError(mensaje) {
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
