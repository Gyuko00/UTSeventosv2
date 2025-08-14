export function limpiarErrores() {
  const campos = document.querySelectorAll(".border-red-500, .text-red-500");
  campos.forEach((campo) => {
    campo.classList.remove("border-red-500", "text-red-500");
    campo.classList.add("border-gray-300");
  });

  const mensajesError = document.querySelectorAll(".error-message");
  mensajesError.forEach((mensaje) => mensaje.remove());
}

export function mostrarErrorEnCampo(campoId, mensaje) {
  const campo = document.getElementById(campoId);
  if (!campo) return;

  campo.classList.add("border-red-500");
  campo.classList.remove("border-gray-300");

  let mensajeError = campo.parentNode.querySelector(".error-message");
  if (!mensajeError) {
    mensajeError = document.createElement("p");
    mensajeError.className = "error-message text-red-500 text-sm mt-1";
    campo.parentNode.appendChild(mensajeError);
  }
  mensajeError.textContent = mensaje;
}

export function formatearNombreCompleto(nombres, apellidos) {
  return `${nombres.trim()} ${apellidos.trim()}`;
}

export function validarFormatoEmail(email) {
  const regex = /^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i;
  return regex.test(email);
}

export function capitalizarTexto(texto) {
  return texto.toLowerCase().replace(/\b\w/g, (letra) => letra.toUpperCase());
}

export function limpiarEspacios(texto) {
  return texto.trim().replace(/\s+/g, " ");
}

export function obtenerValorCampo(selector) {
  const campo = document.querySelector(selector);
  return campo ? campo.value.trim() : "";
}

export function establecerValorCampo(selector, valor) {
  const campo = document.querySelector(selector);
  if (campo) {
    campo.value = valor;
  }
}

export function alternarVisibilidad(elementId, mostrar) {
  const elemento = document.getElementById(elementId);
  if (elemento) {
    if (mostrar) {
      elemento.classList.remove("hidden");
    } else {
      elemento.classList.add("hidden");
    }
  }
}

export function alternarEstadoCampo(campoId, desactivar) {
  const campo = document.getElementById(campoId);
  if (campo) {
    campo.disabled = desactivar;
    if (desactivar) {
      campo.classList.add("bg-gray-100", "cursor-not-allowed");
    } else {
      campo.classList.remove("bg-gray-100", "cursor-not-allowed");
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
      if (campo === 'nombreCarrera') {
        el.dataset.valorSeleccionado = '';
        el.innerHTML = '<option value="">Seleccionar carrera</option>';
      }
    }
  });
  
}

export function limpiarCamposInvitado() {
  const campos = [
    'tipoInvitado',
    'correoInstitucional',
    'programaAcademico',
    'nombreCarrera',
    'jornada',
    'facultad',
    'cargo',
    'sedeInstitucion'
  ];

  campos.forEach(campo => {
    const elemento = document.getElementById(campo);
    if (elemento) {
      elemento.value = '';
      if (campo === 'nombreCarrera') {
        elemento.dataset.valorSeleccionado = '';
        elemento.innerHTML = '<option value="">Seleccionar carrera</option>';
      }
    }
  });

}

export function limpiarCamposPonente() {
  const camposPonente = [
    'tema',
    'descripcionBiografica',
    'especializacion',
    'institucionPonente'
  ];

  camposPonente.forEach(campo => {
    const elemento = document.getElementById(campo);
    if (elemento) {
      elemento.value = '';
    }
  });

}

export function limpiarCamposInvitadoEspecificos() {
  const campos = [
    'correoInstitucional',
    'programaAcademico', 
    'nombreCarrera',
    'jornada',
    'cargo'
  ];

  campos.forEach(campo => {
    const elemento = document.getElementById(campo);
    if (elemento) {
      elemento.value = '';
      if (campo === 'nombreCarrera') {
        elemento.dataset.valorSeleccionado = '';
        elemento.innerHTML = '<option value="">Seleccionar carrera</option>';
      }
    }
  });
  
}