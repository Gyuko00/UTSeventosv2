<!-- app/views/user/perfil.view.php -->

<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Mi perfil</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800">
    <div><strong>Tipo de documento:</strong> <?= htmlspecialchars($perfil['tipo_documento']) ?></div>
    <div><strong>Número de documento:</strong> <?= htmlspecialchars($perfil['numero_documento']) ?></div>
    <div><strong>Nombres:</strong> <?= htmlspecialchars($perfil['nombres']) ?></div>
    <div><strong>Apellidos:</strong> <?= htmlspecialchars($perfil['apellidos']) ?></div>
    <div><strong>Teléfono:</strong> <?= htmlspecialchars($perfil['telefono']) ?></div>
    <div><strong>Correo personal:</strong> <?= htmlspecialchars($perfil['correo_personal']) ?></div>
    <div><strong>Departamento:</strong> <?= htmlspecialchars($perfil['departamento']) ?></div>
    <div><strong>Municipio:</strong> <?= htmlspecialchars($perfil['municipio']) ?></div>
    <div><strong>Dirección:</strong> <?= htmlspecialchars($perfil['direccion']) ?></div>
    <div><strong>Usuario:</strong> <?= htmlspecialchars($perfil['usuario']) ?></div>
  </div>

  <div class="mt-6 flex justify-between">
    <a href="<?= URL_PATH ?>/user/home" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Volver</a>
    <a href="<?= URL_PATH ?>/user/editarPerfil" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Editar perfil</a>
  </div>
</div>
