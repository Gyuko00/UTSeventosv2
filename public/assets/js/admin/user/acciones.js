import { actualizarTablaUsuarios } from './tabla.js';

export async function confirmarEliminacion(idUsuario, nombreUsuario) {
    const resultado = await Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas desactivar al usuario "${nombreUsuario}"? El usuario no podrá acceder al sistema.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    });

    if (resultado.isConfirmed) {
        await eliminarUsuario(idUsuario);
    }
}

async function eliminarUsuario(idUsuario) {
    try {
        const response = await fetch(`${window.location.origin}/utseventos/public/admin/eliminarUsuario`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id_usuario: idUsuario })
        });

        const resultado = await response.json();

        if (resultado.status === 'success') {
            await Swal.fire({
                icon: 'success',
                title: 'Usuario desactivado',
                text: resultado.message,
                confirmButtonColor: '#3085d6'
            });
            window.location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: resultado.message,
                confirmButtonColor: '#d33'
            });
        }
    } catch (error) {
        console.error('Error al eliminar usuario:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'No se pudo conectar con el servidor',
            confirmButtonColor: '#d33'
        });
    }
}

export async function recargarUsuarios() {
    try {
        const response = await fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await response.json();

        if (data.status === 'success') {
            actualizarTablaUsuarios(data.usuarios);
        }
    } catch (error) {
        console.error('Error al recargar usuarios:', error);
    }
}
