// filtros.config.js

export const SELECTORS = {
  buscar: "buscarEvento",
  fecha: "filtroFecha",
  institucion: "filtroInstitucion",
  departamento: "filtroDepartamento",
  municipio: "filtroMunicipio",
  tema: "filtroTema",
  capacidad: "filtroCapacidad",
  horario: "filtroHorario",

  tabla: "tablaEventos",
  contador: "contadorResultados",

  btnCalendario: "vistaCalendario",
};

export const CAP_RANGOS = {
  pequeno: { min: 0, max: 50 },
  mediano: { min: 51, max: 150 },
  grande: { min: 151, max: 500 },
  masivo: { min: 500, max: Infinity },
};

export function getUrlPath() {
  const base =
    typeof window !== "undefined" && typeof window.URL_PATH === "string"
      ? window.URL_PATH
      : "";
  return base.replace(/\/+$/, "");
}
