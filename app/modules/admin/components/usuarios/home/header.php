<?php
// app/modules/admin/components/usuarios/header.php
?>

<!-- Header -->
<div class="bg-gradient-to-r from-lime-600 to-lime-700 rounded-xl shadow-lg p-6 mb-6">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-white mb-2">Gestión de Usuarios</h1>
      <p class="text-lime-100 opacity-90">Administra todos los usuarios del sistema</p>
    </div>
    <a href="<?= URL_PATH ?>/admin/crearUsuario"
       class="bg-white hover:bg-lime-50 text-lime-700 font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
      <i class="fas fa-plus"></i>
      Nuevo Usuario
    </a>
  </div>
</div>