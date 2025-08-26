<?php
// app/modules/user/components/perfil/form_cambiar_contrasena.php
?>
<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
    </svg>
    Cambiar Contraseña
  </h3>

  <form id="form-contrasena" class="space-y-4">
    <div>
      <label for="contrasena_actual" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
      <input type="password" id="contrasena_actual" name="contrasena_actual" required
             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
             placeholder="••••••••">
    </div>
    <div>
      <label for="nueva_contrasena" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
      <input type="password" id="nueva_contrasena" name="nueva_contrasena" required
             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
             placeholder="••••••••">
    </div>
    <div>
      <label for="confirmar_contrasena" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
      <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required
             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
             placeholder="••••••••">
    </div>
    <button type="submit"
            class="w-full bg-orange-600 text-white px-4 py-2.5 rounded-lg hover:bg-orange-700 focus:ring-2 focus:ring-orange-400 focus:outline-none transition-colors font-medium">
      Cambiar Contraseña
    </button>
  </form>
</div>
