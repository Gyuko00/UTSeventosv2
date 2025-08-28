<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/informacion_evento.php
?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Información del Evento</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <dt class="text-sm font-medium text-gray-500">Código Evento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['event_code']) ?>
            </dd>
        </div>

        <div>
            <dt class="text-sm font-medium text-gray-500">Evento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['titulo_evento']) ?>
            </dd>
        </div>

        <div>
            <dt class="text-sm font-medium text-gray-500">Tema</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['tema']) ?>
            </dd>
        </div>

        <div>
            <dt class="text-sm font-medium text-gray-500">Descripción</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['descripcion']) ? nl2br(htmlspecialchars($evento['descripcion'])) : 'Sin descripción' ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Fecha del Evento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php if (!empty($evento['fecha'])): ?>
                    <?= date('d/m/Y', strtotime($evento['fecha'])) ?>
                <?php else: ?>
                    No especificada
                <?php endif; ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Hora de Inicio</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['hora_inicio']) ? date('H:i', strtotime($evento['hora_inicio'])) : 'No especificada' ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Hora de Fin</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['hora_fin']) ? date('H:i', strtotime($evento['hora_fin'])) : 'No especificada' ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Cupo Máximo</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= $evento['cupo_maximo'] ?? 'Sin límite' ?> participantes
            </dd>
        </div>
    </div>
</div>