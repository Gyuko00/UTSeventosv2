export function getRolClass(idRol) {
  const clases = {
    1: "bg-purple-100 text-purple-800",
    2: "bg-blue-100 text-blue-800",
    3: "bg-green-100 text-green-800",
    4: "bg-yellow-100 text-yellow-800",
  };
  return clases[idRol] || "bg-gray-100 text-gray-800";
}

export function getRolNombre(idRol) {
  const nombres = {
    1: "Administrador",
    2: "Ponente",
    3: "Invitado",
    4: "Control",
  };
  return nombres[idRol] || "Desconocido";
}

export function escapeHtml(text) {
  if (!text) return "";
  const div = document.createElement("div");
  div.textContent = text;
  return div.innerHTML;
}
