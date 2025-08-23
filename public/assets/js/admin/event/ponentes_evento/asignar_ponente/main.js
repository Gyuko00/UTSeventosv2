// main.js
import { initializeForm, setCurrentDateTime } from './form.js';
import { loadEventosAndPonentes } from './services.js';
import { aplicarFiltrosEventos } from '../../home/filtros/filtros.core.js'; 

document.addEventListener('DOMContentLoaded', () => {
  initializeForm();
  loadEventosAndPonentes();
  setCurrentDateTime();
  try { aplicarFiltrosEventos(); } catch {}
});
