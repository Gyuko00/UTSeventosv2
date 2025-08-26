// ui.js
import { renderEventosList } from "./templates.js";

const tabHandler = (e) => {
  if (!e.target.classList.contains("tab-btn")) return;

  const tabId = e.target.dataset.tab;

  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.classList.remove("active", "border-orange-500", "text-orange-600");
    btn.classList.add("border-transparent", "text-gray-500");
  });

  e.target.classList.add("active", "border-orange-500", "text-orange-600");
  e.target.classList.remove("border-transparent", "text-gray-500");

  document
    .querySelectorAll(".tab-content")
    .forEach((c) => c.classList.add("hidden"));

  const target = document.getElementById(`tab-${tabId}`);
  if (target) target.classList.remove("hidden");
};

export function initTabs(root = document) {
  root.removeEventListener("click", tabHandler);
  root.addEventListener("click", tabHandler);
}

export function renderEventos(contentElement, data) {
  if (!data.eventos_proximos?.length && !data.eventos_pasados?.length) {
    contentElement.innerHTML = renderEventosList([], "");
    return;
  }

  contentElement.innerHTML = `
    <!-- Estadísticas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-blue-50 p-3 rounded-lg text-center">
        <div class="text-2xl font-bold text-blue-600">${
          data.estadisticas.total_eventos || 0
        }</div>
        <div class="text-xs text-blue-600">Total</div>
      </div>
      <div class="bg-green-50 p-3 rounded-lg text-center">
        <div class="text-2xl font-bold text-green-600">${
          data.estadisticas.eventos_proximos || 0
        }</div>
        <div class="text-xs text-green-600">Próximos</div>
      </div>
      <div class="bg-purple-50 p-3 rounded-lg text-center">
        <div class="text-2xl font-bold text-purple-600">${
          data.estadisticas.eventos_asistidos || 0
        }</div>
        <div class="text-xs text-purple-600">Asistidos</div>
      </div>
      <div class="bg-orange-50 p-3 rounded-lg text-center">
        <div class="text-2xl font-bold text-orange-600">${
          data.estadisticas.certificados_obtenidos || 0
        }</div>
        <div class="text-xs text-orange-600">Certificados</div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-4">
      <nav class="-mb-px flex space-x-8">
        <button class="tab-btn active py-2 px-1 border-b-2 border-orange-500 text-orange-600 font-medium text-sm" data-tab="proximos">
          Próximos (${data.eventos_proximos.length})
        </button>
        <button class="tab-btn py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" data-tab="pasados">
          Pasados (${data.eventos_pasados.length})
        </button>
      </nav>
    </div>

    <!-- Contenido de tabs -->
    <div id="tab-proximos" class="tab-content">
      ${renderEventosList(data.eventos_proximos, "próximos")}
    </div>
    <div id="tab-pasados" class="tab-content hidden">
      ${renderEventosList(data.eventos_pasados, "pasados")}
    </div>
  `;

  initTabs();
}

export function renderError(contentElement, message) {
  contentElement.innerHTML = `
    <div class="text-center py-8 text-red-500">
      <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <p class="text-sm">${message}</p>
      <button onclick="location.reload()" class="mt-3 text-orange-600 hover:text-orange-700 text-sm underline">
        Recargar página
      </button>
      <div class="mt-4 text-xs text-gray-400">
        <p>Si el problema persiste, intenta más tarde.</p>
      </div>
    </div>
  `;
}
