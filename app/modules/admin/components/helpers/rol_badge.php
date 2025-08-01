<?php
// app/modules/admin/components/helpers/rol_badge.php

$rolClass = match($usuario['id_rol']) {
    1 => 'bg-purple-100 text-purple-800',
    2 => 'bg-blue-100 text-blue-800',
    3 => 'bg-green-100 text-green-800',
    4 => 'bg-yellow-100 text-yellow-800',
    default => 'bg-gray-100 text-gray-800'
};

$rolNombre = match($usuario['id_rol']) {
    1 => 'Administrador',
    2 => 'Ponente',
    3 => 'Invitado',
    4 => 'Control',
    default => 'Desconocido'
};
?>

<span class="inline-flex px-3 py-1.5 text-sm font-semibold rounded-full <?= $rolClass ?>">
    <?= $rolNombre ?>
</span>
