import { getRolClass, getRolNombre, escapeHtml } from "./utilidades.js";

export function actualizarTablaUsuarios(usuarios) {
  const tbody = document.getElementById("tablaUsuarios");

  if (usuarios.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p>No hay usuarios registrados</p>
                </td>
            </tr>`;
    return;
  }

  let html = "";
  usuarios.forEach((usuario) => {
    const rolClass = getRolClass(usuario.id_rol);
    const rolNombre = getRolNombre(usuario.id_rol);

    html += `
            <tr class="hover:bg-gray-50 usuario-row"
                data-nombre="${(
                  usuario.nombres +
                  " " +
                  usuario.apellidos
                ).toLowerCase()}"
                data-usuario="${usuario.usuario.toLowerCase()}"
                data-documento="${usuario.numero_documento}"
                data-rol="${usuario.id_rol}"
                data-activo="${usuario.activo}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${escapeHtml(
                              usuario.usuario
                            )}</div>
                            <div class="text-sm text-gray-500">${escapeHtml(
                              usuario.correo_personal || "Sin email"
                            )}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${escapeHtml(
                      usuario.nombres + " " + usuario.apellidos
                    )}</div>
                    <div class="text-sm text-gray-500">${escapeHtml(
                      usuario.tipo_documento + ": " + usuario.numero_documento
                    )}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${rolClass}">${rolNombre}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                      usuario.activo
                        ? "bg-green-100 text-green-800"
                        : "bg-red-100 text-red-800"
                    }">
                        ${usuario.activo ? "Activo" : "Inactivo"}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div>${escapeHtml(usuario.municipio || "N/A")}</div>
                    <div>${escapeHtml(usuario.departamento || "N/A")}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="${
                      window.location.origin
                    }/utseventos/public/admin/detalleUsuario/${
      usuario.id_usuario
    }" class="text-blue-600 hover:text-blue-900 mr-3" title="Ver detalle"><i class="fas fa-eye"></i></a>
                    <a href="${
                      window.location.origin
                    }/utseventos/public/admin/editarUsuario/${
      usuario.id_usuario
    }" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Editar"><i class="fas fa-edit"></i></a>
                    <button onclick="confirmarEliminacion(${
                      usuario.id_usuario
                    }, '${escapeHtml(
      usuario.usuario
    )}')" class="text-red-600 hover:text-red-900" title="Eliminar"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
  });

  tbody.innerHTML = html;
}

export function mostrarMensajeSinResultados(mostrar) {
  const mensajeExistente = document.getElementById("mensaje-sin-resultados");
  const tbody = document.getElementById("tablaUsuarios");

  if (mostrar && !mensajeExistente) {
    const mensaje = document.createElement("tr");
    mensaje.id = "mensaje-sin-resultados";
    mensaje.innerHTML = `
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                <p>No se encontraron usuarios que coincidan con los filtros aplicados</p>
            </td>`;
    tbody.appendChild(mensaje);
  } else if (!mostrar && mensajeExistente) {
    mensajeExistente.remove();
  }
}
