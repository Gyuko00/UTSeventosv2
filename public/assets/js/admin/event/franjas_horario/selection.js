import { SELECTORS } from './config.js';
import { State, getTimeSlots } from './state.js';
import { calculateEndTime } from './time.js';
import { validateTimeRange, updateDurationFromSlots } from './validators.js';
import { renderTimeline, updateSelectedDisplay } from './render.js';

function el(id) { return document.getElementById(id); }

function setFormTimes(horaInicio, horaFin) {
  const inicioEl = el(SELECTORS.horaInicio);
  const finEl = el(SELECTORS.horaFin);
  if (inicioEl) inicioEl.value = horaInicio;
  if (finEl) finEl.value = horaFin;
}

export function updateFormFieldsFromSelection() {

  const timeSlots = getTimeSlots();
  const startIndex = Math.min(...State.selectedSlots);
  const endIndex = Math.max(...State.selectedSlots);

  const horaInicio = timeSlots[startIndex].time;

  const horaFin = calculateEndTime(timeSlots[endIndex].time);

  setFormTimes(horaInicio, horaFin);
  validateTimeRange();
  updateDurationFromSlots();
}

export function handleSlotInteraction(index) {
  const ts = getTimeSlots();
  const slotTime = ts[index]?.time;
  const isOccupied = State.occupiedSlots.includes(slotTime);
       
  if (isOccupied) return;

  if (!State.isSelecting) {
    State.selectedSlots = [index];
    State.selectionStart = index;
    State.isSelecting = true;
    
  } else {
    const start = Math.min(State.selectionStart, index);
    const end = Math.max(State.selectionStart, index);

    let hasOccupied = false;
    for (let i = start; i <= end; i++) {
      if (State.occupiedSlots.includes(ts[i].time)) {
        hasOccupied = true;
        break;
      }
    }

    if (hasOccupied) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Horario No Disponible',
          text: 'No se puede seleccionar un rango que incluya horarios ocupados',
          confirmButtonColor: '#84cc16'
        });
      } else {
        alert('No se puede seleccionar un rango que incluya horarios ocupados');
      }
      State.selectedSlots = [];
      State.isSelecting = false;
      State.selectionStart = null;
    } else {
      const seleccion = [];
      for (let i = start; i <= end; i++) seleccion.push(i);
      State.selectedSlots = seleccion;
      State.isSelecting = false;
                   
      updateFormFieldsFromSelection();
    }
  }

  renderTimeline();
  updateSelectedDisplay();
}

export function initializeExistingValuesToSelection() {
  const inicioEl = el(SELECTORS.horaInicio);
  const finEl = el(SELECTORS.horaFin);
  if (!inicioEl || !finEl) return;

  let horaInicio = inicioEl.value;
  let horaFin = finEl.value;
  if (!(horaInicio && horaFin)) return;

  horaInicio = horaInicio.substring(0, 5);
  horaFin = horaFin.substring(0, 5);

  const timeSlots = getTimeSlots();
  const startIndex = timeSlots.findIndex(s => s.time === horaInicio);

  let endIndex = -1;
  for (let i = 0; i < timeSlots.length - 1; i++) {
    if (timeSlots[i + 1] && timeSlots[i + 1].time === horaFin) {
      endIndex = i;
      break;
    }
  }
  
  if (endIndex === -1) {
    for (let i = 0; i < timeSlots.length; i++) {
      const slotEndTime = calculateEndTime(timeSlots[i].time);
      if (slotEndTime === horaFin) {
        endIndex = i;
        break;
      }
    }
  }

  if (startIndex !== -1 && endIndex !== -1 && endIndex >= startIndex) {
    const seleccion = [];
    for (let i = startIndex; i <= endIndex; i++) seleccion.push(i);
    State.selectedSlots = seleccion;
    updateDurationFromSlots();
  }
}