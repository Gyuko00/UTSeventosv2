import { INTERVALO_MINUTOS } from "./config.js";

export function formatTimeDisplay(hour, minute) {
  const period = hour >= 12 ? "PM" : "AM";
  const displayHour = hour > 12 ? hour - 12 : hour === 0 ? 12 : hour;
  const displayMinute = minute.toString().padStart(2, "0");
  return `${displayHour}:${displayMinute} ${period}`;
}

export function calculateEndTime(startHHMM) {
  const [h, m] = startHHMM.split(":").map(Number);
  const end = new Date();
  end.setHours(h, m + INTERVALO_MINUTOS, 0, 0);
  return end.toTimeString().slice(0, 5);
}

export function parseHHMMToDate(hhmm) {
  return new Date("1970-01-01T" + hhmm + ":00");
}

export function calculateDurationFromSlots(selectedSlots) {
  if (!selectedSlots || selectedSlots.length === 0) return "Sin selección";

  const totalMinutes = selectedSlots.length * INTERVALO_MINUTOS;
  const hours = Math.floor(totalMinutes / 60);
  const minutes = totalMinutes % 60;

  let duration = "✅ Duración: ";
  if (hours > 0) duration += hours + " hora" + (hours !== 1 ? "s" : "");
  if (minutes > 0) {
    if (hours > 0) duration += " y ";
    duration += minutes + " minuto" + (minutes !== 1 ? "s" : "");
  }

  return duration;
}

export function diffText(inicioHHMM, finHHMM) {

  const inicio = parseHHMMToDate(inicioHHMM);
  const fin = parseHHMMToDate(finHHMM);

  const ms = fin - inicio;

  const totalMinutes = ms / (1000 * 60);

  const hours = Math.floor(ms / (1000 * 60 * 60));
  const minutes = Math.floor((ms % (1000 * 60 * 60)) / (1000 * 60));

  let t = "✅ Duración: ";
  if (hours > 0) t += hours + " hora" + (hours !== 1 ? "s" : "");
  if (minutes > 0) {
    if (hours > 0) t += " y ";
    t += minutes + " minuto" + (minutes !== 1 ? "s" : "");
  }

  return t;
}

export function toDisplayFromHHMM(hhmm) {
  const [h, m] = hhmm.split(":").map(Number);
  return formatTimeDisplay(h, m);
}
