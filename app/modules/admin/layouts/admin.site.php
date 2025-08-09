<!-- /**
 * LAYOUT PRINCIPAL DE ADMINISTRADOR
 * 
 * Layout centralizado para el módulo de administrador que estructura
 * las páginas de login y registro. Proporciona un contenedor centrado
 * con diseño de tarjeta para los formularios de autenticación.
 * 
 * Características:
 * - Contenedor que ocupa casi todo el viewport
 * - Diseño de tarjeta con sombra y bordes redondeados
 * - Altamente responsive con breakpoints adaptativos
 * - Integración con header y footer del sistema
 * - Renderizado dinámico de contenido mediante variable $content
 * 
 */ -->

<?php require __DIR__ . '/header.layout.php'; ?>

<main class="min-h-screen flex flex-col bg-gray-50">
  <div class="flex-grow flex items-center justify-center p-2 sm:p-4 lg:p-6">
    <div class="w-full max-w-full sm:max-w-6xl lg:max-w-7xl xl:max-w-screen-2xl">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden min-h-[85vh] sm:min-h-[80vh]">
        <div class="p-4 sm:p-6 lg:p-8 xl:p-10 h-full">
          <?= $content ?? '' ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require __DIR__ . '\..\..\..\core\layouts\footer.layout.php'; ?>