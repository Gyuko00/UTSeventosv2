<!--
Header layout para usuarios

Incluye navegación para las distintas funcionalidades del usuario como: consultar eventos a los que 
esté inscrito, ver/editar su perfil y cerrar sesión.
-->

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core'
    . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'Index.layout.php';
?>

<header class="bg-[#c9d230] shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-[#2e7d32]">UTSeventos</h1>

    <nav class="space-x-4 hidden md:flex items-center">
      <a href="<?= URL_PATH ?>/user/home" class="text-[#2e7d32] font-medium hover:underline">Eventos</a>
      <a href="<?= URL_PATH ?>/user/misEventos" class="text-[#2e7d32] font-medium hover:underline">Mis eventos</a>
      <a href="<?= URL_PATH ?>/user/perfil" class="text-[#2e7d32] font-medium hover:underline">Perfil</a>
      <a href="<?= URL_PATH ?>/auth/logout" class="text-red-600 font-medium hover:underline">Cerrar sesión</a>
    </nav>

    <!-- Versión móvil -->
    <div class="md:hidden text-sm text-[#2e7d32]">
      <?= $_SESSION['nombre'] ?? 'Invitado' ?>
    </div>
  </div>
</header>