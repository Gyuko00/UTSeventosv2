<div class="space-y-8">
  <?php include __DIR__ . '\components\usuarios\crud\editar\header.php'; ?>

  <?php include __DIR__ . '\components\usuarios\crud\editar\estado_usuario.php'; ?>

  <?php include __DIR__ . '\components\usuarios\crud\editar\alerta_error.php'; ?>

  <form
    id="editarUsuarioForm"
    method="POST"
    action="<?= URL_PATH ?>/admin/editarUsuario/<?= $usuario['id_usuario'] ?>"
    class="space-y-8"
  >
    <?php
      $usuarioData = $usuario;
      include __DIR__ . '\components\usuarios\crud\editar\informacion_personal.php';
      include __DIR__ . '\components\usuarios\crud\editar\informacion_usuario.php';

      if ($usuario['id_rol'] == 2) {
        include __DIR__ . '\components\usuarios\crud\editar\campos_ponente.php';
      } elseif ($usuario['id_rol'] == 3) {
        include __DIR__ . '\components\usuarios\crud\editar\campos_invitado.php';
      }
    ?>

    <?php include __DIR__ . '\components\usuarios\crud\editar\botones_accion.php'; ?>
  </form>
</div>

<script>
  window.URL_PATH = "<?= URL_PATH ?>";
</script>

<script
  type="module"
  src="<?= URL_PATH ?>/assets/js/admin/user/editar_usuario/main.js"
></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>