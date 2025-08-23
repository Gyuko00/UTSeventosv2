import { actualizarTablaUsuarios } from "../home/tabla.js";

export async function recargarUsuarios() {
  try {
    const response = await fetch(window.location.href, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });

    const data = await response.json();

    if (data.status === "success") {
      actualizarTablaUsuarios(data.usuarios);
    } else {
      window.location.reload();
    }
  } catch (error) {
    window.location.reload();
  }
}
