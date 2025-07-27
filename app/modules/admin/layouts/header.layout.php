<!--
 * HEADER DE ADMINISTRADOR
 * 
 * Componente de cabecera para páginas del sistema administrador
 * UTSeventos. Implementa diseño responsivo con menú hamburguesa para
 * móviles utilizando TailwindCSS y colores corporativos UTS.
-->

<?php require __DIR__ . '\..\..\..\core\layouts\html.layout.php'; ?>

<header class="bg-[#c9d230] shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-[#2e7d32]">UTSeventos</h1>
      <nav class="hidden md:flex space-x-4">
        <a href="<?= URL_PATH ?>/admin/home" class="text-[#2e7d32] font-medium hover:text-[#1b5e20]">Inicio</a>
        <a href="<?= URL_PATH ?>/admin/listarUsuarios" class="text-[#2e7d32] font-medium hover:text-[#1b5e20]">Gestionar Usuarios</a>
        <a href="<?= URL_PATH ?>/admin/listarEventos" class="text-[#2e7d32] font-medium hover:text-[#1b5e20]">Gestionar Eventos</a>
        <a href="<?= URL_PATH ?>/admin/cerrarSesion" class="text-red-600 font-medium hover:underline">Cerrar sesión</a>
      </nav>
      <button id="menu-toggle" class="md:hidden focus:outline-none">
        <svg class="h-6 w-6 fill-current text-[#2e7d32]" viewBox="0 0 24 24">
          <path d="M4 5h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2zm0 6h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2zm0 6h16a1 1 0 0 0 0-2H4a1 1 0 1 0 0 2z"></path>
        </svg>
      </button>
    </div>
    <div id="menu" class="hidden md:hidden mt-3 space-y-2">
      <a href="<?= URL_PATH ?>/admin/home" class="block text-[#2e7d32] font-medium hover:bg-[#a5c93a] px-3 py-2 rounded-md">Inicio</a>
      <a href="<?= URL_PATH ?>/admin/listarUsuarios" class="block text-[#2e7d32] font-medium hover:bg-[#a5c93a] px-3 py-2 rounded-md">Gestionar Usuarios</a>
      <a href="<?= URL_PATH ?>/admin/listarEventos" class="block text-[#2e7d32] font-medium hover:bg-[#a5c93a] px-3 py-2 rounded-md">Gestionar Eventos</a>
      <a href="<?= URL_PATH ?>/admin/cerrarSesion" class="block text-red-600 font-medium hover:underline">Cerrar sesión</a>
    </div>
  </div>
</header>

<script src="<?= URL_PATH ?>/assets/js/admin/header_menu.js"></script>
