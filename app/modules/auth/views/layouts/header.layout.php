<!--
Header layout para autenticación (login y register)

Utiliza TailwindCSS y colores asociados a la identidad UTS.
Incluye navegación entre Login y Registro. Responsive y accesible.
-->

<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . 
  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core' . 
  DIRECTORY_SEPARATOR . 'Index.layout.php'; ?>

<header class="bg-[#c9d230] shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    
    <!-- Versión MÓVIL: Solo visible en pantallas MUY pequeñas -->
    <div class="block md:hidden text-center">
      <h1 class="text-2xl font-bold text-[#2e7d32] mb-3">UTSeventos</h1>
      <nav class="space-y-2">
        <a href="<?= URL_PATH ?>/auth/loginForm" class="text-[#2e7d32] font-medium hover:underline block">Inicio de sesión</a>
        <a href="<?= URL_PATH ?>/auth/registerForm" class="text-[#2e7d32] font-medium hover:underline block">Registrarse</a>
      </nav>
    </div>
    
    <!-- Versión DESKTOP: Solo visible en pantallas medianas y grandes -->
    <div class="hidden md:flex md:justify-between md:items-center">
      <h1 class="text-2xl font-bold text-[#2e7d32]">UTSeventos</h1>
      <nav class="space-x-4">
        <a href="<?= URL_PATH ?>/auth/loginForm" class="text-[#2e7d32] font-medium hover:underline">Inicio de sesión</a>
        <a href="<?= URL_PATH ?>/auth/registerForm" class="text-[#2e7d32] font-medium hover:underline">Registrarse</a>
      </nav>
    </div>
    
  </div>
</header>
