<div class="space-y-10">
  <!-- Header -->
  <?php include __DIR__ . '\components\usuarios\crud\crear\header.php'; ?>

  <!-- Error -->
  <?php include __DIR__ . '\components\usuarios\crud\crear\alerta_error.php'; ?>

  <!-- Formulario -->
  <form
    id="crearUsuarioForm"
    method="POST"
    action="<?= URL_PATH ?>/admin/crearUsuario"
    class="space-y-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200"
  >
    <?php
      include __DIR__ . '\components\usuarios\crud\crear\informacion_personal.php';
      include __DIR__ . '\components\usuarios\crud\crear\informacion_usuario.php';
      include __DIR__ . '\components\usuarios\crud\crear\campos_ponente.php';
      include __DIR__ . '\components\usuarios\crud\crear\campos_invitado.php';
    ?>

    <!-- Botones -->
    <?php include __DIR__ . '\components\usuarios\crud\crear\botones_accion.php'; ?>
  </form>
</div>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/user/crear_usuario/main.js"></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>
