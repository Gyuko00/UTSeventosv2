// franjas_horario state.js
import { HORARIO_INICIO, HORARIO_FIN, INTERVALO_MINUTOS } from './config.js';
import { formatTimeDisplay } from './time.js';

let selectedSlots = [];
let occupiedSlots = [];
let isSelecting = false;
let selectionStart = null;
let currentEventId = null;
let timeSlots = [];

export function generateTimeSlots() {
  const slots = [];
  for (let hour = HORARIO_INICIO; hour <= HORARIO_FIN; hour++) {
    for (let minute = 0; minute < 60; minute += INTERVALO_MINUTOS) {
      if (hour === HORARIO_FIN && minute > 0) break;
      const time = `${hour.toString().padStart(2, '0')}:${minute
        .toString()
        .padStart(2, '0')}`;
      slots.push({
        time,
        display: formatTimeDisplay(hour, minute),
      });
    }
  }
  timeSlots = slots;
  return timeSlots;
}

export function getTimeSlots() {
  if (!timeSlots.length) generateTimeSlots();
  return timeSlots;
}

export const State = {
  get selectedSlots() { return selectedSlots; },
  set selectedSlots(v) { selectedSlots = Array.isArray(v) ? v : []; },

  get occupiedSlots() { return occupiedSlots; },
  set occupiedSlots(v) { occupiedSlots = Array.isArray(v) ? v : []; },

  get isSelecting() { return isSelecting; },
  set isSelecting(v) { isSelecting = !!v; },

  get selectionStart() { return selectionStart; },
  set selectionStart(v) { selectionStart = v; },

  get currentEventId() { return currentEventId; },
  set currentEventId(v) { currentEventId = v; }
};
