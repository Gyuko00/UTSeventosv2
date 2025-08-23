<?php
// app/modules/admin/components/ponentes_evento/crud/detalle/informacion_evento.php
?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4 mb-6">
        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Información del Evento</h2>
    </div>

    <div class="space-y-6">
        <!-- Información básica del evento -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Título del Evento</label>
                <p class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars($ponente['titulo_evento']) ?>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tema</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <?= htmlspecialchars($ponente['tema_evento']) ?>
                </span>
            </div>
        </div>

        <!-- Descripción -->
        <?php if (!empty($ponente['descripcion'])): ?>
        <div>
            <label class="block text-sm font-medium text-gray-500 mb-1">Descripción</label>
            <p class="text-base text-gray-900 bg-gray-50 rounded-lg p-4">
                <?= nl2br(htmlspecialchars($ponente['descripcion'])) ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Fecha y horario -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-lg font-bold text-purple-900">
                    <?= date('d/m/Y', strtotime($ponente['fecha'])) ?>
                </div>
                <div class="text-sm text-purple-600">Fecha del Evento</div>
            </div>

            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-lg font-bold text-purple-900">
                    <?= date('H:i', strtotime($ponente['hora_inicio'])) ?>
                </div>
                <div class="text-sm text-purple-600">Hora de Inicio</div>
            </div>

            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-lg font-bold text-purple-900">
                    <?= date('H:i', strtotime($ponente['hora_fin'])) ?>
                </div>
                <div class="text-sm text-purple-600">Hora de Fin</div>
            </div>
        </div>

        <!-- Ubicación -->
        <div>
            <label class="block text-sm font-medium text-gray-500 mb-3">Ubicación</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-4">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <div class="font-medium text-gray-900">
                            <?= htmlspecialchars($ponente['municipio_evento']) ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?= htmlspecialchars($ponente['departamento_evento']) ?>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-4">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <div>
                        <div class="font-medium text-gray-900">
                            <?= htmlspecialchars($ponente['institucion_evento']) ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?= htmlspecialchars($ponente['lugar_detallado']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium text-gray-900">Cupo Máximo</span>
                </div>
                <div class="text-2xl font-bold text-gray-900">
                    <?= htmlspecialchars($ponente['cupo_maximo']) ?>
                </div>
                <div class="text-sm text-gray-500">personas</div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium text-gray-900">Creado por</span>
                </div>
                <div class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars($ponente['creador_nombres'] . ' ' . $ponente['creador_apellidos']) ?>
                </div>
                <div class="text-sm text-gray-500">
                    @<?= htmlspecialchars($ponente['creador_usuario']) ?>
                </div>
            </div>
        </div>
    </div>
</div>