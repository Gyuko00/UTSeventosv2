// calendar.ui.js
import { state, qs, ymd, parseDateYMD } from "./calendar.core.js";

export function renderTitle() {
  const title = qs("#cal-title");
  if (!title) return;
  const fmt = new Intl.DateTimeFormat("es-CO", { month:"long", year:"numeric" });
  title.textContent = "Calendario — " + fmt.format(new Date(state.year, state.month, 1));
}

export function updateDayButtons() {
  const buttons = document.querySelectorAll("[data-date]");
  buttons.forEach((btn) => {
    const dateKey    = btn.dataset.date;
    const date       = parseDateYMD(dateKey);
    const isToday    = ymd(date) === ymd(state.today);
    const hasEvents  = state.eventsByDate.has(dateKey);
    const isSelected = state.selectedDate && ymd(date) === ymd(state.selectedDate);
    const count      = hasEvents ? state.eventsByDate.get(dateKey).length : 0;

    const base = [
      "w-full text-left p-3 rounded-lg border transition-all duration-200 transform",
      "hover:scale-105 hover:shadow-md",
    ];
    if (isSelected) {
      base.push("bg-lime-500 border-lime-600 text-white shadow-lg ring-2 ring-lime-300 scale-105");
    } else if (hasEvents) {
      base.push("bg-lime-50 border-lime-200 hover:bg-lime-100");
    } else {
      base.push("bg-gray-50 border-gray-200 hover:bg-gray-100");
    }
    if (isToday && !isSelected) base.push("ring-2 ring-lime-500");
    btn.className = base.join(" ");

    const day = date.getDate();
    btn.innerHTML = `
      <div class="flex items-start justify-between">
        <span class="text-sm font-semibold ${isSelected ? "text-white" : "text-gray-800"}">${day}</span>
        ${
          count
            ? `<span class="text-xs ${isSelected ? "bg-white bg-opacity-20 text-white" : "bg-lime-200 text-lime-800"} px-2 py-0.5 rounded-full">${count}</span>`
            : ""
        }
      </div>
      ${
        hasEvents
          ? `
          <div class="mt-2 space-y-1">
            ${state.eventsByDate.get(dateKey).slice(0,2).map(ev => `
              <div class="text-xs truncate ${isSelected ? "text-lime-100" : "text-lime-700"}">• ${ev.titulo_evento}</div>
            `).join("")}
            ${count>2 ? `<div class="text-[11px] ${isSelected ? "text-white text-opacity-70" : "text-gray-500"}">+${count-2} más</div>` : ""}
          </div>`
          : ""
      }
    `;
  });
}

export function renderGrid(onDayClick) {
  const grid = qs("#cal-grid");
  if (!grid) return;
  grid.innerHTML = "";

  const first = new Date(state.year, state.month, 1);
  const offset = (first.getDay() + 6) % 7; 
  const daysInMonth = new Date(state.year, state.month + 1, 0).getDate();

  for (let i=0;i<offset;i++) {
    const pad = document.createElement("div");
    pad.className = "p-3 rounded-lg bg-transparent";
    grid.appendChild(pad);
  }

  for (let day=1; day<=daysInMonth; day++) {
    const date = new Date(state.year, state.month, day);
    const key  = ymd(date);

    const btn = document.createElement("button");
    btn.type = "button";
    btn.dataset.date = key;
    btn.className = "w-full text-left p-3 rounded-lg border bg-gray-50 border-gray-200 hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 hover:shadow-md";
    btn.addEventListener("click", () => onDayClick(date, btn));

    grid.appendChild(btn);
  }

  updateDayButtons();
}

export function renderAll(onDayClick) {
  renderTitle();
  renderGrid(onDayClick);
}
