<div class="space-y-10">
  <?php include __DIR__ . '\components\eventos\crud\crear\header.php'; ?>
  
  <?php include __DIR__ . '\components\eventos\crud\crear\alerta_error.php'; ?>
  
  <form 
    id="crearEventoForm" 
    method="POST" 
    action="<?= URL_PATH ?>/admin/crearEvento"
    class="space-y-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200"
  >
    <input type="hidden" name="id_usuario_creador" value="<?= $_SESSION['id_usuario'] ?>">
    <?php
      include __DIR__ . '\components\eventos\crud\crear\informacion_basica.php';
      include __DIR__ . '\components\eventos\crud\crear\detalles_evento.php';
      include __DIR__ . '\components\eventos\crud\crear\ubicacion_fecha.php';
      include __DIR__ . '\components\eventos\crud\crear\configuracion_adicional.php';
    ?>
    
    <?php include __DIR__ . '\components\eventos\crud\crear\botones_accion.php'; ?>
  </form>
</div>

<script>
    const URL_PATH = "<?= URL_PATH ?>";
</script>
<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/crear_evento/main.js"></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>
