<!--
 * HEADER DE AUTENTICACIÓN
 * 
 * Componente de cabecera para páginas de login y registro del sistema
 * UTSeventos. Implementa diseño responsivo con menú hamburguesa para
 * móviles utilizando TailwindCSS y colores corporativos UTS.
 * 
 * Características:
 * - Navegación responsive con menú hamburguesa
 * - Colores corporativos UTS (#c9d230, #2e7d32, #a5c93a)
 * - Enlaces entre formularios de Login y Registro
 * - Integración con sistema de rutas (URL_PATH)
 *
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
        <a href="<?= URL_PATH ?>/auth/login" class="text-white font-medium hover:text-lime-100 transition">Inicio de sesión</a>
        <a href="<?= URL_PATH ?>/auth/register" class="text-white font-medium hover:text-lime-100 transition">Registrarse</a>
      </nav>

      <button id="menu-toggle" class="md:hidden focus:outline-none p-2 rounded-md hover:bg-lime-500 transition">
        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <div id="menu" class="hidden md:hidden mt-3 space-y-2 bg-lime-700 rounded-md p-2">
      <a href="<?= URL_PATH ?>/auth/login" class="block text-white font-medium hover:bg-lime-600 px-3 py-2 rounded-md transition">Inicio de sesión</a>
      <a href="<?= URL_PATH ?>/auth/register" class="block text-white font-medium hover:bg-lime-600 px-3 py-2 rounded-md transition">Registrarse</a>
    </div>
  </div>
</header>


<script src="<?= URL_PATH ?>/assets/js/auth/header_menu.js"></script>
