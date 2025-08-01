import {
  configurarEventListeners,
  configurarCamposDinamicos,
} from "./campos_dinamicos.js";
import { limpiarErrores } from "./helpers.js";
import {
  validarFormulario,
  mostrarErroresConSweetAlert,
} from "./validaciones.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("crearUsuarioForm");
  if (!form) return;

  configurarEventListeners();
  configurarCamposDinamicos();

  form.addEventListener("submit", manejarSubmitFormulario);
});

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
      tipo_documento: form.querySelector('[name="person[tipo_documento]"]')
        .value,
      numero_documento: form.querySelector('[name="person[numero_documento]"]')
        .value,
      correo_personal: form.querySelector('[name="person[correo_personal]"]')
        .value,
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
      descripcion_biografica: form.querySelector(
        '[name="roleSpecific[descripcion_biografica]"]'
      )?.value,
      especializacion: form.querySelector(
        '[name="roleSpecific[especializacion]"]'
      )?.value,
      institucion_ponente: form.querySelector(
        '[name="roleSpecific[institucion_ponente]"]'
      )?.value,
      tipo_invitado: form.querySelector('[name="roleSpecific[tipo_invitado]"]')
        ?.value,
      correo_institucional: form.querySelector(
        '[name="roleSpecific[correo_institucional]"]'
      )?.value,
      programa_academico: form.querySelector(
        '[name="roleSpecific[programa_academico]"]'
      )?.value,
      nombre_carrera: form.querySelector(
        '[name="roleSpecific[nombre_carrera]"]'
      )?.value,
      jornada: form.querySelector('[name="roleSpecific[jornada]"]')?.value,
      facultad: form.querySelector('[name="roleSpecific[facultad]"]')?.value,
      cargo: form.querySelector('[name="roleSpecific[cargo]"]')?.value,
      sede_institucion: form.querySelector(
        '[name="roleSpecific[sede_institucion]"]'
      )?.value,
    },
  };

  try {
    const response = await fetch(form.action, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify(data),
    });

    const responseText = await response.text();
    if (responseText.trim().startsWith("<")) {
      Swal.fire({
        icon: "error",
        title: "Error del servidor",
        text: "El servidor devolvió un error. Revisa la consola para más detalles.",
      });
      return;
    }
    let result;
    try {
      result = JSON.parse(responseText);
    } catch (parseError) {
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
        text: result.message,
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
    Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor: " + error.message,
    });
  }
}
