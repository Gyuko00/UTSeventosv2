<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/informacion_ubicacion.php
?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Ubicación del Evento</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <dt class="text-sm font-medium text-gray-500">Departamento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['departamento_evento'] ?? 'No especificado') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Municipio</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['municipio_evento'] ?? 'No especificado') ?>
            </dd>
        </div>
        
        <div class="md:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Institución</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['institucion_evento'] ?? 'No especificada') ?>
            </dd>
        </div>
        
        <div class="md:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Lugar Detallado</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['lugar_detallado']) ? nl2br(htmlspecialchars($evento['lugar_detallado'])) : 'No especificado' ?>
            </dd>
        </div>
    </div>
</div>