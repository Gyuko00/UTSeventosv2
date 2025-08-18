// assets/js/admin/event/home/filtros.js
import { SELECTORS, getUrlPath } from './filtros/filtros.config.js';
import { aplicarFiltrosEventos, limpiarFiltrosEventos } from './filtros/filtros.core.js';

const el = (id) => document.getElementById(id);

function bindFilter(id) {
  const node = el(id);
  if (!node) return;
  node.addEventListener('input', aplicarFiltrosEventos);
  node.addEventListener('change', aplicarFiltrosEventos);
}

function setupFilters() {
  [
    SELECTORS.buscar,
    SELECTORS.fecha,
    SELECTORS.institucion,
    SELECTORS.departamento,
    SELECTORS.municipio,
    SELECTORS.tema,
    SELECTORS.capacidad,
    SELECTORS.horario
  ].forEach(bindFilter);
}

function setupNavigation() {
  const btnCal = el(SELECTORS.btnCalendario);
  if (!btnCal) return;
  btnCal.addEventListener('click', () => {
    const base = getUrlPath();
    const url = (base ? base : '') + '/admin/eventos/calendario';
    window.location.href = url;
  });
}

function exposeAPI() {
  window.aplicarFiltrosEventos = aplicarFiltrosEventos;
  window.limpiarFiltrosEventos = limpiarFiltrosEventos;
}

function start() {
  setupFilters();
  setupNavigation();
  exposeAPI();
  aplicarFiltrosEventos();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', start);
} else {
  start();
}
