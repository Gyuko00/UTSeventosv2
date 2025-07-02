<!--
auth.layout.php

Layout principal del módulo de autenticación.
Solo muestra el contenido dinámico (por ejemplo: login o registro).
-->

<?php require __DIR__ . '/header.layout.php'; ?>

<main class="min-h-screen flex bg-white">
  <div class="w-full flex flex-col justify-center px-6 py-12">
    <?= $content ?>
  </div>
</main>

<?php require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . 
  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'core' . 
  DIRECTORY_SEPARATOR . 'footer.layout.php'; ?>
