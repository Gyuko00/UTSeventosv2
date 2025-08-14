import { SELECTORS } from './config.js';
import { State } from './state.js';
import { getTimeSlots } from './state.js';
import { handleSlotInteraction, updateFormFieldsFromSelection, initializeExistingValuesToSelection } from './selection.js';
import { loadOccupiedSlots } from './api.js';
import { renderTimeline, updateSelectedDisplay } from './render.js';
import { validateTimeRange } from './validators.js';

function el(id) { return document.getElementById(id); }

export function setupTimelineClick() {
  const container = el(SELECTORS.timeline);
  if (!container) return;

  container.addEventListener('click', (e) => {
    const slot = e.target.closest('.time-slot');
    if (!slot) return;

    const isOccupied = slot.getAttribute('data-occupied') === 'true';
    if (isOccupied) return;

    const index = parseInt(slot.getAttribute('data-index'), 10);
    if (Number.isNaN(index)) return;

    handleSlotInteraction(index);
  });
}

export function setupFechaLugarListeners() {
  const fechaInput = el(SELECTORS.fecha);
  const lugarInput = el(SELECTORS.lugar);
  if (!fechaInput || !lugarInput) return;

  const handleChange = () => {
    const fecha = fechaInput.value;
    const lugar = lugarInput.value;
        
    if (fecha && lugar) {
      loadOccupiedSlots(fecha, lugar);
    } else {
      State.occupiedSlots = [];
      renderTimeline();
    }
  };

  fechaInput.addEventListener('change', handleChange);
  lugarInput.addEventListener('change', handleChange);

  if (fechaInput.value && lugarInput.value) {
    loadOccupiedSlots(fechaInput.value, lugarInput.value);
  }
}

export function setupFormSubmitGuard() {
  const form = document.querySelector(SELECTORS.form) || document.querySelector('form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    const valid = validateTimeRange();
    const hasSelection = Array.isArray(State.selectedSlots) && State.selectedSlots.length > 0;

    if (!valid || !hasSelection) {
      e.preventDefault();
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Error en horarios',
          text: 'Por favor, selecciona un horario válido para el evento.',
          confirmButtonColor: '#84cc16'
        });
      } else {
        alert('Por favor, selecciona un horario válido para el evento.');
      }
    }
  });
}

export function initializeFromExistingValues() {
  initializeExistingValuesToSelection();
  renderTimeline();
  updateSelectedDisplay();
  validateTimeRange();
}

export function detectCurrentEventIdFromUrl() {
  const urlParts = window.location.pathname.split('/');
  const last = urlParts[urlParts.length - 1];
  if (last && !isNaN(last)) {
    State.currentEventId = parseInt(last, 10);
  }
}

export function initialRender() {
  getTimeSlots();
  renderTimeline();
  updateSelectedDisplay();
  validateTimeRange();
}