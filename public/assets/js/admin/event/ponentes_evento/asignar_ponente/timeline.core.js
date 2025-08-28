import { SLOT_MINUTES } from './timeline.config.js';

export function simpleFormatTime(h, m) {
  const period = h >= 12 ? 'PM' : 'AM';
  let hh = h === 0 ? 12 : (h > 12 ? h - 12 : h);
  return `${hh.toString()}:${m.toString().padStart(2, '0')} ${period}`;
}

export function generateTimeSlots(horaInicio, horaFin) {
  if (!horaInicio || !horaFin) return [];
  const [sh, sm] = horaInicio.slice(0, 5).split(':').map(Number);
  const [eh, em] = horaFin.slice(0, 5).split(':').map(Number);
  const start = sh * 60 + sm;
  const end = eh * 60 + em;

  const slots = [];
  let index = 0;

  for (let t = start; t < end; t += SLOT_MINUTES) {
    const ch = Math.floor(t / 60), cm = t % 60;
    const te = t + SLOT_MINUTES;
    const eh2 = Math.floor(te / 60), em2 = te % 60;

    const startStr = `${String(ch).padStart(2, '0')}:${String(cm).padStart(2, '0')}`;
    const endStr   = `${String(eh2).padStart(2, '0')}:${String(em2).padStart(2, '0')}`;

    slots.push({
      index,
      time: startStr,
      endTime: endStr,
      display: `${simpleFormatTime(ch, cm)} - ${simpleFormatTime(eh2, em2)}`
    });
    index++;
  }
  return slots;
}

export function findEventById(eventId, data = (window.eventosData || [])) {
  return Array.isArray(data) ? data.find(e => String(e.id_evento) === String(eventId)) : null;
}
