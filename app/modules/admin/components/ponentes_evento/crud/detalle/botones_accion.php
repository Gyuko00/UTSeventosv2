<?php
// app/modules/admin/components/ponentes_evento/crud/detalle/botones_accion.php
?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <!-- Botones principales -->
        <div class="flex flex-wrap gap-3">
            <!-- Editar asignación -->
            <a href="<?= URL_PATH ?>/admin/editarAsignacionPonente/<?= $ponente['id_ponente_evento'] ?>" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar Asignación
            </a>

            <!-- Ver evento completo -->
            <a href="<?= URL_PATH ?>/admin/detalleEvento/<?= $ponente['id_evento'] ?>" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Ver Evento Completo
            </a>
        </div>

        <!-- Botones secundarios -->
        <div class="flex flex-wrap gap-3">
            <!-- Volver al listado -->
            <a href="<?= URL_PATH ?>/admin/listarPonentes" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Listado
            </a>

            <!-- Remover ponente del evento -->
            <button onclick="removerPonente(<?= $ponente['id_ponente_evento'] ?>, '<?= htmlspecialchars($ponente['nombres'] . ' ' . $ponente['apellidos']) ?>', '<?= htmlspecialchars($ponente['titulo_evento']) ?>')"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remover del Evento
            </button>
        </div>
    </div>
</div>

<script>
function generarCertificado(idPonenteEvento) {
    if (confirm('¿Está seguro de que desea generar el certificado para este ponente?')) {
        // Aquí irían las acciones para generar el certificado
        console.log('Generando certificado para:', idPonenteEvento);
        
        // Ejemplo de implementación:
        fetch(`${URL_PATH}/admin/generarCertificado`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_ponente_evento: idPonenteEvento
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Certificado generado exitosamente');
                location.reload();
            } else {
                alert('Error al generar el certificado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }
}

function descargarCertificado(idPonenteEvento) {
    // Redirigir a la descarga del certificado
    window.open(`${URL_PATH}/admin/descargarCertificado/${idPonenteEvento}`, '_blank');
}

function removerPonente(idPonenteEvento, nombrePonente, tituloEvento) {
    if (confirm(`¿Está seguro de que desea remover a "${nombrePonente}" del evento "${tituloEvento}"?\n\nEsta acción no se puede deshacer.`)) {
        // Mostrar loading
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Removiendo...';
        button.disabled = true;

        fetch(`${URL_PATH}/admin/removerPonenteEvento`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_ponente_evento: idPonenteEvento
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Ponente removido exitosamente del evento');
                window.location.href = `${URL_PATH}/admin/listarPonentes`;
            } else {
                alert('Error al remover el ponente: ' + data.message);
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}
</script>