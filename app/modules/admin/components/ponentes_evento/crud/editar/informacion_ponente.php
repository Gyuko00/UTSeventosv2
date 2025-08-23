<?php
// app/modules/admin/components/ponentes_evento/crud/editar/informacion_ponente.php
?>
<div class="space-y-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Información del Ponente</h2>
        <span class="text-sm text-gray-500">(Solo lectura)</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre Completo</label>
            <p class="text-lg font-semibold text-gray-900">
                <?= htmlspecialchars($ponente['nombres'] . ' ' . $ponente['apellidos']) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Tema de Especialidad</label>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <?= htmlspecialchars($ponente['tema']) ?>
            </span>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Institución</label>
            <p class="text-base text-gray-900">
                <?= htmlspecialchars($ponente['institucion_ponente']) ?>
            </p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <label class="block text-sm font-medium text-gray-500 mb-1">Correo Personal</label>
            <p class="text-base text-gray-900">
                <?php if (!empty($ponente['correo_personal'])): ?>
                    <a href="mailto:<?= htmlspecialchars($ponente['correo_personal']) ?>" 
                       class="text-blue-600 hover:text-blue-800 hover:underline">
                        <?= htmlspecialchars($ponente['correo_personal']) ?>
                    </a>
                <?php else: ?>
                    <span class="text-gray-400">No registrado</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Campo oculto para mantener el ID del ponente -->
    <input type="hidden" name="speaker_event[id_ponente]" value="<?= htmlspecialchars($ponente['id_ponente']) ?>">
</div>