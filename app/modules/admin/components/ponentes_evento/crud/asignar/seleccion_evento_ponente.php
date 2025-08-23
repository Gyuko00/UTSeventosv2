<!-- components\ponentes_evento\crud\asignar\seleccion_evento_ponente.php -->
<div class="space-y-6">
    <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
            <i class="fas fa-info-circle text-green-600"></i>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Información de Asignación</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-3">
            <label for="id_evento" class="block text-sm font-medium text-gray-700">
                Evento <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select 
                    id="id_evento"
                    name="speaker_event[id_evento]"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none bg-white"
                >
                    <option value="">Seleccionar evento...</option>
                    <?php if (isset($eventos) && is_array($eventos)): ?>
                        <?php foreach ($eventos as $evento): ?>
                            <option value="<?= htmlspecialchars($evento['id_evento']) ?>">
                                <?= htmlspecialchars($evento['titulo_evento']) ?> - <?= htmlspecialchars($evento['fecha']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Selecciona el evento al cual asignar el ponente</p>
        </div>

        <div class="space-y-3">
            <label for="id_ponente" class="block text-sm font-medium text-gray-700">
                Ponente <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select 
                    id="id_ponente"
                    name="speaker_event[id_ponente]"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none bg-white"
                >
                    <option value="">Seleccionar ponente...</option>
                    <?php if (isset($ponentes) && is_array($ponentes)): ?>
                        <?php
                        $ponentesUnicos = [];
                        foreach ($ponentes as $ponente) {
                            if (!isset($ponentesUnicos[$ponente['id_ponente']])) {
                                $ponentesUnicos[$ponente['id_ponente']] = $ponente;
                            }
                        }
                        ?>
                        <?php foreach ($ponentesUnicos as $ponente): ?>
                            <option value="<?= htmlspecialchars($ponente['id_ponente']) ?>">
                                <?= htmlspecialchars($ponente['nombres'] . ' ' . $ponente['apellidos']) ?> - <?= htmlspecialchars($ponente['tema']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500">Selecciona el ponente que participará en el evento</p>
        </div>
    </div>
</div>