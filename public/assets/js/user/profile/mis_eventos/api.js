// api.js
export async function fetchMisEventos(baseUrl) {
    const res = await fetch(`${baseUrl}/user/obtenerMisEventos`, {
      method: "GET",
      credentials: "same-origin",
      headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
    });
  
    if (!res.ok) {
      throw new Error(`Error ${res.status}: No se pudo cargar la información`);
    }
  
    let payload;
    try {
      payload = await res.json();
    } catch {
      throw new Error("La respuesta del servidor no es JSON válido");
    }
  
    if (payload.status !== "success") {
      throw new Error(payload.message || "Error al cargar los eventos");
    }
  
    return payload.data;
  }
  