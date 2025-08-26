// templates.js
export function getEventoStatus(evento) {
  if (evento.es_proximo) {
    if (evento.dias_restantes === 0)
      return '<span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Hoy</span>';
    if (evento.dias_restantes === 1)
      return '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">Mañana</span>';
    if (evento.dias_restantes <= 7)
      return `<span class="bg-orange-100 text-orange-800 text-xs font-medium px-2 py-1 rounded-full">${evento.dias_restantes} días</span>`;
    return '<span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">Próximo</span>';
  }
  return evento.estado_asistencia === 1
    ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">✓ Asistido</span>'
    : '<span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">No asistido</span>';
}

export function renderEventoCard(evento) {
  return `
      <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow bg-gray-50">
        <div class="flex justify-between items-start mb-3">
          <div class="flex-1">
            <h4 class="font-semibold text-gray-900 text-sm mb-1">${
              evento.titulo
            }</h4>
            ${
              evento.tema !== "Sin tema"
                ? `<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-2">${evento.tema}</span>`
                : ""
            }
          </div>
          <div class="flex flex-col items-end gap-1 ml-4">
            ${getEventoStatus(evento)}
            ${
              evento.certificado_disponible
                ? `<button class="certificado-btn text-orange-600 hover:text-orange-700 text-xs underline" data-evento-id="${evento.id_evento}" data-token="${evento.token}">📄 Certificado</button>`
                : ""
            }
          </div>
        </div>
  
        <div class="space-y-2 text-xs text-gray-600">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            <span>${evento.fecha_formateada}</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
            <span>${evento.hora_inicio} - ${evento.hora_fin}</span>
          </div>
        </div>
      </div>
    `;
}

export function renderEventosList(eventos, tipo) {
  if (!eventos || eventos.length === 0) {
    return getEmptyState(tipo);
  }
  return `
      <div class="space-y-4 max-h-96 overflow-y-auto">
        ${eventos.map(renderEventoCard).join("")}
      </div>
    `;
}

export function getEmptyState(tipo = "") {
  const messages = {
    próximos: {
      msg: "No tienes eventos próximos",
      sub: "¡Inscríbete a eventos interesantes!",
    },
    pasados: {
      msg: "No tienes eventos pasados",
      sub: "Aquí aparecerán los eventos a los que hayas asistido",
    },
    "": {
      msg: "No estás inscrito a ningún evento",
      sub: "Explora los eventos disponibles y únete a la comunidad",
    },
  };
  const config = messages[tipo] || messages[""];
  return `
      <div class="text-center py-8 text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-sm">${config.msg}</p>
        <p class="text-xs text-gray-400 mt-1">${config.sub}</p>
      </div>
    `;
}
