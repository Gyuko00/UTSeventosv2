<div class="space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Crear Usuario</h1>
      <p class="text-gray-600 mt-1">Registra un nuevo usuario en el sistema</p>
    </div>
    <a
      href="<?= URL_PATH ?>/admin/listarUsuarios"
      class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center gap-2"
    >
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </div>

  <!-- Error -->
  <?php include __DIR__ . '\components\usuarios\crud\crear\alerta_error.php'; ?>

  <!-- Formulario -->
  <form
    id="crearUsuarioForm"
    method="POST"
    action="<?= URL_PATH ?>/admin/crearUsuario"
    class="space-y-8"
  >
    <?php
            include __DIR__ . '\components\usuarios\crud\crear\informacion_personal.php';
            include __DIR__ . '\components\usuarios\crud\crear\informacion_usuario.php';
            include __DIR__ . '\components\usuarios\crud\crear\campos_ponente.php';
            include __DIR__ . '\components\usuarios\crud\crear\campos_invitado.php';
        ?>

    <!-- Botones de acción -->
    <div class="flex justify-end gap-4">
      <a
        href="<?= URL_PATH ?>/admin/listarUsuarios"
        class="px-6 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200"
        >Cancelar</a
      >
      <button
        type="submit"
        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2"
      >
        <i class="fas fa-save"></i> Crear Usuario
      </button>
    </div>
  </form>
</div>

<script
  type="module"
  src="<?= URL_PATH ?>/assets/js/admin/user/crear_usuario/main.js"
></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>
