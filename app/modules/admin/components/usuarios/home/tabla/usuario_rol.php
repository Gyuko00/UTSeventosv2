<?php
// app/modules/admin/components/usuarios/tabla/usuario_rol.php
?>

<tr class="hover:bg-gray-50 usuario-row transition-colors duration-150"
    data-nombre="<?= strtolower($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>"
    data-usuario="<?= strtolower($usuario['usuario']) ?>"
    data-documento="<?= $usuario['numero_documento'] ?>"
    data-rol="<?= $usuario['id_rol'] ?>"
    data-activo="<?= $usuario['activo'] ?>">
    
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="h-11 w-11 flex-shrink-0 rounded-full bg-blue-100 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 640 640">
                    <path d="M320 320C386.3 320 440 266.3 440 200S386.3 80 320 80 200 133.7 200 200s53.7 120 120 120zm-29.7 56C191.8 376 112 455.8 112 554.3c0 16.4 13.3 29.7 29.7 29.7h356.6c16.4 0 29.7-13.3 29.7-29.7C528 455.8 448.2 376 349.7 376H290.3z"/>
                </svg>
            </div>
            <div>
                <div class="text-base font-semibold text-gray-900 leading-5">
                    <?= htmlspecialchars($usuario['usuario']) ?>
                </div>
                <div class="text-sm text-gray-600 leading-4">
                    <?= htmlspecialchars($usuario['correo_personal'] ?? 'Sin email') ?>
                </div>
            </div>
        </div>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-base font-medium text-gray-900 leading-5">
            <?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>
        </div>
        <div class="text-sm text-gray-600 leading-4">
            <?= htmlspecialchars($usuario['tipo_documento'] . ': ' . $usuario['numero_documento']) ?>
        </div>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap">
        <?php include __DIR__ . '/../../../helpers/rol_badge.php'; ?>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full <?= $usuario['activo'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
        </span>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-600 leading-5">
        <div><?= htmlspecialchars($usuario['municipio'] ?? 'N/A') ?></div>
        <div class="text-sm text-gray-500"><?= htmlspecialchars($usuario['departamento'] ?? 'N/A') ?></div>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
        <?php
        $archivo_acciones = __DIR__ . '\..\..\..\helpers\acciones_usuario.php';
        if (file_exists($archivo_acciones)) {
            include $archivo_acciones;
        } else {
            echo 'Archivo no encontrado: ' . $archivo_acciones;
        }
        ?>
    </td>
</tr>
