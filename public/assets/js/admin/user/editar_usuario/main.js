import { limpiarErrores } from "./helpers.js";
import {
  configurarEventListenersEditar,
  configurarCamposDinamicosEditar,
} from "./campos_dinamicos.js";
import {
  validarFormulario,
  mostrarErroresConSweetAlert,
} from "./validaciones.js";
import { configurarActivarUsuario } from "./activar_usuario.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("editarUsuarioForm");
  if (!form) return;

  configurarActivarUsuario();
  configurarEventListenersEditar();
  configurarCamposDinamicosEditar();

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

  const getValue = (selector) => {
    const el = form.querySelector(selector);
    return el ? el.value : null;
  };

  const data = {
    person: {
      nombres: getValue('[name="person[nombres]"]'),
      apellidos: getValue('[name="person[apellidos]"]'),
      tipo_documento: getValue('[name="person[tipo_documento]"]'),
      numero_documento: getValue('[name="person[numero_documento]"]'),
      correo_personal: getValue('[name="person[correo_personal]"]'),
      telefono: getValue('[name="person[telefono]"]'),
      departamento: getValue('[name="person[departamento]"]'),
      municipio: getValue('[name="person[municipio]"]'),
      direccion: getValue('[name="person[direccion]"]'),
    },
    user: {
      usuario: getValue('[name="user[usuario]"]'),
      contrasenia: getValue('[name="user[contrasenia]"]'),
      id_rol: getValue('[name="user[id_rol]"]'),
    },
    roleSpecific: {
      tema: getValue('[name="roleSpecific[tema]"]'),
      descripcion_biografica: getValue(
        '[name="roleSpecific[descripcion_biografica]"]'
      ),
      especializacion: getValue('[name="roleSpecific[especializacion]"]'),
      institucion_ponente: getValue(
        '[name="roleSpecific[institucion_ponente]"]'
      ),
      tipo_invitado: getValue('[name="roleSpecific[tipo_invitado]"]'),
      correo_institucional: getValue(
        '[name="roleSpecific[correo_institucional]"]'
      ),
      programa_academico: getValue('[name="roleSpecific[programa_academico]"]'),
      nombre_carrera: getValue('[name="roleSpecific[nombre_carrera]"]'),
      jornada: getValue('[name="roleSpecific[jornada]"]'),
      facultad: getValue('[name="roleSpecific[facultad]"]'),
      cargo: getValue('[name="roleSpecific[cargo]"]'),
      sede_institucion: getValue('[name="roleSpecific[sede_institucion]"]'),
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

    console.log("📨 Enviando datos:", data);
    console.log("📥 Respuesta cruda del servidor:", responseText);
    console.log("📋 Status HTTP:", response.status);

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

    if (data.status === "error") {
      if (data.code === "ROLE_CHANGE_BLOCKED") {
        mostrarAlerta("⚠️ No se puede cambiar el rol", data.message, "warning");
        document.getElementById("id_rol").value = valorRolOriginal;
      } else if (
        data.code === "MISSING_GUEST_FIELDS" ||
        data.code === "MISSING_SPEAKER_FIELDS"
      ) {
        mostrarAlerta("❌ Campos requeridos faltantes", data.message, "error");
      } else {
        mostrarAlerta("❌ Error", data.message, "error");
      }
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
      title: "Usuario actualizado",
      text: "Los datos del usuario han sido actualizados exitosamente",
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
