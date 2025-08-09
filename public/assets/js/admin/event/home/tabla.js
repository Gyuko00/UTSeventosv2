import { getEstadoEventoClass, getEstadoEventoNombre, escapeHtml, formatearFecha, formatearHora } from "./utilidades.js";

export function actualizarTablaEventos(eventos) {
  const tbody = document.getElementById("tablaEventos");

  if (eventos.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" viewBox="0 0 640 640" fill="currentColor">
                            <path d="M152 24C152 10.7 162.7 0 176 0H336C349.3 0 360 10.7 360 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24C280 10.7 290.7 0 304 0H456C469.3 0 480 10.7 480 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24zM152 24H336V64H152V24z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No hay eventos registrados</h3>
                            <p class="text-gray-500 text-sm">Comienza creando tu primer evento</p>
                        </div>
                        <a href="${window.location.origin}/utseventos/public/admin/crearEvento" 
                           class="inline-flex items-center gap-2 bg-lime-600 hover:bg-lime-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus"></i>
                            Crear Evento
                        </a>
                    </div>
                </td>
            </tr>`;
    return;
  }

  let html = "";
  eventos.forEach((evento) => {
    const estadoClass = getEstadoEventoClass(evento.fecha, evento.hora_inicio);
    const estadoNombre = getEstadoEventoNombre(evento.fecha, evento.hora_inicio);

    html += `
            <tr class="hover:bg-lime-50 transition-colors duration-150 evento-row"
                data-titulo="${evento.titulo_evento.toLowerCase()}"
                data-tema="${evento.tema.toLowerCase()}"
                data-institucion="${evento.institucion_evento.toLowerCase()}"
                data-fecha="${evento.fecha}"
                data-institucion-id="${evento.institucion_id || ''}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-col">
                        <div class="text-sm font-medium text-gray-900 mb-1">
                            ${escapeHtml(evento.titulo_evento)}
                        </div>
                        <div class="text-xs text-gray-500">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${escapeHtml(evento.tema)}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-col">
                        <div class="text-sm text-gray-900 font-medium">
                            ${escapeHtml(evento.institucion_evento)}
                        </div>
                        <div class="text-xs text-gray-500">
                            ${escapeHtml(evento.lugar_detallado)}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">
                        ${escapeHtml(evento.descripcion || 'Sin descripción')}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-col">
                        <div class="text-sm font-medium text-gray-900">
                            ${formatearFecha(evento.fecha)}
                        </div>
                        <div class="text-xs text-gray-500">
                            ${formatearHora(evento.hora_inicio)} - ${formatearHora(evento.hora_fin)}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            ${escapeHtml(evento.cupo_maximo)}
                        </div>
                        <div class="ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${estadoClass}">
                                ${estadoNombre}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <a href="${window.location.origin}/utseventos/public/admin/verEvento/${evento.id_evento}" 
                           class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-150"
                           title="Ver evento">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="${window.location.origin}/utseventos/public/admin/editarEvento/${evento.id_evento}" 
                           class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition-colors duration-150"
                           title="Editar evento">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="eliminarEvento(${evento.id_evento}, '${escapeHtml(evento.titulo_evento)}')" 
                                class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-150"
                                title="Eliminar evento">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
  });

  tbody.innerHTML = html;
}

export function mostrarMensajeSinResultados(mostrar) {
  const mensajeExistente = document.getElementById("mensaje-sin-resultados");
  const tbody = document.getElementById("tablaEventos");

  if (mostrar && !mensajeExistente) {
    const mensaje = document.createElement("tr");
    mensaje.id = "mensaje-sin-resultados";
    mensaje.innerHTML = `
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                <p>No se encontraron eventos que coincidan con los filtros aplicados</p>
            </td>`;
    tbody.appendChild(mensaje);
  } else if (!mostrar && mensajeExistente) {
    mensajeExistente.remove();
  }
}