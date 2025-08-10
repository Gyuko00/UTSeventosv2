// eventos.js (tu archivo principal)
import { configurarEventListeners, limpiarFiltros } from "./filtros.js";
import {
  confirmarEliminacion,
  recargarEventos,
} from "../eliminar_evento/main.js";


document.addEventListener("DOMContentLoaded", () => {
  configurarEventListeners();
});

window.eliminarEvento = confirmarEliminacion;
window.limpiarFiltros = limpiarFiltros;
window.recargarEventos = recargarEventos;

// Debug final