// assets/js/admin/event/home/eventos.js
import './filtros.js';
import { initColombiaFilters } from './filtros/filtros.colombia.js';
import { aplicarFiltrosEventos, limpiarFiltrosEventos } from './filtros/filtros.core.js';
import { confirmarEliminacion, recargarEventos } from '../eliminar_evento/main.js';

initColombiaFilters();

try { aplicarFiltrosEventos(); } catch {}

window.eliminarEvento = confirmarEliminacion;
window.recargarEventos = recargarEventos;
window.limpiarFiltros = limpiarFiltrosEventos;
