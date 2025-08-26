<?php
// app/modules/user/components/perfil/form_informacion_personal.php
$tipoDoc = $perfil['tipo_documento'] ?? '';
?>
<div class="bg-white rounded-xl shadow-md border border-gray-100">
  <div class="p-6 border-b border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
      <svg class="w-5 h-5 text-lime-600" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
      </svg>
      Información Personal
    </h2>
  </div>

  <div class="p-6">
    <form id="form-perfil" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="tipo_documento" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
          <select id="tipo_documento" name="tipo_documento" required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500">
            <option value="CC" <?= selected_attr($tipoDoc, 'CC') ?>>Cédula de Ciudadanía</option>
            <option value="CE" <?= selected_attr($tipoDoc, 'CE') ?>>Cédula de Extranjería</option>
            <option value="TI" <?= selected_attr($tipoDoc, 'TI') ?>>Tarjeta de Identidad</option>
            <option value="PA" <?= selected_attr($tipoDoc, 'PA') ?>>Pasaporte</option>
          </select>
        </div>

        <div>
          <label for="numero_documento" class="block text-sm font-medium text-gray-700 mb-2">Número de Documento</label>
          <input type="text" id="numero_documento" name="numero_documento" value="<?= h($perfil['numero_documento'] ?? '') ?>" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="1234567890">
        </div>

        <div>
          <label for="nombres" class="block text-sm font-medium text-gray-700 mb-2">Nombres</label>
          <input type="text" id="nombres" name="nombres" value="<?= h($perfil['nombres'] ?? '') ?>" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="Juan Carlos">
        </div>

        <div>
          <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-2">Apellidos</label>
          <input type="text" id="apellidos" name="apellidos" value="<?= h($perfil['apellidos'] ?? '') ?>" required
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="Pérez García">
        </div>

        <div>
          <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
          <input type="tel" id="telefono" name="telefono" value="<?= h($perfil['telefono'] ?? '') ?>"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="300 123 4567">
        </div>

        <div>
          <label for="correo_personal" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
          <input type="email" id="correo_personal" name="correo_personal" value="<?= h($perfil['correo_personal'] ?? '') ?>"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="usuario@ejemplo.com">
        </div>

        <div>
          <label for="departamento" class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
          <input type="text" id="departamento" name="departamento" value="<?= h($perfil['departamento'] ?? '') ?>"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="Santander">
        </div>

        <div>
          <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">Municipio</label>
          <input type="text" id="municipio" name="municipio" value="<?= h($perfil['municipio'] ?? '') ?>"
                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
                 placeholder="Bucaramanga">
        </div>
      </div>

      <div>
        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
        <input type="text" id="direccion" name="direccion" value="<?= h($perfil['direccion'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
               placeholder="Calle 123 #45-67">
      </div>

      <div>
        <label for="usuario" class="block text-sm font-medium text-gray-700 mb-2">Nombre de Usuario</label>
        <input type="text" id="usuario" name="usuario" value="<?= h($perfil['usuario'] ?? '') ?>"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500"
               placeholder="usuario123">
        <p class="text-sm text-gray-500 mt-1">Este será tu nombre de usuario para iniciar sesión.</p>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="bg-lime-600 text-white px-6 py-2.5 rounded-lg hover:bg-lime-700 focus:ring-2 focus:ring-lime-400 focus:outline-none transition-colors font-medium">
          Guardar Cambios
        </button>
      </div>
    </form>
  </div>
</div>
