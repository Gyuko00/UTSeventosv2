<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/estadisticas_evento.php
?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Estadísticas del Evento</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <dt class="text-sm font-medium text-blue-600">Cupo Máximo</dt>
            <dd class="mt-2 text-3xl font-bold text-blue-900">
                <?= number_format($evento['estadisticas']['cupo_maximo'] ?? 0) ?>
            </dd>
            <p class="text-sm text-blue-600 mt-1">participantes</p>
        </div>
        
        <div class="bg-green-50 rounded-lg p-4">
            <dt class="text-sm font-medium text-green-600">Ponentes Asignados</dt>
            <dd class="mt-2 text-3xl font-bold text-green-900">
                <?= number_format($evento['estadisticas']['ponentes_asignados'] ?? 0) ?>
            </dd>
            <p class="text-sm text-green-600 mt-1">registrados</p>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-4">
            <dt class="text-sm font-medium text-purple-600">Asistencias</dt>
            <dd class="mt-2 text-3xl font-bold text-purple-900">
                <?= number_format($evento['estadisticas']['ponentes_asistieron'] ?? 0) ?>
            </dd>
            <p class="text-sm text-purple-600 mt-1">confirmadas</p>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-4">
            <dt class="text-sm font-medium text-yellow-600">Certificados</dt>
            <dd class="mt-2 text-3xl font-bold text-yellow-900">
                <?= number_format($evento['estadisticas']['certificados_generados'] ?? 0) ?>
            </dd>
            <p class="text-sm text-yellow-600 mt-1">generados</p>
        </div>
    </div>
    
    <div class="mt-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Ocupación del Evento</span>
            <span class="text-sm text-gray-500">
                <?= $evento['estadisticas']['ocupacion_porcentaje'] ?? 0 ?>%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                 style="width: <?= min(100, $evento['estadisticas']['ocupacion_porcentaje'] ?? 0) ?>%">
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-1">
            <?= $evento['estadisticas']['ponentes_asignados'] ?? 0 ?> de <?= $evento['estadisticas']['cupo_maximo'] ?? 0 ?> cupos ocupados
        </p>
    </div>
    
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="border-l-4 border-blue-400 pl-4">
            <dt class="text-sm font-medium text-gray-500">Tasa de Asistencia</dt>
            <dd class="text-lg font-semibold text-gray-900">
                <?php 
                $totalPonentes = $evento['estadisticas']['ponentes_asignados'] ?? 0;
                $asistieron = $evento['estadisticas']['ponentes_asistieron'] ?? 0;
                $tasaAsistencia = $totalPonentes > 0 ? round(($asistieron / $totalPonentes) * 100, 1) : 0;
                echo $tasaAsistencia;
                ?>%
            </dd>
        </div>
        
        <div class="border-l-4 border-green-400 pl-4">
            <dt class="text-sm font-medium text-gray-500">Tasa de Certificación</dt>
            <dd class="text-lg font-semibold text-gray-900">
                <?php 
                $certificados = $evento['estadisticas']['certificados_generados'] ?? 0;
                $tasaCertificacion = $asistieron > 0 ? round(($certificados / $asistieron) * 100, 1) : 0;
                echo $tasaCertificacion;
                ?>%
            </dd>
        </div>
    </div>
</div>