export function getEstadoEventoClass(fecha, horaInicio) {
  const ahora = new Date();
  const fechaEvento = new Date(fecha + "T" + horaInicio);

  if (fechaEvento > ahora) {
    return "bg-green-100 text-green-800";
  } else if (fechaEvento.toDateString() === ahora.toDateString()) {
    return "bg-yellow-100 text-yellow-800";
  } else {
    return "bg-red-100 text-red-800";
  }
}

export function getEstadoEventoNombre(fecha, horaInicio) {
  const ahora = new Date();
  const fechaEvento = new Date(fecha + "T" + horaInicio);

  if (fechaEvento > ahora) {
    return "Próximo";
  } else if (fechaEvento.toDateString() === ahora.toDateString()) {
    return "Hoy";
  } else {
    return "Finalizado";
  }
}

export function formatearFecha(fecha) {
  const fechaObj = new Date(fecha);
  return fechaObj.toLocaleDateString("es-ES", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  });
}

export function formatearHora(hora) {
  return hora.substring(0, 5);
}

export function escapeHtml(text) {
  if (!text) return "";
  const div = document.createElement("div");
  div.textContent = text;
  return div.innerHTML;
}
