// public/assets/js/user/home/calendar.js

const qs = (s, r = document) => r.querySelector(s);

const state = {
  year: 0,
  month: 0,
  today: new Date(),
  selectedDate: null,
  events: [],
  eventsByDate: new Map(),
};

function ymd(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, "0");
  const d = String(date.getDate()).padStart(2, "0");
  return `${y}-${m}-${d}`;
}

function formatDMY(date) {
  return `${String(date.getDate()).padStart(2, "0")}/${String(
    date.getMonth() + 1
  ).padStart(2, "0")}/${date.getFullYear()}`;
}

function parseDateYMD(str) {
  const d = String(str || "").slice(0, 10);
  const [y, m, da] = d.split("-").map(Number);
  return new Date(y, (m || 1) - 1, da || 1);
}

function groupEvents(events) {
  const map = new Map();
  (events || []).forEach((ev) => {
    const date = parseDateYMD(ev.fecha);
    const key = ymd(date);
    if (!map.has(key)) map.set(key, []);
    map.get(key).push(ev);
  });
  for (const [, arr] of map) {
    arr.sort((a, b) =>
      String(a.hora_inicio || "").localeCompare(String(b.hora_inicio || ""))
    );
  }
  return map;
}

async function fetchEvents() {
  if (Array.isArray(window.EVENTS)) {
    return window.EVENTS;
  }
  console.warn(
    "[Calendar] window.EVENTS no está definido en la vista de Home. Mostrando calendario vacío."
  );
  return [];
}

function setMonthYear(date = new Date()) {
  state.year = date.getFullYear();
  state.month = date.getMonth();
}

function renderTitle() {
  const title = qs("#cal-title");
  if (!title) return;
  const fmt = new Intl.DateTimeFormat("es-CO", {
    month: "long",
    year: "numeric",
  });
  title.textContent =
    "Calendario — " + fmt.format(new Date(state.year, state.month, 1));
}

function renderGrid() {
  const grid = qs("#cal-grid");
  if (!grid) return;
  grid.innerHTML = "";

  const first = new Date(state.year, state.month, 1);
  const offset = (first.getDay() + 6) % 7;
  const daysInMonth = new Date(state.year, state.month + 1, 0).getDate();

  for (let i = 0; i < offset; i++) {
    const pad = document.createElement("div");
    pad.className = "p-3 rounded-lg bg-transparent";
    grid.appendChild(pad);
  }

  for (let day = 1; day <= daysInMonth; day++) {
    const date = new Date(state.year, state.month, day);
    const key = ymd(date);
    const isToday = ymd(date) === ymd(state.today);
    const hasEvents = state.eventsByDate.has(key);
    const count = hasEvents ? state.eventsByDate.get(key).length : 0;

    const isSelected =
      state.selectedDate && ymd(date) === ymd(state.selectedDate);

    const btn = document.createElement("button");
    btn.type = "button";
    btn.dataset.date = key;

    let classes = [
      "w-full text-left p-3 rounded-lg border transition-all duration-200 transform",
      "hover:scale-105 hover:shadow-md",
    ];

    if (isSelected) {
      classes.push(
        "bg-lime-500 border-lime-600 text-white shadow-lg ring-2 ring-lime-300 scale-105"
      );
    } else if (hasEvents) {
      classes.push("bg-lime-50 border-lime-200 hover:bg-lime-100");
    } else {
      classes.push("bg-gray-50 border-gray-200 hover:bg-gray-100");
    }

    if (isToday && !isSelected) {
      classes.push("ring-2 ring-lime-500");
    }

    btn.className = classes.join(" ");

    btn.innerHTML = `
      <div class="flex items-start justify-between">
        <span class="text-sm font-semibold ${
          isSelected ? "text-white" : "text-gray-800"
        }">${day}</span>
        ${
          count
            ? `<span class="text-xs ${
                isSelected
                  ? "bg-white bg-opacity-20 text-white"
                  : "bg-lime-200 text-lime-800"
              } px-2 py-0.5 rounded-full">${count}</span>`
            : ""
        }
      </div>
      ${
        hasEvents
          ? `
        <div class="mt-2 space-y-1">
          ${state.eventsByDate
            .get(key)
            .slice(0, 2)
            .map(
              (ev) => `
            <div class="text-xs truncate ${
              isSelected ? "text-lime-100" : "text-lime-700"
            }">• ${ev.titulo_evento}</div>
          `
            )
            .join("")}
          ${
            count > 2
              ? `<div class="text-[11px] ${
                  isSelected ? "text-white text-opacity-70" : "text-gray-500"
                }">+${count - 2} más</div>`
              : ""
          }
        </div>`
          : ""
      }
    `;

    btn.addEventListener("click", (e) => {
      btn.style.transform = "scale(0.95)";
      setTimeout(() => {
        btn.style.transform = "";
      }, 100);

      showDayEvents(date);
    });

    grid.appendChild(btn);
  }
}

