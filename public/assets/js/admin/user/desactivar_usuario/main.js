import { eliminarUsuario } from './desactivar.js';
import { recargarUsuarios as recargarListaUsuarios } from './actualizar_lista.js';

export async function confirmarEliminacion(idUsuario, nombreUsuario) {
  if (parseInt(idUsuario) === 1) {
    await Swal.fire({
      icon: "error",
      title: "Acción no permitida",
      text: "No se puede eliminar al usuario administrador del sistema.",
      confirmButtonColor: "#d33",
    });
    return;
  }

  const resultado = await Swal.fire({
    title: "¿Estás seguro?",
    text: `¿Deseas desactivar al usuario "${nombreUsuario}"? El usuario no podrá acceder al sistema.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, desactivar",
    cancelButtonText: "Cancelar",
    footer: '<small>Esta acción se puede revertir reactivando el usuario</small>',
  });

  if (resultado.isConfirmed) {
    await eliminarUsuario(idUsuario);
  }
}

export async function recargarUsuarios() {
  await recargarListaUsuarios();
}