// public/assets/js/admin/home/calendar.js

const qs  = (s, r=document) => r.querySelector(s);

const state = {
  year: 0,
  month: 0, // 0-11
  today: new Date(),
  events: [],
  eventsByDate: new Map()
};

function ymd(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, "0");
  const d = String(date.getDate()).padStart(2, "0");
  return `${y}-${m}-${d}`;
}
function formatDMY(date) {
  return `${String(date.getDate()).padStart(2,"0")}/${String(date.getMonth()+1).padStart(2,"0")}/${date.getFullYear()}`;
}
function parseDateYMD(str) {
  const d = String(str || "").slice(0,10);
  const [y,m,da] = d.split("-").map(Number);
  return new Date(y, (m||1)-1, da||1);
}
function groupEvents(events) {
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

/**
 * Fuente ÚNICA de datos: window.EVENTS (inyectado desde la vista de Home).
 * Si no existe, se devuelve [] y se muestra un warning en consola.
 */
async function fetchEvents() {
  if (Array.isArray(window.EVENTS)) {
    return window.EVENTS;
  }
  console.warn("[Calendar] window.EVENTS no está definido en la vista de Home. Mostrando calendario vacío.");
  return [];
}

function setMonthYear(date = new Date()) {
  state.year  = date.getFullYear();
  state.month = date.getMonth();
}

function renderTitle() {
  const title = qs("#cal-title");
  if (!title) return;
  const fmt = new Intl.DateTimeFormat("es-CO", { month:"long", year:"numeric" });
  title.textContent = "Calendario — " + fmt.format(new Date(state.year, state.month, 1));
}

function renderGrid() {
  const grid = qs("#cal-grid");
  if (!grid) return;
  grid.innerHTML = "";

  const first = new Date(state.year, state.month, 1);
  const offset = (first.getDay() + 6) % 7; // lunes = 0
  const daysInMonth = new Date(state.year, state.month + 1, 0).getDate();

  for (let i=0;i<offset;i++) {
    const pad = document.createElement("div");
    pad.className = "p-3 rounded-lg bg-transparent";
    grid.appendChild(pad);
  }

  for (let day=1; day<=daysInMonth; day++) {
    const date = new Date(state.year, state.month, day);
    const key  = ymd(date);
    const isToday = ymd(date) === ymd(state.today);
    const hasEvents = state.eventsByDate.has(key);
    const count = hasEvents ? state.eventsByDate.get(key).length : 0;

    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = [
      "w-full text-left p-3 rounded-lg border transition",
      hasEvents ? "bg-lime-50 border-lime-200 hover:bg-lime-100" : "bg-gray-50 border-gray-200 hover:bg-gray-100",
      isToday ? "ring-2 ring-lime-500" : ""
    ].join(" ");

    btn.innerHTML = `
      <div class="flex items-start justify-between">
        <span class="text-sm font-semibold text-gray-800">${day}</span>
        ${count ? `<span class="text-xs bg-lime-200 text-lime-800 px-2 py-0.5 rounded-full">${count}</span>` : ""}
      </div>
      ${hasEvents ? `
        <div class="mt-2 space-y-1">
          ${state.eventsByDate.get(key).slice(0,2).map(ev => `
            <div class="text-xs truncate text-lime-700">• ${ev.titulo_evento}</div>
          `).join("")}
          ${count>2 ? `<div class="text-[11px] text-gray-500">+${count-2} más</div>` : ""}
        </div>` : ""}
    `;

    btn.addEventListener("click", () => showDayEvents(date));
    grid.appendChild(btn);
  }
}

function showDayEvents(date) {
  const key   = ymd(date);
  const list  = qs("#day-list");
  const title = qs("#day-title");
  const sub   = qs("#day-sub");

  if (title) title.textContent = "Eventos del " + formatDMY(date);
  if (sub)   sub.textContent   = "Haz clic en un evento para ver su detalle";
  if (!list) return;

  list.innerHTML = "";

  const items = state.eventsByDate.get(key) || [];
  if (!items.length) {
    list.innerHTML = `<div class="text-sm text-gray-500">No hay eventos para esta fecha.</div>`;
    return;
  }

  items.forEach(ev => {
    const a = document.createElement("a");
    a.href = `${URL_PATH}/admin/detalleEvento/${ev.id_evento}`;
    a.className = "block p-3 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition";
    a.innerHTML = `
      <div class="flex items-start justify-between">
        <div>
          <div class="text-sm font-semibold text-gray-800">${ev.titulo_evento}</div>
          <div class="text-xs text-gray-500">
            ${(ev.hora_inicio||'').slice(0,5)}${ev.hora_fin ? ' - ' + ev.hora_fin.slice(0,5) : ''}
          </div>
          ${ev.lugar_detallado ? `<div class="text-xs text-gray-500 mt-1">${ev.lugar_detallado}</div>` : ""}
        </div>
        <svg class="w-4 h-4 text-gray-400 mt-1" viewBox="0 0 20 20" fill="currentColor">
          <path d="M7.05 4.55a1 1 0 010 1.41L4.41 8.6H17a1 1 0 110 2H4.4l2.65 2.64a1 1 0 11-1.41 1.42l-4.24-4.24a1 1 0 010-1.42l4.25-4.24a1 1 0 011.4 0z"/>
        </svg>
      </div>
    `;
    list.appendChild(a);
  });
}

function bindNav() {
  qs("#cal-prev")?.addEventListener("click", () => {
    setMonthYear(new Date(state.year, state.month - 1, 1));
    renderAll();
  });
  qs("#cal-next")?.addEventListener("click", () => {
    setMonthYear(new Date(state.year, state.month + 1, 1));
    renderAll();
  });
  qs("#cal-today")?.addEventListener("click", () => {
    const d = new Date();
    setMonthYear(d);
    renderAll();
    showDayEvents(d);
  });
}

function renderAll() {
  renderTitle();
  renderGrid();
}

document.addEventListener("DOMContentLoaded", async () => {
  setMonthYear(new Date());
  bindNav();

  const events = await fetchEvents();
  state.events = events;
  state.eventsByDate = groupEvents(events);

  renderAll();
  showDayEvents(state.today);
});
