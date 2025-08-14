// franjas_horario main.js
import { generateTimeSlots, State } from './state.js';
import { setBaseUrl } from './config.js';
import {
  setupTimelineClick, setupFechaLugarListeners, setupFormSubmitGuard,
  initializeFromExistingValues, initialRender
} from './listeners.js';

document.addEventListener('DOMContentLoaded', () => {
  if (typeof globalThis !== 'undefined' && typeof globalThis.URL_PATH === 'string') {
    setBaseUrl(globalThis.URL_PATH); 
  }

  if (typeof globalThis !== 'undefined' && Number.isInteger(globalThis.EVENTO_ID)) {
    State.currentEventId = globalThis.EVENTO_ID;
  }

  generateTimeSlots();

  setupTimelineClick();
  setupFechaLugarListeners();
  setupFormSubmitGuard();

  initializeFromExistingValues();
  initialRender();

});
