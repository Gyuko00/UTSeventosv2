// api.js (crear) – alineado con editar, sin JSON, usando FormData

function safeParseJSON(text) {
  try {
    return JSON.parse(text);
  } catch (e) {
    return null;
  }
}


import { mostrarLoading } from "./helpers.js";

export async function manejarSubmitEvento(e) {
  e.preventDefault();
  limpiarErrores();
  mostrarLoading(true);

  const form = e.target;
  const formData = new FormData(form);

  const cleanFormData = new FormData();
  const processed = new Set();
  for (let [key, value] of formData.entries()) {
    if (processed.has(key)) continue;
    cleanFormData.append(key, value);
    processed.add(key);
  }

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: cleanFormData,
    });

    const responseText = await response.text();

    const ct = response.headers.get('content-type') || '';

    if (response.redirected || ct.includes('text/html') || responseText.trim().startsWith('<')) {
      const maybeLogin = /<form[^>]*login|iniciar sesi[oó]n|usuario/i.test(responseText);
      const hint = maybeLogin ? ' (posible redirección a login / sesión inválida)' : '';
      throw new Error(`El servidor devolvió una respuesta HTML inesperada${hint}.`);
    }

    const data = safeParseJSON(responseText);
    if (!data) {
      throw new Error('La respuesta del servidor no es JSON válido.');
    }

    if (data.status === 'error') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.message || 'Ocurrió un error al crear el evento.',
      });
      return;
    }

    await Swal.fire({
      icon: 'success',
      title: 'Evento creado',
      text: data.message || 'El evento fue creado exitosamente',
    });

    window.location.href = data.redirect || (URL_PATH + '/admin/listarEventos');
  } catch (error) {
    const extra = '';

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: (error.message || 'No se pudo completar la solicitud.') + extra,
    });
  } finally {
    mostrarLoading(false);
  }
}


function limpiarErrores() {
  document.querySelectorAll(".error-message").forEach((el) => el.remove());
  document
    .querySelectorAll(".border-red-500")
    .forEach((el) => el.classList.remove("border-red-500"));
}
