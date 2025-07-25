import { limpiarErrores } from "./helpers.js"; 

export async function manejarSubmitFormulario(e) {
  e.preventDefault();
  limpiarErrores();

  const errores = validarFormulario();
  if (errores.length > 0) {
    mostrarErroresConSweetAlert(errores);
    return;
  }

  const form = e.target;
  const data = {
    person: {
      nombres: form.querySelector('[name="person[nombres]"]').value,
      apellidos: form.querySelector('[name="person[apellidos]"]').value,
      tipo_documento: form.querySelector('[name="person[tipo_documento]"]').value,
      numero_documento: form.querySelector('[name="person[numero_documento]"]').value,
      correo_personal: form.querySelector('[name="person[correo_personal]"]').value,
      telefono: form.querySelector('[name="person[telefono]"]').value,
      departamento: form.querySelector('[name="person[departamento]"]').value,
      municipio: form.querySelector('[name="person[municipio]"]').value,
      direccion: form.querySelector('[name="person[direccion]"]').value,
    },
    user: {
      usuario: form.querySelector('[name="user[usuario]"]').value,
      contrasenia: form.querySelector('[name="user[contrasenia]"]').value,
      id_rol: form.querySelector('[name="user[id_rol]"]').value,
    },
    roleSpecific: {
      tema: form.querySelector('[name="roleSpecific[tema]"]')?.value,
      descripcion_biografica: form.querySelector('[name="roleSpecific[descripcion_biografica]"]')?.value,
      especializacion: form.querySelector('[name="roleSpecific[especializacion]"]')?.value,
      institucion_ponente: form.querySelector('[name="roleSpecific[institucion_ponente]"]')?.value,
      tipo_invitado: form.querySelector('[name="roleSpecific[tipo_invitado]"]')?.value,
      correo_institucional: form.querySelector('[name="roleSpecific[correo_institucional]"]')?.value,
      programa_academico: form.querySelector('[name="roleSpecific[programa_academico]"]')?.value,
      nombre_carrera: form.querySelector('[name="roleSpecific[nombre_carrera]"]')?.value,
      jornada: form.querySelector('[name="roleSpecific[jornada]"]')?.value,
      facultad: form.querySelector('[name="roleSpecific[facultad]"]')?.value,
      cargo: form.querySelector('[name="roleSpecific[cargo]"]')?.value,
      sede_institucion: form.querySelector('[name="roleSpecific[sede_institucion]"]')?.value,
    },
  };

  try {
    console.log("📤 Enviando datos:", data);
    console.log("📍 URL destino:", form.action);

    const response = await fetch(form.action, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify(data),
    });

    console.log("📥 Status de respuesta:", response.status);
    console.log("📥 Headers de respuesta:", [...response.headers.entries()]);

    // Obtener el texto completo de la respuesta
    const responseText = await response.text();
    console.log("📥 Respuesta completa del servidor:");
    console.log(responseText);

    // Verificar si es HTML (error de PHP)
    if (responseText.trim().startsWith('<')) {
      console.error("❌ El servidor devolvió HTML en lugar de JSON");
      console.error("Contenido:", responseText.substring(0, 500) + "...");
      
      Swal.fire({
        icon: "error",
        title: "Error del servidor",
        text: "El servidor devolvió un error. Revisa la consola para más detalles.",
      });
      return;
    }

    // Intentar parsear como JSON
    let result;
    try {
      result = JSON.parse(responseText);
      console.log("✅ JSON parseado correctamente:", result);
    } catch (parseError) {
      console.error("❌ Error parseando JSON:", parseError);
      console.error("Respuesta recibida:", responseText);
      
      Swal.fire({
        icon: "error",
        title: "Error de formato",
        text: "La respuesta del servidor no es válida.",
      });
      return;
    }

    if (result.status === "error") {
      Swal.fire({ 
        icon: "error", 
        title: "Error", 
        text: result.message 
      });
      return;
    }

    await Swal.fire({
      icon: "success",
      title: "Usuario creado",
      text: "El usuario ha sido creado exitosamente",
    });
    
    window.location.href = result.redirect;

  } catch (error) {
    console.error("❌ Error en fetch:", error);
    Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor: " + error.message,
    });
  }
}

function validar(id, mensaje, errores, regex = null) {
  const val = document.getElementById(id).value.trim();
  if (!val || (regex && !regex.test(val))) {
    errores.push({ campo: id, mensaje });
  }
}

function validarFormulario() {
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
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/
  );
  validar(
    "apellidos",
    "Los apellidos deben tener entre 2 y 50 letras. No se permiten emojis ni caracteres especiales, tampoco debe tener espacios en blanco al inicio o al final.",
    errores,
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/
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
    !/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i
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
    !/^[a-zA-Z0-9_.-]{4,20}$/
  );
  validar(
    "contrasenia",
    "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos una letra mayúscula, una minúscula y un número. No se permiten emojis.",
    errores,
    !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/
  );

  const rol = document.getElementById("rol").value;
  if (!rol) errores.push({ campo: "rol", mensaje: "Debe seleccionar un rol" });

  if (rol === "2") validarCamposPonente(errores);
  if (rol === "3") validarCamposInvitado(errores);

  return errores;
}

function validarCamposPonente(errores) {
  validar(
    "tema",
    "El tema debe tener entre 0 y 100 caracteres",
    errores,
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,100}$/
  );
  validar(
    "descripcionBiografica",
    "La descripción biográfica debe tener entre 0 y 100 caracteres",
    errores,
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,100}$/
  );
  validar(
    "especializacion",
    "La especialización debe tener entre 0 y 70 caracteres",
    errores,
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,70}$/
  );
  validar(
    "institucionPonente",
    "La institución del ponente debe tener entre 0 y 70 caracteres",
    errores,
    !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,70}$/
  );
}

function validarCamposInvitado(errores) {
  validar("tipoInvitado", "Debe seleccionar un tipo de invitado", errores);
  validar(
    "correoInstitucional",
    "El correo institucional no tiene un formato válido",
    errores,
    !/^([\w.%+-]+)@([\w-]+\.)+[\w]{2,}$/i
  );
  validar("facultad", "Debe seleccionar una facultad", errores);
  validar(
    "sedeInstitucion",
    "Debe seleccionar una sede de institución",
    errores
  );

  const tipoInvitado = document.getElementById("tipoInvitado").value;
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

function mostrarErroresConSweetAlert(errores) {
  const listaErrores = errores.map((err) => `<li>${err.mensaje}</li>`).join("");
  Swal.fire({
    icon: "error",
    title: "Errores en el formulario",
    html: `<ul style="text-align:left">${listaErrores}</ul>`,
  });
}