function showDayEvents(date) {
  const key = ymd(date);
  const list = qs("#day-list");
  const title = qs("#day-title");
  const sub = qs("#day-sub");

  state.selectedDate = new Date(date);

  updateDayButtons();

  if (title) title.textContent = "Eventos del " + formatDMY(date);
  if (sub) sub.textContent = "Haz clic en un evento para ver su detalle";
  if (!list) return;

  list.innerHTML = "";

  const items = state.eventsByDate.get(key) || [];
  if (!items.length) {
    list.innerHTML = `
      <div class="flex flex-col items-center justify-center py-8 text-gray-500">
        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-sm">No hay eventos para esta fecha</p>
        <p class="text-xs text-gray-400 mt-1">Selecciona otro día para ver eventos</p>
      </div>
    `;
    return;
  }

  items.forEach((ev, index) => {
    const a = document.createElement("a");
    a.href = `${URL_PATH}/control/detalleEvento/${ev.id_evento}`;
    a.className =
      "block p-3 bg-white border border-gray-200 rounded-lg hover:shadow-md hover:border-lime-300 transition-all duration-200 transform hover:scale-[1.02]";

    a.style.opacity = "0";
    a.style.transform = "translateY(10px)";

    a.innerHTML = `
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="text-sm font-semibold text-gray-800 mb-1">${
            ev.titulo_evento
          }</div>
          <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <span>
              ${(ev.hora_inicio || "").slice(0, 5)}${
      ev.hora_fin ? " - " + ev.hora_fin.slice(0, 5) : ""
    }
            </span>
          </div>
          ${
            ev.lugar_detallado
              ? `
            <div class="flex items-center gap-2 text-xs text-gray-500">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
              </svg>
              <span>${ev.lugar_detallado}</span>
            </div>
          `
              : ""
          }
        </div>
        <div class="flex-shrink-0 ml-3">
          <svg class="w-4 h-4 text-lime-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
          </svg>
        </div>
      </div>
    `;

    list.appendChild(a);

    setTimeout(() => {
      a.style.transition = "all 0.3s ease-out";
      a.style.opacity = "1";
      a.style.transform = "translateY(0)";
    }, index * 100);
  });
}

function updateDayButtons() {
  const buttons = document.querySelectorAll("[data-date]");
  buttons.forEach((btn) => {
    const dateKey = btn.dataset.date;
    const date = parseDateYMD(dateKey);
    const isToday = ymd(date) === ymd(state.today);
    const hasEvents = state.eventsByDate.has(dateKey);
    const isSelected =
      state.selectedDate && ymd(date) === ymd(state.selectedDate);
    const count = hasEvents ? state.eventsByDate.get(dateKey).length : 0;

    let classes = [
      "w-full text-left p-3 rounded-lg border transition-all duration-200 transform",
      "hover:scale-105 hover:shadow-md",
    ];

    if (isSelected) {
      classes.push(
        "bg-lime-500 border-lime-600 text-white shadow-lg ring-2 ring-lime-300 scale-105"
      );
    } else if (hasEvents) {
      classes.push("bg-lime-50 border-lime-200 hover:bg-lime-100");
    } else {
      classes.push("bg-gray-50 border-gray-200 hover:bg-gray-100");
    }

    if (isToday && !isSelected) {
      classes.push("ring-2 ring-lime-500");
    }

    btn.className = classes.join(" ");

    const day = date.getDate();
    btn.innerHTML = `
      <div class="flex items-start justify-between">
        <span class="text-sm font-semibold ${
          isSelected ? "text-white" : "text-gray-800"
        }">${day}</span>
        ${
          count
            ? `<span class="text-xs ${
                isSelected
                  ? "bg-white bg-opacity-20 text-white"
                  : "bg-lime-200 text-lime-800"
              } px-2 py-0.5 rounded-full">${count}</span>`
            : ""
        }
      </div>
      ${
        hasEvents
          ? `
        <div class="mt-2 space-y-1">
          ${state.eventsByDate
            .get(dateKey)
            .slice(0, 2)
            .map(
              (ev) => `
            <div class="text-xs truncate ${
              isSelected ? "text-lime-100" : "text-lime-700"
            }">• ${ev.titulo_evento}</div>
          `
            )
            .join("")}
          ${
            count > 2
              ? `<div class="text-[11px] ${
                  isSelected ? "text-white text-opacity-70" : "text-gray-500"
                }">+${count - 2} más</div>`
              : ""
          }
        </div>`
          : ""
      }
    `;
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
