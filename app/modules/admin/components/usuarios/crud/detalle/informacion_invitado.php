<div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-6 py-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-friends text-2xl"></i>
            <h2 class="text-xl font-semibold">Información de Invitado</h2>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50 w-56">Tipo de Invitado</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['tipo_invitado'] ?? '') ?></td>
                </tr>

                <?php if (!empty($usuario['correo_institucional'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Correo Institucional</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['correo_institucional']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['programa_academico'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Programa Académico</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['programa_academico']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['nombre_carrera'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Nombre de la Carrera</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['nombre_carrera']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['jornada'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Jornada</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['jornada']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['facultad'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Facultad</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['facultad']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['cargo'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Cargo</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['cargo']) ?></td>
                </tr>
                <?php endif; ?>

                <?php if (!empty($usuario['sede_institucion'])): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Sede Institución</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['sede_institucion']) ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
