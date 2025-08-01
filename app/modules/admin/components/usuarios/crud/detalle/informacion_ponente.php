<div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-6 py-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-chalkboard-teacher text-2xl"></i>
            <h2 class="text-xl font-semibold">Información de Ponente</h2>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50 w-56">Tema</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['tema'] ?? '') ?></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Descripción Biográfica</td>
                    <td class="px-6 py-4 text-gray-900 max-w-md whitespace-pre-wrap break-words">
                        <?= nl2br(htmlspecialchars($usuario['descripcion_biografica'] ?? '')) ?>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Especialización</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['especializacion'] ?? '') ?></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Institución</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['institucion_ponente'] ?? '') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
