<?php
// app/modules/admin/components/usuarios/header.php
?>

<!-- Header -->
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h1>
        <p class="text-gray-600 mt-1">Administra todos los usuarios del sistema</p>
    </div>
    <a href="<?= URL_PATH ?>/admin/crearUsuario" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Nuevo Usuario
    </a>
</div>