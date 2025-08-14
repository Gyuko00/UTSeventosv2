// franjas_horario validators.js - CON DEBUG
import { SELECTORS } from './config.js';
import { diffText, parseHHMMToDate, calculateDurationFromSlots } from './time.js';
import { State } from './state.js';

function el(id) {
  return document.getElementById(id);
}

export function validateTimeRange() {
  
  const inicioEl = el(SELECTORS.horaInicio);
  const finEl = el(SELECTORS.horaFin);
  const duracionEl = el(SELECTORS.duracionDisplay);

  if (!inicioEl || !finEl) return true;
  if (!duracionEl) return true;

  const horaInicio = inicioEl.value;
  const horaFin = finEl.value;

  if (horaInicio && horaFin) {
    const ini = parseHHMMToDate(horaInicio);
    const fin = parseHHMMToDate(horaFin);

    if (fin <= ini) {
      duracionEl.innerHTML = '<span class="text-red-500">⚠️ La hora de fin debe ser posterior a la hora de inicio</span>';
      return false;
    }

    if (State.selectedSlots.length === 0) {
      const durationText = diffText(horaInicio, horaFin);
      duracionEl.innerHTML = '<span class="text-lime-600">' + durationText + '</span>';
    }
    return true;
  } else {
    if (State.selectedSlots.length === 0) {
      duracionEl.innerHTML = '';
    } 
    return true;
  }
}

export function updateDurationFromSlots() {
  
  const duracionEl = el(SELECTORS.duracionDisplay);


  if (State.selectedSlots.length === 0) {
    duracionEl.innerHTML = '';
    return;
  }

  const inicioEl = el(SELECTORS.horaInicio);
  const finEl = el(SELECTORS.horaFin);
  
  const horaInicio = inicioEl?.value;
  const horaFin = finEl?.value;
  
  if (inicioEl && finEl && horaInicio && horaFin) {
    
    const inicio = parseHHMMToDate(horaInicio);
    const fin = parseHHMMToDate(horaFin);
    const ms = fin - inicio;
    const hours = Math.floor(ms / (1000 * 60 * 60));
    const minutes = Math.floor((ms % (1000 * 60 * 60)) / (1000 * 60));
    
    const durationText = diffText(horaInicio, horaFin);
    duracionEl.innerHTML = '<span class="text-lime-600">' + durationText + '</span>';
  } else {
    const durationText = calculateDurationFromSlots(State.selectedSlots);
    duracionEl.innerHTML = '<span class="text-lime-600">' + durationText + '</span>';
  }
  
}