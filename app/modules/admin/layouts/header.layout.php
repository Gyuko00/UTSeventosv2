<!--
 * HEADER DE ADMINISTRADOR
 * 
 * Componente de cabecera para páginas del sistema administrador
 * UTSeventos. Implementa diseño responsivo con menú hamburguesa para
 * móviles utilizando TailwindCSS y colores corporativos UTS.
-->

<?php require __DIR__ . '\..\..\..\core\layouts\html.layout.php'; ?>

<header class="bg-gradient-to-r from-lime-600 to-lime-700 shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex justify-between items-center">
      <div class="flex items-center gap-2">
        <i class="fas fa-calendar-alt text-white text-xl"></i>
        <h1 class="text-2xl font-bold text-white">UTSeventos</h1>
      </div>

      <nav class="hidden md:flex space-x-6">
        <a href="<?= URL_PATH ?>/admin/home" class="text-white font-medium hover:text-lime-100 transition">Inicio</a>
        <a href="<?= URL_PATH ?>/admin/listarUsuarios" class="text-white font-medium hover:text-lime-100 transition">Gestionar Usuarios</a>
        <a href="<?= URL_PATH ?>/admin/listarEventos" class="text-white font-medium hover:text-lime-100 transition">Gestionar Eventos</a>
        <a href="<?= URL_PATH ?>/admin/cerrarSesion" class="text-red-200 font-medium hover:text-red-100 transition">Cerrar sesión</a>
      </nav>

      <button id="menu-toggle" class="md:hidden focus:outline-none">
        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
          <path d="M4 5h16M4 12h16M4 19h16" />
        </svg>
      </button>
    </div>

    <div id="menu" class="hidden md:hidden mt-3 space-y-2">
      <a href="<?= URL_PATH ?>/admin/home" class="block text-white font-medium hover:bg-lime-600 px-3 py-2 rounded-md transition">Inicio</a>
      <a href="<?= URL_PATH ?>/admin/listarUsuarios" class="block text-white font-medium hover:bg-lime-600 px-3 py-2 rounded-md transition">Gestionar Usuarios</a>
      <a href="<?= URL_PATH ?>/admin/listarEventos" class="block text-white font-medium hover:bg-lime-600 px-3 py-2 rounded-md transition">Gestionar Eventos</a>
      <a href="<?= URL_PATH ?>/admin/cerrarSesion" class="block text-red-200 font-medium hover:text-red-100 px-3 py-2 rounded-md transition">Cerrar sesión</a>
    </div>
  </div>
</header>


<script src="<?= URL_PATH ?>/assets/js/admin/header_menu.js"></script>
