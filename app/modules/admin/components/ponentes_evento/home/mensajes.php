<?php 
// app/modules/admin/components/ponentes_evento/home/mensajes.php 
?>

<?php if (isset($_GET['success'])): ?>
    <div id="mensajeExito" class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3 animate-fade-in">
        <div class="bg-green-100 rounded-full p-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-green-800 font-semibold">¡Operación exitosa!</h3>
            <p class="text-green-700">
                <?php
                switch ($_GET['success']) {
                    case 'created':
                        echo 'El ponente ha sido asignado al evento correctamente.';
                        break;
                    case 'updated':
                        echo 'La información de la asignación ha sido actualizada.';
                        break;
                    case 'deleted':
                        echo 'La asignación del ponente ha sido eliminada correctamente.';
                        break;
                    case 'certificate_generated':
                        echo 'El certificado ha sido generado exitosamente.';
                        break;
                    default:
                        echo 'La operación se completó exitosamente.';
                }
                ?>
            </p>
        </div>
        <button onclick="cerrarMensaje('mensajeExito')" class="text-green-600 hover:text-green-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div id="mensajeError" class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center gap-3 animate-fade-in">
        <div class="bg-red-100 rounded-full p-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-red-800 font-semibold">¡Error en la operación!</h3>
            <p class="text-red-700">
                <?php
                switch ($_GET['error']) {
                    case 'not_found':
                        echo 'No se encontró la asignación solicitada.';
                        break;
                    case 'already_assigned':
                        echo 'El ponente ya está asignado a este evento.';
                        break;
                    case 'invalid_data':
                        echo 'Los datos proporcionados no son válidos.';
                        break;
                    case 'database_error':
                        echo 'Error en la base de datos. Inténtalo de nuevo.';
                        break;
                    case 'unauthorized':
                        echo 'No tienes permisos para realizar esta acción.';
                        break;
                    default:
                        echo 'Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo.';
                }
                ?>
            </p>
        </div>
        <button onclick="cerrarMensaje('mensajeError')" class="text-red-600 hover:text-red-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['info'])): ?>
    <div id="mensajeInfo" class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center gap-3 animate-fade-in">
        <div class="bg-blue-100 rounded-full p-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-blue-800 font-semibold">Información</h3>
            <p class="text-blue-700">
                <?php
                switch ($_GET['info']) {
                    case 'no_changes':
                        echo 'No se realizaron cambios en la información.';
                        break;
                    case 'pending_confirmation':
                        echo 'La asignación está pendiente de confirmación por el ponente.';
                        break;
                    default:
                        echo htmlspecialchars($_GET['info']);
                }
                ?>
            </p>
        </div>
        <button onclick="cerrarMensaje('mensajeInfo')" class="text-blue-600 hover:text-blue-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
<?php endif; ?>

<script>
function cerrarMensaje(idMensaje) {
    const mensaje = document.getElementById(idMensaje);
    if (mensaje) {
        mensaje.style.opacity = '0';
        mensaje.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            mensaje.remove();
            const url = new URL(window.location);
            url.searchParams.delete('success');
            url.searchParams.delete('error');
            url.searchParams.delete('info');
            window.history.replaceState({}, '', url);
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const mensajes = ['mensajeExito', 'mensajeError', 'mensajeInfo'];
    mensajes.forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            setTimeout(() => {
                cerrarMensaje(id);
            }, 8000);
        }
    });
});
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>