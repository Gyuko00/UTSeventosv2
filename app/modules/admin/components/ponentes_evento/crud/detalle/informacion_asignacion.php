<?php
// app/modules/admin/components/ponentes_evento/crud/detalle/informacion_asignacion.php
?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4 mb-6">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Información de Asignación</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    <?php if (!empty($ponente['hora_participacion'])): ?>
                        <?= date('H:i', strtotime($ponente['hora_participacion'])) ?>
                    <?php else: ?>
                        <span class="text-gray-400">--:--</span>
                    <?php endif; ?>
                </div>
                <div class="text-sm text-gray-500">Hora de Participación</div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <div class="text-center">
                <?php
                $estado_clase = '';
                $estado_texto = '';
                $estado_icono = '';
                switch ($ponente['estado_asistencia']) {
                    case 'confirmado':
                        $estado_clase = 'text-green-600';
                        $estado_texto = 'Confirmado';
                        $estado_icono = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                        break;
                    case 'pendiente':
                        $estado_clase = 'text-yellow-600';
                        $estado_texto = 'Pendiente';
                        $estado_icono = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                        break;
                    case 'cancelado':
                        $estado_clase = 'text-red-600';
                        $estado_texto = 'Cancelado';
                        $estado_icono = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                        break;
                    default:
                        $estado_clase = 'text-gray-600';
                        $estado_texto = 'Sin estado';
                        $estado_icono = '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>';
                }
                ?>
                <div class="flex items-center justify-center gap-2 mb-1">
                    <svg class="w-6 h-6 <?= $estado_clase ?>" fill="currentColor" viewBox="0 0 20 20">
                        <?= $estado_icono ?>
                    </svg>
                    <span class="text-lg font-semibold <?= $estado_clase ?>"><?= $estado_texto ?></span>
                </div>
                <div class="text-sm text-gray-500">Estado de Asistencia</div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <div class="text-center">
                <?php if ($ponente['certificado_generado'] == 1): ?>
                    <div class="flex items-center justify-center gap-2 mb-1">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-lg font-semibold text-blue-600">Generado</span>
                    </div>
                <?php else: ?>
                    <div class="flex items-center justify-center gap-2 mb-1">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-lg font-semibold text-gray-400">Pendiente</span>
                    </div>
                <?php endif; ?>
                <div class="text-sm text-gray-500">Certificado</div>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="text-sm text-gray-500">
            <strong>Fecha de registro:</strong> 
            <?= date('d/m/Y H:i', strtotime($ponente['fecha_registro'])) ?>
        </div>
    </div>
</div>