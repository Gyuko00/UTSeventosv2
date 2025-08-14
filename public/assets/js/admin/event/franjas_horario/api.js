import { endpoint } from './config.js';
import { State } from './state.js';
import { renderTimeline, showLoadingIndicator, renderOccupiedEventsInfo } from './render.js';

async function safeJson(response) {
  const ct = response.headers.get('Content-Type') || '';
  const text = await response.text();
  if (!ct.toLowerCase().includes('application/json')) {
    throw new SyntaxError(`Respuesta no-JSON (CT="${ct}"): ${text.slice(0, 200)}...`);
  }
  try { return JSON.parse(text); }
  catch { throw new SyntaxError(`JSON inválido: ${text.slice(0, 200)}...`); }
}

export async function loadOccupiedSlots(fecha, lugar) {
  if (!fecha || !lugar) {
    State.occupiedSlots = [];
    renderTimeline();
    return;
  }

  try {
    showLoadingIndicator(true);

    const payload = { fecha, lugar };
    if (State.currentEventId) payload.exclude_event_id = State.currentEventId;

    const url = endpoint('/admin/getOccupiedSlots');
    
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload),
      credentials: 'same-origin'
    });

    if (!res.ok) {
      const body = await res.text();
      throw new Error(`HTTP ${res.status}. Cuerpo: ${body.slice(0, 200)}...`);
    }

    const data = await safeJson(res);
    
    if (data.status !== 'success') throw new Error(data.message || 'Error backend');

    State.occupiedSlots = Array.isArray(data.occupied_slots) ? data.occupied_slots : [];
    renderOccupiedEventsInfo(Array.isArray(data.events_info) ? data.events_info : []);

    if (State.occupiedSlots.length === 0 && State.currentEventId) {
      await generateCurrentEventOccupiedSlots();
    }

  } catch (err) {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: 'No se pudieron cargar los horarios ocupados. Se mostrarán todos los horarios como disponibles.',
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
      });
    }
    State.occupiedSlots = [];
  } finally {
    showLoadingIndicator(false);
    renderTimeline();
  }
}

async function generateCurrentEventOccupiedSlots() {
  const inicioEl = document.getElementById(SELECTORS.horaInicio);
  const finEl = document.getElementById(SELECTORS.horaFin);
  
  if (!inicioEl || !finEl) return;
  
  let horaInicio = inicioEl.value;
  let horaFin = finEl.value;
  
  if (!horaInicio || !horaFin) return;
  
  horaInicio = horaInicio.substring(0, 5);
  horaFin = horaFin.substring(0, 5);
    
  const occupiedSlots = [];
  const start = new Date('1970-01-01T' + horaInicio + ':00');
  const end = new Date('1970-01-01T' + horaFin + ':00');
  
  const current = new Date(start);
  while (current < end) {
    occupiedSlots.push(current.toTimeString().slice(0, 5));
    current.setMinutes(current.getMinutes() + 30);
  }
  
  State.occupiedSlots = occupiedSlots;
}
