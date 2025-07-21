<?php require __DIR__ . '\..\..\..\core\layouts\html.layout.php'; ?>

<main class="min-h-screen flex flex-col bg-gray-50">
  <div class="flex-grow flex items-center justify-center p-4">
    <div class="w-full max-w-3xl">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
          <?= $content ?? '' ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require __DIR__ . '\..\..\..\core\layouts\footer.layout.php'; ?>