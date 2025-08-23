import { SELECTORS } from "./config.js";
import { State, getTimeSlots } from "./state.js";
import { calculateEndTime, toDisplayFromHHMM } from "./time.js";

function el(id) {
  return document.getElementById(id);
}

export function renderTimeline() {
  const timeSlots = getTimeSlots();
  const container = el(SELECTORS.timeline);
  if (!container) {
    return;
  }

  const html = timeSlots
    .map((slot, index) => {
      const isOccupied = State.occupiedSlots.includes(slot.time);
      const isSelected = State.selectedSlots.includes(index);

      let cls =
        "time-slot px-3 py-2 rounded-lg text-sm border transition-all duration-200 ";
      if (isOccupied) {
        cls +=
          "bg-red-100 border-red-200 text-red-700 cursor-not-allowed opacity-75";
      } else if (isSelected) {
        cls += "bg-lime-500 border-lime-600 text-white shadow-lg";
      } else {
        cls +=
          "bg-green-50 border-green-200 text-green-700 hover:bg-green-100 hover:border-green-300 cursor-pointer";
      }

      const check = isSelected
        ? '<svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
        : "";

      const ocupado = isOccupied ? '<span class="text-xs">Ocupado</span>' : "";

      const startTime = slot.display; 
      const endTimeHHMM = calculateEndTime(slot.time); 
      const endTime = toDisplayFromHHMM(endTimeHHMM); 
      const intervalDisplay = `${startTime} - ${endTime}`; 

      return `
      <div class="${cls}" data-index="${index}" data-time="${slot.time}" data-occupied="${isOccupied}">
        <div class="flex justify-between items-center">
          <span class="font-medium">${intervalDisplay}</span>
          ${ocupado}
          ${check}
        </div>
      </div>
    `;
    })
    .join("");

  container.innerHTML = html;
}

export function updateSelectedDisplay() {
  const display = el(SELECTORS.selectedDisplay);
  if (!display) return;

  if (State.selectedSlots.length === 0) {
    display.textContent = "Selecciona un horario en la línea de tiempo";
    return;
  }

  const timeSlots = getTimeSlots();
  const startIndex = Math.min(...State.selectedSlots);
  const endIndex = Math.max(...State.selectedSlots);

  const startTimeDisp = timeSlots[startIndex].display;

  const endHHMM = calculateEndTime(timeSlots[endIndex].time);
  const endTimeDisp = toDisplayFromHHMM(endHHMM);

  display.innerHTML = `
    <div class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <span><strong>${startTimeDisp}</strong> - <strong>${endTimeDisp}</strong></span>
    </div>
  `;
}

export function showLoadingIndicator(show) {
  const container = el(SELECTORS.timeline);
  if (show && container) {
    container.innerHTML = `
      <div class="flex items-center justify-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-lime-500"></div>
        <span class="ml-3 text-gray-600">Cargando horarios...</span>
      </div>
    `;
  }
}

export function renderOccupiedEventsInfo(eventsInfo = []) {
  if (!eventsInfo.length) return;
  const infoContainer = el(SELECTORS.occupiedInfo);
  if (!infoContainer) return;

  const eventsHtml = eventsInfo
    .map(
      (event) => `
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 mb-3 shadow-md hover:shadow-lg transition-all duration-200">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="flex items-center gap-3 mb-2">
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 640 640">
              <path d="M439.4 96L448 96C483.3 96 512 124.7 512 160L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 160C128 124.7 156.7 96 192 96L200.6 96C211.6 76.9 232.3 64 256 64L384 64C407.7 64 428.4 76.9 439.4 96zM376 176C389.3 176 400 165.3 400 152C400 138.7 389.3 128 376 128L264 128C250.7 128 240 138.7 240 152C240 165.3 250.7 176 264 176L376 176zM256 320C256 302.3 241.7 288 224 288C206.3 288 192 302.3 192 320C192 337.7 206.3 352 224 352C241.7 352 256 337.7 256 320zM288 320C288 333.3 298.7 344 312 344L424 344C437.3 344 448 333.3 448 320C448 306.7 437.3 296 424 296L312 296C298.7 296 288 306.7 288 320zM288 448C288 461.3 298.7 472 312 472L424 472C437.3 472 448 461.3 448 448C448 434.7 437.3 424 424 424L312 424C298.7 424 288 434.7 288 448zM224 480C241.7 480 256 465.7 256 448C256 430.3 241.7 416 224 416C206.3 416 192 430.3 192 448C192 465.7 206.3 480 224 480z"/>
            </svg>
            <h6 class="font-semibold text-green-800 text-base">${event.titulo_evento}</h6>
          </div>
          <div class="flex items-center gap-3 text-green-700 ml-8">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 640 640">
              <path d="M528 320C528 434.9 434.9 528 320 528C205.1 528 112 434.9 112 320C112 205.1 205.1 112 320 112C434.9 112 528 205.1 528 320zM64 320C64 461.4 178.6 576 320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320zM296 184L296 320C296 328 300 335.5 306.7 340L402.7 404C413.7 411.4 428.6 408.4 436 397.3C443.4 386.2 440.4 371.4 429.3 364L344 307.2L344 184C344 170.7 333.3 160 320 160C306.7 160 296 170.7 296 184z"/>
            </svg>
            <span class="text-sm font-medium">${event.hora_inicio} - ${event.hora_fin}</span>
          </div>
        </div>
        <div class="flex-shrink-0 ml-3">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
            Ocupado
          </span>
        </div>
      </div>
    </div>
  `
    )
    .join("");

  infoContainer.innerHTML = `
  <div class="mt-6 p-6 bg-white rounded-xl shadow-lg">
    <div class="flex items-center gap-4 mb-5 px-1">
      <div class="flex-shrink-0 w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 640 640">
          <path d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 192C496 183.2 488.8 176 480 176L216 176zM404.4 292.7L324.4 420.7C320.2 427.4 313 431.6 305.1 432C297.2 432.4 289.6 428.8 284.9 422.4L236.9 358.4C228.9 347.8 231.1 332.8 241.7 324.8C252.3 316.8 267.3 319 275.3 329.6L302.3 365.6L363.7 267.3C370.7 256.1 385.5 252.6 396.8 259.7C408.1 266.8 411.5 281.5 404.4 292.8z"/>
        </svg>
      </div>
      <h5 class="text-lg font-semibold text-green-800">Eventos Programados</h5>
      <span class="ml-auto bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
        ${eventsInfo.length} evento${eventsInfo.length !== 1 ? "s" : ""}
      </span>
    </div>
    <div class="space-y-3">
      ${eventsHtml}
    </div>
  </div>
`;
}
