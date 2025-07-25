<?php
// app/modules/admin/components/usuarios/tabla/usuario_rol.php
?>

<tr class="hover:bg-gray-50 usuario-row" 
    data-nombre="<?= strtolower($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>"
    data-usuario="<?= strtolower($usuario['usuario']) ?>"
    data-documento="<?= $usuario['numero_documento'] ?>"
    data-rol="<?= $usuario['id_rol'] ?>"
    data-activo="<?= $usuario['activo'] ?>">
    
    <!-- Columna Usuario -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($usuario['usuario']) ?></div>
                <div class="text-sm text-gray-500"><?= htmlspecialchars($usuario['correo_personal'] ?? 'Sin email') ?></div>
            </div>
        </div>
    </td>
    
    <!-- Columna Información Personal -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900"><?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?></div>
        <div class="text-sm text-gray-500"><?= htmlspecialchars($usuario['tipo_documento'] . ': ' . $usuario['numero_documento']) ?></div>
    </td>
    
    <!-- Columna Rol -->
    <td class="px-6 py-4 whitespace-nowrap">
        <?php include __DIR__ . '/../../../helpers/rol_badge.php'; ?>
    </td>
    
    <!-- Columna Estado -->
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $usuario['activo'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
        </span>
    </td>
    
    <!-- Columna Ubicación -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div><?= htmlspecialchars($usuario['municipio'] ?? 'N/A') ?></div>
        <div><?= htmlspecialchars($usuario['departamento'] ?? 'N/A') ?></div>
    </td>
    
    <!-- Columna Acciones -->
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <?php include __DIR__ . '/../../../helpers/acciones_usuario.php'; ?>
    </td>
</tr>