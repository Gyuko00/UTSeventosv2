<?php
// app/modules/admin/components/ponentes_evento/crud/editar/configuracion_participacion.php
?>
<div class="space-y-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Configuración de Participación</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-3">
            <label for="hora_participacion" class="block text-sm font-medium text-gray-700">
                Hora de Participación <span class="text-red-500">*</span>
            </label>
            <input
                type="time"
                id="hora_participacion"
                name="speaker_event[hora_participacion]"
                required
                value="<?= !empty($ponente['hora_participacion']) ? htmlspecialchars(date('H:i', strtotime($ponente['hora_participacion']))) : '' ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            >
            <p class="text-xs text-gray-500">Hora específica de la participación del ponente</p>
        </div>

        <div class="space-y-3">
            <label for="estado_asistencia" class="block text-sm font-medium text-gray-700">
                Estado de Asistencia <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select 
                    id="estado_asistencia"
                    name="speaker_event[estado_asistencia]"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none bg-white"
                >
                    <option value="">Seleccionar estado...</option>
                    <option value="confirmado" <?= ($ponente['estado_asistencia'] ?? '') === 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                    <option value="pendiente" <?= ($ponente['estado_asistencia'] ?? '') === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="cancelado" <?= ($ponente['estado_asistencia'] ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    <option value="ausente" <?= ($ponente['estado_asistencia'] ?? '') === 'ausente' ? 'selected' : '' ?>>Ausente</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Estado actual de la asistencia del ponente</p>
        </div>
    </div>

    <div class="space-y-3">
        <label class="flex items-center gap-3">
            <input 
                type="checkbox"
                id="certificado_generado"
                name="speaker_event[certificado_generado]"
                value="1"
                <?= ($ponente['certificado_generado'] ?? 0) == 1 ? 'checked' : '' ?>
                class="w-4 h-4 text-green-600 border border-gray-300 rounded focus:ring-green-500 focus:ring-2"
            >
            <span class="text-sm font-medium text-gray-700">Certificado generado</span>
        </label>
        <p class="text-xs text-gray-500 ml-7">Marcar si ya se ha generado el certificado de participación</p>
    </div>

    <div class="space-y-3">
        <label for="fecha_registro" class="block text-sm font-medium text-gray-700">
            Fecha de Registro
        </label>
        <input 
            type="datetime-local"
            id="fecha_registro"
            name="speaker_event[fecha_registro]"
            value="<?= !empty($ponente['fecha_registro']) ? date('Y-m-d\TH:i', strtotime($ponente['fecha_registro'])) : date('Y-m-d\TH:i') ?>"
            readonly
            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
        >
        <p class="text-xs text-gray-500">Fecha y hora de registro de la asignación</p>
    </div>
</div>