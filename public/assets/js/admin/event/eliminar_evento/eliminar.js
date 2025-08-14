// eliminar_evento/eliminar.js
export async function eliminarEvento(idEvento) {

  Swal.fire({
    title: "Eliminando evento...",
    text: "Por favor espera",
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading(),
  });

  try {
    const url = `${window.location.origin}/utseventos/public/admin/eliminarEvento/${idEvento}`;
    const payload = { id_evento: parseInt(idEvento) };

    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(payload),
    });

    const responseText = await response.text();
    
    Swal.close();

    let resultado;
    try {
      resultado = JSON.parse(responseText);
    } catch (parseError) {
      
      await Swal.fire({
        icon: "error",
        title: "Error de respuesta",
        text: "El servidor no devolvió una respuesta válida",
        confirmButtonColor: "#d33",
        footer: `<small>Debug: ${responseText.substring(0, 100)}...</small>`
      });
      return;
    }

    if (resultado.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "Evento eliminado",
        text: resultado.message,
        confirmButtonColor: "#3085d6",
        timer: 2500,
        timerProgressBar: true,
      });
      window.location.reload();
    } else {
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: resultado.message || "Error al eliminar el evento",
        confirmButtonColor: "#d33",
      });
    }
  } catch (error) {
    Swal.close();
    
    Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: `No se pudo conectar con el servidor: ${error.message}`,
      confirmButtonColor: "#d33",
      footer: `<small>Tipo de error: ${error.name}</small>`
    });
  }
}