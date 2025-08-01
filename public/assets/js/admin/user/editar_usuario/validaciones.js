export function validar(id, mensaje, errores, regex = null) {
  const element = document.getElementById(id);
  if (!element) return;

  const val = element.value.trim();
  if (!val || (regex && !regex.test(val))) {
    errores.push({ campo: id, mensaje });
  }
}

export function validarFormulario() {
  const errores = [];

  validar("tipoDocumento", "Debe seleccionar un tipo de documento", errores);
  validar(
    "numeroDocumento",
    "El número de documento debe tener entre 5 y 10 dígitos",
    errores,
    /^\d{5,10}$/
  );
  validar(
    "nombres",
    "Los nombres deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/
  );
  validar(
    "apellidos",
    "Los apellidos deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/
  );
  validar(
    "telefono",
    "El teléfono debe contener solo números (entre 7 y 13 dígitos).",
    errores,
    /^\d{7,13}$/
  );
  validar(
    "correoPersonal",
    "El correo personal no tiene un formato válido",
    errores,
    /^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i
  );
  validar("departamento", "Debe seleccionar un departamento", errores);
  validar("municipio", "Debe seleccionar un municipio", errores);
  validar(
    "direccion",
    "La dirección debe tener entre 5 y 100 caracteres, sin emojis.",
    errores,
    /^.{5,100}$/
  );

  validar(
    "usuario",
    "El nombre de usuario debe tener entre 4 y 20 caracteres. Solo se permiten letras, números, guiones, puntos y guiones bajos.",
    errores,
    /^[a-zA-Z0-9_.-]{4,20}$/
  );

  const contrasenia = document.getElementById("contrasenia");
  if (contrasenia && contrasenia.value.trim()) {
    validar(
      "contrasenia",
      "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos una letra mayúscula, una minúscula y un número. No se permiten emojis.",
      errores,
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/
    );
  }

  const rol = document.getElementById("id_rol").value;
  if (!rol) errores.push({ campo: "id_rol", mensaje: "Debe seleccionar un rol" });

  if (rol === "2") validarCamposPonente(errores);
  if (rol === "3") validarCamposInvitado(errores);

  return errores;
}

export function validarCamposPonente(errores) {
  validar(
    "tema",
    "El tema debe tener entre 0 y 100 caracteres",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,100}$/
  );
  validar(
    "descripcionBiografica",
    "La descripción biográfica debe tener entre 0 y 100 caracteres",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,100}$/
  );
  validar(
    "especializacion",
    "La especialización debe tener entre 0 y 70 caracteres",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,70}$/
  );
  validar(
    "institucionPonente",
    "La institución del ponente debe tener entre 0 y 70 caracteres",
    errores,
    /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,70}$/
  );
}

export function validarCamposInvitado(errores) {
  validar("tipoInvitado", "Debe seleccionar un tipo de invitado", errores);
  validar(
    "correoInstitucional",
    "El correo institucional no tiene un formato válido",
    errores,
    /^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i
  );
  validar("facultad", "Debe seleccionar una facultad", errores);
  validar(
    "sedeInstitucion",
    "Debe seleccionar una sede de institución",
    errores
  );

  const tipoInvitado = document.getElementById("tipoInvitado")?.value;
  if (tipoInvitado === "1") {
    validar(
      "programaAcademico",
      "Debe seleccionar un programa académico",
      errores
    );
    validar("nombreCarrera", "Debe seleccionar un nombre de carrera", errores);
    validar("jornada", "Debe seleccionar una jornada", errores);
  }
  if (tipoInvitado === "2") {
    validar(
      "programaAcademico",
      "Debe seleccionar un programa académico",
      errores
    );
    validar("nombreCarrera", "Debe seleccionar un nombre de carrera", errores);
    validar("cargo", "Debe seleccionar un cargo", errores);
  }
  if (tipoInvitado === "3") {
    validar("cargo", "Debe seleccionar un cargo", errores);
  }
}

export function mostrarErroresConSweetAlert(errores) {
  const mensajes = errores.map((error) => error.mensaje).join("\n");

  Swal.fire({
    icon: "error",
    title: "Errores de validación",
    text: mensajes,
    confirmButtonText: "Entendido",
  });

  if (errores.length > 0) {
    const primerCampo = document.getElementById(errores[0].campo);
    if (primerCampo) {
      primerCampo.focus();
      primerCampo.scrollIntoView({ behavior: "smooth", block: "center" });
    }
  }
}
