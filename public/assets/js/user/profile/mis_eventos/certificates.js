// certificates.js
export function attachCertificateHandler(doc = document, baseUrl = URL_PATH) {
  const handler = async (e) => {
    if (!e.target.classList.contains("certificado-btn")) return;
    e.preventDefault();
    await descargarCertificado(e.target, baseUrl);
  };

  doc.addEventListener("click", handler);
  return () => doc.removeEventListener("click", handler); // para limpiar si algún día lo necesitas
}

export async function descargarCertificado(button, baseUrl) {
  const eventoId = button.dataset.eventoId;
  const token = button.dataset.token;

  if (!eventoId || !token) return;

  const original = button.innerHTML;
  button.innerHTML = "⏳ Descargando...";
  button.disabled = true;

  try {
    const link = document.createElement("a");
    link.href = `${baseUrl}/user/descargarCertificado?evento=${eventoId}&token=${token}`;
    link.target = "_blank";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch {
    // silencioso
  } finally {
    setTimeout(() => {
      button.innerHTML = original;
      button.disabled = false;
    }, 2000);
  }
}
