<!--
User layout

Layout principal del módulo de usuarios.
Solo muestra el contenido dinámico (por ejemplo: eventos, mis eventos, perfil).
-->

<?php require __DIR__ . '/header.layout.php'; ?>

<main class="min-h-screen bg-white">
  <div class="max-w-7xl mx-auto px-4 py-8">
    <?= $content ?>
  </div>
</main>

<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core'
    . DIRECTORY_SEPARATOR . 'footer.layout.php'; ?>