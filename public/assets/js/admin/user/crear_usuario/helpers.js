export function limpiarErrores() {
  const errores = document.querySelectorAll('[id^="error-"]');
  errores.forEach((error) => {
    error.textContent = "";
    error.classList.add("hidden");
  });

  const inputs = document.querySelectorAll("input, select, textarea");
  inputs.forEach((input) => {
    input.classList.remove(
      "border-red-500",
      "focus:ring-red-500",
      "focus:border-red-500"
    );
    input.classList.add(
      "border-gray-300",
      "focus:ring-blue-500",
      "focus:border-blue-500"
    );
  });
}

export function mostrarErrores(errores) {
  errores.forEach((error) => {
    const errorElement = document.getElementById(`error-${error.campo}`);
    const inputElement = document.getElementById(error.campo);

    if (errorElement) {
      errorElement.textContent = error.mensaje;
      errorElement.classList.remove("hidden");
    }

    if (inputElement) {
      inputElement.classList.remove(
        "border-gray-300",
        "focus:ring-blue-500",
        "focus:border-blue-500"
      );
      inputElement.classList.add(
        "border-red-500",
        "focus:ring-red-500",
        "focus:border-red-500"
      );
    }
  });

  if (errores.length > 0) {
    const primerError = document.getElementById(errores[0].campo);
    if (primerError) {
      primerError.scrollIntoView({ behavior: "smooth", block: "center" });
      primerError.focus();
    }
  }
}

export function limpiarCamposEspecificos() {
  const ponenteFields = [
    "tema",
    "descripcionBiografica",
    "especializacion",
    "institucionPonente",
  ];
  const invitadoFields = [
    "tipoInvitado",
    "correoInstitucional",
    "programaAcademico",
    "nombreCarrera",
    "jornada",
    "facultad",
    "cargo",
    "sedeInstitucion",
  ];

  [...ponenteFields, ...invitadoFields].forEach((campo) => {
    const el = document.getElementById(campo);
    if (el) {
      el.value = "";
      el.required = false;
    }
  });
}

export function establecerRequeridosCamposPonente(requerido) {
  [
    "tema",
    "descripcionBiografica",
    "especializacion",
    "institucionPonente",
  ].forEach((campo) => {
    const el = document.getElementById(campo);
    if (el) el.required = requerido;
  });
}

export function establecerRequeridosCamposInvitado(requerido) {
  const el = document.getElementById("tipoInvitado");
  if (el) el.required = requerido;
}
