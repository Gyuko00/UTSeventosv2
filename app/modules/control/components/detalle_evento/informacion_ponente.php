<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/informacion_ponente.php
?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Información del Ponente Asignado</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars(($evento['ponente']['ponente_nombres'] ?? '') . ' ' . ($evento['ponente']['ponente_apellidos'] ?? '')) ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Usuario</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['ponente']['ponente_usuario'] ?? 'No disponible') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Documento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['ponente']['ponente_tipo_documento'] ?? '') ?> - 
                <?= htmlspecialchars($evento['ponente']['ponente_numero_documento'] ?? '') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <a href="mailto:<?= htmlspecialchars($evento['ponente']['ponente_email'] ?? '') ?>" 
                   class="text-blue-600 hover:text-blue-500">
                    <?= htmlspecialchars($evento['ponente']['ponente_email'] ?? 'No disponible') ?>
                </a>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['ponente']['ponente_telefono'] ?? 'No disponible') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Hora de Participación</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['ponente']['hora_participacion']) ? 
                    date('H:i', strtotime($evento['ponente']['hora_participacion'])) : 'No especificada' ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Estado de Asistencia</dt>
            <dd class="mt-1">
                <?php
                $estado = $evento['ponente']['estado_asistencia'] ?? 'pendiente';
                $clases = [
                    'asistio' => 'bg-green-100 text-green-800',
                    'no_asistio' => 'bg-red-100 text-red-800',
                    'pendiente' => 'bg-yellow-100 text-yellow-800'
                ];
                $textos = [
                    'asistio' => 'Asistió',
                    'no_asistio' => 'No Asistió',
                    'pendiente' => 'Pendiente'
                ];
                ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $clases[$estado] ?? $clases['pendiente'] ?>">
                    <?= $textos[$estado] ?? 'Desconocido' ?>
                </span>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Certificado</dt>
            <dd class="mt-1">
                <?php if (($evento['ponente']['certificado_generado'] ?? 0) == 1): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Generado
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Pendiente
                    </span>
                <?php endif; ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= !empty($evento['ponente']['fecha_registro']) ? 
                    date('d/m/Y H:i', strtotime($evento['ponente']['fecha_registro'])) : 'No disponible' ?>
            </dd>
        </div>
    </div>
</div>