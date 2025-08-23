<?php // app/modules/admin/ponentes_evento.view.php ?>

<div class="space-y-6">
    <?php include_once __DIR__ . '\components\ponentes_evento\home\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\home\filtros.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\home\mensajes.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\home\tabla.php'; ?>
</div>

<script>
  if (typeof window.URL_PATH === 'undefined') {
    window.URL_PATH = "<?= URL_PATH ?>";
  }
</script>


<script src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/eliminar_asignacion/eliminar.js"></script>


