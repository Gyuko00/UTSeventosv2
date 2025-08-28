
import { IDS, getEventoSelect, getHoraInput } from "./timeline.config.js";
import { generateTimeSlots, findEventById } from "./timeline.core.js";

export class PonenteTimelineManager {
  constructor() {
    this.selectedEvent = null;
    this.timeSlots = [];
    this.selectedSlots = [];
    this.occupied = [];
  }

  init() {
    this.injectHTML();
    this.bindSelect();
    this.autoOpenIfPreselected();
  }

  injectHTML() {
    const horaField = getHoraInput();
    if (!horaField) return;

    const wrap = horaField.closest(".space-y-3");
    if (wrap) wrap.style.display = "none";

    const html = `
      <div id="${IDS.container}" class="space-y-4 hidden">
        <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
          <div class="w-8 h-8 bg-lime-100 rounded-full flex items-center justify-center">
            <i class="fas fa-clock text-lime-600"></i>
          </div>
          <h3 class="text-lg font-semibold text-gray-800">Seleccionar Horario de Participación</h3>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl">
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
              <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div> Disponible
            </span>
            <span class="inline-flex items-center px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
              <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div> Ocupado
            </span>
            <span class="inline-flex items-center px-2 py-1 text-xs bg-lime-100 text-lime-800 rounded-full">
              <div class="w-2 h-2 bg-lime-500 rounded-full mr-1"></div> Seleccionado
            </span>
          </div>

          <div id="${IDS.slots}" class="space-y-2 max-h-64 overflow-y-auto"></div>
          <div id="${IDS.display}" class="mt-4 p-3 bg-white rounded-lg border border-gray-200 text-sm text-gray-600">
            Selecciona un horario para la participación del ponente
          </div>
        </div>
      </div>`;
    wrap?.insertAdjacentHTML("afterend", html);
  }

  bindSelect() {
    const sel = getEventoSelect();
    if (!sel) return;

    sel.addEventListener("change", async (e) => {
      const id = e.target.value;
      if (!id) return this.hide();

      this.showLoading();
      this.selectedEvent = findEventById(id);
      this.timeSlots = this.selectedEvent
        ? generateTimeSlots(this.selectedEvent.hora_inicio, this.selectedEvent.hora_fin)
        : [];
      this.occupied = []; 
      this.selectedSlots = [];
      this.render();
      this.show();
      this.preselectFromInput();
    });
  }

  render() {
    const el = document.getElementById(IDS.slots);
    if (!el) return;
    el.innerHTML = this.timeSlots
      .map((s) => {
        const occ = this.occupied.includes(s.time);
        const sel = this.selectedSlots.includes(s.index);
        let cls =
          "time-slot px-3 py-2 rounded-lg text-sm border transition-all duration-200 ";
        if (occ)
          cls +=
            "bg-red-100 border-red-200 text-red-700 cursor-not-allowed opacity-75";
        else if (sel)
          cls +=
            "bg-lime-500 border-lime-600 text-white shadow-lg cursor-pointer";
        else
          cls +=
            "bg-green-50 border-green-200 text-green-700 hover:bg-green-100 hover:border-green-300 cursor-pointer";
        return `
        <div class="${cls}" data-index="${s.index}" data-time="${s.time}" data-occupied="${occ}">
          <div class="flex justify-between items-center">
            <span class="font-medium">${s.display}</span>
            ${
              occ
                ? '<span class="text-xs">Ocupado</span>'
                : sel
                ? '<svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>'
                : ""
            }
          </div>
        </div>`;
      })
      .join("");

    el.onclick = (ev) => {
      const node = ev.target.closest(".time-slot");
      if (!node) return;
      if (node.getAttribute("data-occupied") === "true") return;
      const idx = Number(node.getAttribute("data-index"));
      this.selectedSlots = this.selectedSlots.includes(idx) ? [] : [idx];
      this.render();
      this.updateDisplay();
      this.updateHidden();
    };
  }

  updateDisplay() {
    const d = document.getElementById(IDS.display);
    if (!d) return;
    if (!this.selectedSlots.length) {
      d.className =
        "mt-4 p-3 bg-white rounded-lg border border-gray-200 text-sm text-gray-600";
      d.textContent = "Selecciona un horario para la participación del ponente";
      return;
    }
    const sel = this.timeSlots[this.selectedSlots[0]];
    d.className =
      "mt-4 p-3 bg-lime-50 rounded-lg border border-lime-200 text-sm text-lime-800";
    d.innerHTML = `
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-lime-600" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span><strong>Horario seleccionado:</strong> ${sel.display}</span>
      </div>`;
  }

  updateHidden() {
    const input = getHoraInput();
    if (!input) return;
    input.value = this.selectedSlots.length
      ? this.timeSlots[this.selectedSlots[0]]?.time || ""
      : "";
  }

  autoOpenIfPreselected() {
    const sel =
      getEventoSelect() ||
      document.querySelector('select[name="speaker_event[id_evento]"]') ||
      document.querySelector('select[name="id_evento"]') ||
      document.getElementById("id_evento");

    if (sel && sel.value) {
      sel.dispatchEvent(new Event("change"));
      return;
    }

    if (Array.isArray(window.eventosData) && window.eventosData.length) {
      const ev = window.eventosData[0];
      if (ev?.hora_inicio && ev?.hora_fin) {
        this.selectedEvent = ev;
        this.timeSlots = generateTimeSlots(ev.hora_inicio, ev.hora_fin);
        this.occupied = [];
        this.selectedSlots = [];
        this.render();
        this.show();
        this.preselectFromInput(); 
      }
    }
  }

  preselectFromInput() {
    const input = getHoraInput();
    if (!input || !input.value) return;
    const wanted = input.value.slice(0, 5);
    const idx = this.timeSlots.findIndex((s) => s.time === wanted);
    if (idx >= 0) {
      this.selectedSlots = [idx];
      this.render();
      this.updateDisplay();
      this.updateHidden();
    }
  }

  showLoading() {
    const el = document.getElementById(IDS.slots);
    this.show();
    if (el) {
      el.innerHTML = `
        <div class="flex items-center justify-center py-8">
          <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-500"></div>
          <span class="ml-3 text-gray-600">Cargando horarios del evento...</span>
        </div>`;
    }
  }

  show() {
    document.getElementById(IDS.container)?.classList.remove("hidden");
  }
  hide() {
    document.getElementById(IDS.container)?.classList.add("hidden");
    this.selectedSlots = [];
    this.updateHidden();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const mgr = new PonenteTimelineManager();
  mgr.init();
  window.ponenteTimelineManager = mgr;
});
