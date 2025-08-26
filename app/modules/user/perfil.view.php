<?php
require_once __DIR__ . '/helpers/html.php';
?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4">
    
    <?php include_once __DIR__ . '/components/perfil/header.php'; ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Columna Principal (2/3) -->
      <div class="lg:col-span-2 space-y-6">
        <?php include_once __DIR__ . '/components/perfil/form_informacion_personal.php'; ?>
        
        <div id="mis-eventos-container">
          <?php include_once __DIR__ . '/components/perfil/mis_eventos.php'; ?>
        </div>
      </div>
      
      <!-- Columna Lateral (1/3) -->
      <div class="space-y-6">
        <?php include_once __DIR__ . '/components/perfil/info_cuenta.php'; ?>
        <?php include_once __DIR__ . '/components/perfil/form_cambiar_contrasena.php'; ?>
        <?php include_once __DIR__ . '/components/perfil/acciones_rapidas.php'; ?>
      </div>
      
    </div>
  </div>
</div>

<script>
  const URL_PATH = "<?= URL_PATH ?>";
</script>

<script type="module" src="<?= URL_PATH ?>/assets/js/user/profile/perfil/index.js"></script>
<script type="module" src="<?= URL_PATH ?>/assets/js/user/profile/mis_eventos/index.js"></script>

