// eliminar_evento/main.js
import { eliminarEvento } from './eliminar.js';
import { recargarEventos as recargarListaEventos } from './actualizar_lista.js';

export async function confirmarEliminacion(idEvento, nombreEvento) {
  
  const resultado = await Swal.fire({
    title: "¿Estás seguro?",
    text: `¿Deseas eliminar el evento "${nombreEvento}"? Esta acción no se puede deshacer.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
    footer: '<small>⚠️ Esta acción eliminará permanentemente el evento</small>',
  });


  if (resultado.isConfirmed) {
    await eliminarEvento(idEvento);
  } else {
  }
}

export async function recargarEventos() {
  await recargarListaEventos();
}