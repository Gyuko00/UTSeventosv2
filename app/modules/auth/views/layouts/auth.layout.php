<!--
auth.layout.php

Layout principal del módulo de autenticación. Incluye el header y el footer
específicos del módulo auth, y renderiza contenido dinámico en el centro.
-->

<?php require __DIR__ . '/header.layout.php'; ?>

<main class="flex-grow">
  <div class="max-w-3xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <?= $content ?>
  </div>
</main>

<?php require __DIR__ . '/footer.layout.php'; ?>
