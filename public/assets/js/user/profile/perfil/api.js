// api.js
export async function actualizarPerfil(baseUrl, formData) {
  const res = await fetch(`${baseUrl}/user/actualizarPerfil`, {
    method: "POST",
    body: formData,
    credentials: "same-origin",
  });
  let json;
  try {
    json = await res.json();
  } catch {
    throw new Error("Respuesta inválida del servidor");
  }
  return { ok: res.ok && json?.status === "success", data: json };
}

export async function cambiarContrasena(baseUrl, formData) {
  const res = await fetch(`${baseUrl}/user/cambiarContrasena`, {
    method: "POST",
    body: formData,
    credentials: "same-origin",
  });
  let json;
  try {
    json = await res.json();
  } catch {
    throw new Error("Respuesta inválida del servidor");
  }
  return {
    ok: res.ok && (json?.status === "success" || json?.status === "info"),
    data: json,
  };
}
