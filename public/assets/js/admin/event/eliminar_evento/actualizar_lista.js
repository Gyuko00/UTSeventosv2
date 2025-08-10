// eliminar_evento/actualizar_lista.js
import { actualizarTablaEventos } from "../home/tabla.js";

export async function recargarEventos() {
  try {
    const response = await fetch(window.location.href, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });

    const data = await response.json();

    if (data.status === "success") {
      actualizarTablaEventos(data.eventos);
    } else {
      window.location.reload();
    }
  } catch (error) {
    console.error("Error al recargar eventos:", error);
    window.location.reload();
  }
}
