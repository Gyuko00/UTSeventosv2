// calendar.core.js
export const qs = (s, r=document) => r.querySelector(s);

export const state = {
  year: 0,
  month: 0,
  today: new Date(),
  selectedDate: null,
  events: [],
  eventsByDate: new Map(),
};

export function ymd(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, "0");
  const d = String(date.getDate()).padStart(2, "0");
  return `${y}-${m}-${d}`;
}

export function formatDMY(date) {
  return `${String(date.getDate()).padStart(2,"0")}/${String(date.getMonth()+1).padStart(2,"0")}/${date.getFullYear()}`;
}

export function parseDateYMD(str) {
  const d = String(str || "").slice(0,10);
  const [y,m,da] = d.split("-").map(Number);
  return new Date(y, (m||1)-1, da||1);
}

export function groupEvents(events) {
  const map = new Map();
  (events || []).forEach(ev => {
    const date = parseDateYMD(ev.fecha);
    const key  = ymd(date);
    if (!map.has(key)) map.set(key, []);
    map.get(key).push(ev);
  });
  for (const [, arr] of map) {
    arr.sort((a,b) => String(a.hora_inicio||"").localeCompare(String(b.hora_inicio||"")));
  }
  return map;
}

export async function fetchEventsFromWindow() {
  if (Array.isArray(window.EVENTS)) return window.EVENTS;
  console.warn("[Calendar] window.EVENTS no está definido. Calendario vacío.");
  return [];
}

export function setMonthYear(date = new Date()) {
  state.year  = date.getFullYear();
  state.month = date.getMonth();
}
