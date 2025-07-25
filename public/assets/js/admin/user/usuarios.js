import { configurarEventListeners, limpiarFiltros } from './filtros.js';
import { confirmarEliminacion, recargarUsuarios } from './acciones.js';

document.addEventListener("DOMContentLoaded", () => {
    configurarEventListeners();
});

window.confirmarEliminacion = confirmarEliminacion;
window.limpiarFiltros = limpiarFiltros;
window.recargarUsuarios = recargarUsuarios;
