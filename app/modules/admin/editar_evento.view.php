<div class="space-y-10">
  <?php include __DIR__ . '\components\eventos\crud\editar\header.php'; ?>
    
  <?php include __DIR__ . '\components\eventos\crud\editar\alerta_error.php'; ?>
    
  <form
    id="editarEventoForm"
    method="POST"
    action="<?= URL_PATH ?>/admin/editarEvento/<?= $evento['id_evento'] ?>"
    class="space-y-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200"
  >
    <?php
      include __DIR__ . '\components\eventos\crud\editar\informacion_basica.php';
      include __DIR__ . '\components\eventos\crud\editar\detalles_evento.php';
      include __DIR__ . '\components\eventos\crud\editar\ubicacion_fecha.php';
      include __DIR__ . '\components\eventos\crud\editar\configuracion_adicional.php';
    ?>
        
    <?php include __DIR__ . '\components\eventos\crud\editar\botones_accion.php'; ?>
  </form>
</div>

<script>
    const URL_PATH = "<?= URL_PATH ?>";
    const EVENTO_ID = <?= $evento['id_evento'] ?>;
</script>
<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/editar_evento/main.js"></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>