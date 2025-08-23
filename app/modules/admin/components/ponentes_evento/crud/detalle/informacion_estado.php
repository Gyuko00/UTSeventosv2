<?php
// app/modules/admin/components/ponentes_evento/crud/detalle/informacion_estado.php
?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4 mb-6">
        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Estado y Seguimiento</h2>
    </div>

    <div class="space-y-6">
        <!-- Estado de asistencia detallado -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado de Asistencia</h3>
            
            <?php
            $estado_config = [
                'confirmado' => [
                    'bg' => 'bg-green-100',
                    'text' => 'text-green-800',
                    'border' => 'border-green-200',
                    'icon_color' => 'text-green-600',
                    'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                    'titulo' => 'Confirmado',
                    'descripcion' => 'El ponente ha confirmado su asistencia al evento.'
                ],
                'pendiente' => [
                    'bg' => 'bg-yellow-100',
                    'text' => 'text-yellow-800',
                    'border' => 'border-yellow-200',
                    'icon_color' => 'text-yellow-600',
                    'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                    'titulo' => 'Pendiente',
                    'descripcion' => 'Esperando confirmación de asistencia del ponente.'
                ],
                'cancelado' => [
                    'bg' => 'bg-red-100',
                    'text' => 'text-red-800',
                    'border' => 'border-red-200',
                    'icon_color' => 'text-red-600',
                    'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                    'titulo' => 'Cancelado',
                    'descripcion' => 'La participación del ponente ha sido cancelada.'
                ],
                'ausente' => [
                    'bg' => 'bg-gray-100',
                    'text' => 'text-gray-800',
                    'border' => 'border-gray-200',
                    'icon_color' => 'text-gray-600',
                    'icon' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                    'titulo' => 'Ausente',
                    'descripcion' => 'El ponente no asistió al evento.'
                ]
            ];

            $estado_actual = $ponente['estado_asistencia'] ?? 'pendiente';
            $config = $estado_config[$estado_actual] ?? $estado_config['pendiente'];
            ?>

            <div class="flex items-start gap-4 p-4 <?= $config['bg'] ?> <?= $config['border'] ?> border rounded-lg">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 <?= $config['icon_color'] ?>" fill="currentColor" viewBox="0 0 20 20">
                        <?= $config['icon'] ?>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold <?= $config['text'] ?> mb-1">
                        <?= $config['titulo'] ?>
                    </h4>
                    <p class="<?= $config['text'] ?> text-sm">
                        <?= $config['descripcion'] ?>
                    </p>
                </div>
                
                <!-- Botón para cambiar estado -->
                <div class="flex-shrink-0">
                    <button onclick="cambiarEstado(<?= $ponente['id_ponente_evento'] ?>, '<?= $estado_actual ?>')"
                            class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md <?= $config['text'] ?> hover:bg-opacity-75 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Cambiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Estado del certificado -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Certificado de Participación</h3>
            
            <?php if ($ponente['certificado_generado'] == 1): ?>
                <!-- Certificado generado -->
                <div class="flex items-start gap-4 p-4 bg-blue-100 border-blue-200 border rounded-lg">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-blue-800 mb-1">
                            Certificado Generado
                        </h4>
                        <p class="text-blue-800 text-sm mb-3">
                            El certificado de participación ha sido generado exitosamente.
                        </p>
                        <div class="flex gap-2">
                            <button onclick="descargarCertificado(<?= $ponente['id_ponente_evento'] ?>)"
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Descargar
                            </button>
                            <button onclick="enviarCertificado(<?= $ponente['id_ponente_evento'] ?>)"
                                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Enviar por Email
                            </button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Certificado no generado -->
                <div class="flex items-start gap-4 p-4 bg-gray-100 border-gray-200 border rounded-lg">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-700 mb-1">
                            Certificado Pendiente
                        </h4>
                        <p class="text-gray-600 text-sm mb-3">
                            <?php if ($estado_actual === 'confirmado'): ?>
                                El certificado está listo para ser generado.
                            <?php elseif ($estado_actual === 'pendiente'): ?>
                                El certificado se podrá generar una vez confirmada la asistencia.
                            <?php else: ?>
                                No se puede generar el certificado debido al estado actual.
                            <?php endif; ?>
                        </p>
                        
                        <?php if ($estado_actual === 'confirmado'): ?>
                            <button onclick="generarCertificado(<?= $ponente['id_ponente_evento'] ?>)"
                                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Generar Certificado
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Timeline de actividad -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial de Actividad</h3>
            
            <div class="space-y-4">
                <!-- Registro inicial -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Ponente asignado al evento</p>
                        <p class="text-xs text-gray-500">
                            <?= date('d/m/Y H:i', strtotime($ponente['fecha_registro'])) ?>
                        </p>
                    </div>
                </div>
                
                <!-- Estado actual -->
                <?php if ($estado_actual !== 'pendiente'): ?>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-<?= $estado_actual === 'confirmado' ? 'green' : 'red' ?>-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            Estado cambiado a: <?= $config['titulo'] ?>
                        </p>
                        <p class="text-xs text-gray-500">Fecha del cambio</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Certificado generado -->
                <?php if ($ponente['certificado_generado'] == 1): ?>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Certificado generado</p>
                        <p class="text-xs text-gray-500">Fecha de generación</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarEstado(idPonenteEvento, estadoActual) {
    const estados = {
        'pendiente': 'Pendiente',
        'confirmado': 'Confirmado',
        'cancelado': 'Cancelado',
        'ausente': 'Ausente'
    };
    
    let opciones = '';
    for (const [key, value] of Object.entries(estados)) {
        const selected = key === estadoActual ? 'selected' : '';
        opciones += `<option value="${key}" ${selected}>${value}</option>`;
    }
    
    const nuevoEstado = prompt(
        `Selecciona el nuevo estado:\n\n` +
        `1. Pendiente\n` +
        `2. Confirmado\n` +
        `3. Cancelado\n` +
        `4. Ausente\n\n` +
        `Ingresa el número correspondiente:`,
        estadoActual === 'pendiente' ? '1' : 
        estadoActual === 'confirmado' ? '2' : 
        estadoActual === 'cancelado' ? '3' : '4'
    );
    
    if (nuevoEstado) {
        const estadosMap = {
            '1': 'pendiente',
            '2': 'confirmado', 
            '3': 'cancelado',
            '4': 'ausente'
        };
        
        const estadoSeleccionado = estadosMap[nuevoEstado];
        if (estadoSeleccionado && estadoSeleccionado !== estadoActual) {
            actualizarEstado(idPonenteEvento, estadoSeleccionado);
        }
    }
}

function actualizarEstado(idPonenteEvento, nuevoEstado) {
    fetch(`${URL_PATH}/admin/actualizarEstadoPonente`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_ponente_evento: idPonenteEvento,
            estado_asistencia: nuevoEstado
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Estado actualizado exitosamente');
            location.reload();
        } else {
            alert('Error al actualizar el estado: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}

function generarCertificado(idPonenteEvento) {
    if (confirm('¿Está seguro de que desea generar el certificado?')) {
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
    window.open(`${URL_PATH}/admin/descargarCertificado/${idPonenteEvento}`, '_blank');
}

function enviarCertificado(idPonenteEvento) {
    if (confirm('¿Desea enviar el certificado por email al ponente?')) {
        fetch(`${URL_PATH}/admin/enviarCertificado`, {
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
                alert('Certificado enviado exitosamente');
            } else {
                alert('Error al enviar el certificado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }
}
</script>