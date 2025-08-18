// filtros.config.js
// Config y utilidades ligeras para el módulo de filtros

export const SELECTORS = {
  // Inputs de filtros
  buscar: "buscarEvento",
  fecha: "filtroFecha",
  institucion: "filtroInstitucion",
  departamento: "filtroDepartamento",
  municipio: "filtroMunicipio",
  tema: "filtroTema",
  capacidad: "filtroCapacidad",
  horario: "filtroHorario",

  // Tabla y contador
  tabla: "tablaEventos",
  contador: "contadorResultados",

  // Navegación
  btnCalendario: "vistaCalendario",
};

// Rangos de capacidad (inclusive) para el filtro
export const CAP_RANGOS = {
  pequeno: { min: 0, max: 50 },
  mediano: { min: 51, max: 150 },
  grande: { min: 151, max: 500 },
  masivo: { min: 500, max: Infinity },
};

// Obtiene la base URL del sistema si se inyectó en la vista
export function getUrlPath() {
  const base =
    typeof window !== "undefined" && typeof window.URL_PATH === "string"
      ? window.URL_PATH
      : "";
  return base.replace(/\/+$/, "");
}
