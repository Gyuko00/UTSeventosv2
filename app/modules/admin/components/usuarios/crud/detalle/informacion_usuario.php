<div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-6 py-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-cog text-2xl"></i>
            <h2 class="text-xl font-semibold">Información de Usuario</h2>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50 w-56">Usuario</td>
                    <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['usuario'] ?? '') ?></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Rol</td>
                    <td class="px-6 py-4">
                        <?php 
                        $rolClass = '';
                        $rolNombre = $usuario['nombre_rol'] ?? '';
                        switch(strtolower($rolNombre)) {
                            case 'administrador': $rolClass = 'bg-blue-100 text-blue-800'; break;
                            case 'ponente': $rolClass = 'bg-yellow-100 text-yellow-800'; break;
                            case 'invitado': $rolClass = 'bg-gray-100 text-gray-800'; break;
                            case 'control': $rolClass = 'bg-purple-100 text-purple-800'; break;
                            default: $rolClass = 'bg-gray-100 text-gray-800';
                        }
                        ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold <?= $rolClass ?>">
                            <?= htmlspecialchars($rolNombre) ?>
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Estado</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold <?= ($usuario['activo'] ?? 0) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= ($usuario['activo'] ?? 0) ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
