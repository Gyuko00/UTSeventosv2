<?php
// app/modules/admin/components/ponentes_evento/crud/editar/informacion_evento.php
?>
<div class="space-y-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Información del Evento</h2>
        <span class="text-sm text-gray-500">(Solo lectura)</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Título del Evento</label>
            <p class="text-lg font-semibold text-gray-900">
                <?= htmlspecialchars($ponente['titulo_evento']) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Fecha del Evento</label>
            <p class="text-base text-gray-900">
                <?= date('d/m/Y', strtotime($ponente['fecha'])) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Hora de Inicio</label>
            <p class="text-base text-gray-900">
                <?= date('H:i', strtotime($ponente['hora_inicio'])) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Hora de Fin</label>
            <p class="text-base text-gray-900">
                <?= date('H:i', strtotime($ponente['hora_fin'])) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 lg:col-span-2">
            <label class="block text-sm font-medium text-gray-500 mb-1">Ubicación</label>
            <p class="text-base text-gray-900">
                <?= htmlspecialchars($ponente['institucion_evento']) ?> - 
                <?= htmlspecialchars($ponente['lugar_detallado']) ?><br>
                <span class="text-sm text-gray-600">
                    <?= htmlspecialchars($ponente['municipio_evento']) ?>, 
                    <?= htmlspecialchars($ponente['departamento_evento']) ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Campo oculto para mantener el ID del evento -->
    <input type="hidden" name="speaker_event[id_evento]" value="<?= htmlspecialchars($ponente['id_evento']) ?>">
</div>