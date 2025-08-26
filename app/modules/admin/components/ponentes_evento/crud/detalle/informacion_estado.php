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
    </div>
</div>

