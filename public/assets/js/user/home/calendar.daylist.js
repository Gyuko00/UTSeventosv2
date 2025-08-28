// calendar.daylist.js actualizado
import { state, ymd, formatDMY, qs } from "./calendar.core.js";
import { confirmarEInscripcion, cancelarInscripcionCalendario, renderActionButton, escapeHtml } from "./calendar.register.js";

export function renderDayList(date) {
  const key   = ymd(date);
  const list  = qs("#day-list");
  const title = qs("#day-title");
  const sub   = qs("#day-sub");

  state.selectedDate = new Date(date);

  if (title) title.textContent = "Eventos del " + formatDMY(date);
  if (sub)   sub.textContent   = "Haz clic en un evento para ver su detalle";
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
    const card = document.createElement("div");
    card.className = "block p-3 bg-white border border-gray-200 rounded-lg hover:shadow-md hover:border-lime-300 transition-all duration-200 transform hover:scale-[1.02]";
    card.style.opacity   = "0";
    card.style.transform = "translateY(10px)";

    // Verificar estado de inscripción
    const inscrito = Boolean(ev.inscrito);

    card.innerHTML = `
      <div class="flex items-start justify-between gap-3">
        <a href="${URL_PATH}/user/detalleEvento/${ev.id_evento}" class="flex-1 min-w-0">
          <div class="text-sm font-semibold text-gray-800 mb-1 truncate">${escapeHtml(ev.titulo_evento)}</div>
          <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <span>${(ev.hora_inicio||'').slice(0,5)}${ev.hora_fin ? ' - ' + ev.hora_fin.slice(0,5) : ''}</span>
          </div>
          ${ev.lugar_detallado ? `
            <div class="flex items-center gap-2 text-xs text-gray-500">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
              </svg>
              <span class="truncate">${escapeHtml(ev.lugar_detallado)}</span>
            </div>` : ""}
        </a>

        <!-- Usar la función renderActionButton que ya existe -->
        <div class="flex-shrink-0 event-actions">
          ${renderActionButton(ev)}
        </div>
      </div>
    `;

    // Agregar event listeners para los botones
    attachEventListeners(card, ev);

    list.appendChild(card);

    // Animación escalonada
    setTimeout(() => {
      card.style.transition = "all 0.3s ease-out";
      card.style.opacity = "1";
      card.style.transform = "translateY(0)";
    }, index * 100);
  });
}

/**
 * Agregar event listeners a los botones de acción
 */
function attachEventListeners(card, evento) {
  // Botón de inscripción (usa las clases de renderActionButton)
  const btnInscribirse = card.querySelector(".inscribirse-btn");
  if (btnInscribirse) {
    btnInscribirse.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      const eventoId = Number(btnInscribirse.dataset.eventoId);
      const eventoTitulo = btnInscribirse.dataset.eventoTitulo || "";
      
      confirmarEInscripcion(eventoId, eventoTitulo);
    });
  }

  // Botón de cancelar inscripción (usa las clases de renderActionButton)
  const btnCancelar = card.querySelector(".cancelar-btn");
  if (btnCancelar) {
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      const eventoId = Number(btnCancelar.dataset.eventoId);
      cancelarInscripcionCalendario(eventoId);
    });
  }
}

/**
 * Función helper para actualizar el estado visual de un evento específico
 */
export function updateEventVisualState(eventoId, inscrito) {
  const eventCards = document.querySelectorAll('[data-evento-id]');
  
  eventCards.forEach(card => {
    const cardEventoId = Number(card.dataset.eventoId);
    
    if (cardEventoId === eventoId) {
      const actionsContainer = card.querySelector('.event-actions');
      if (actionsContainer) {
        // Crear objeto evento temporal para renderizar
        const eventoTemp = {
          id_evento: eventoId,
          titulo_evento: card.querySelector('[data-evento-titulo]')?.dataset.eventoTitulo || 'Evento',
          inscrito: inscrito
        };
        
        actionsContainer.innerHTML = renderActionButton(eventoTemp);
        attachEventListeners(card, eventoTemp);
      }
    }
  });
}