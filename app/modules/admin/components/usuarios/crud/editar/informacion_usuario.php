<div class="bg-white p-6 rounded-lg shadow-sm">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" viewBox="0 0 640 640" fill="currentColor">
      <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
    </svg>
    Información de Usuario
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label for="usuario" class="block text-base font-medium text-gray-700 mb-2">Usuario *</label>
      <input
        type="text"
        name="user[usuario]"
        id="usuario"
        value="<?= htmlspecialchars($usuarioData['usuario'] ?? '') ?>"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-usuario"></span>
      <p class="text-xs text-gray-500 mt-1">Entre 4 y 20 caracteres alfanuméricos</p>
    </div>

    <div>
      <label for="contrasenia" class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
      <div class="relative">
        <input
          type="password"
          name="user[contrasenia]"
          id="contrasenia"
          placeholder="Dejar en blanco para no cambiar"
          class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
        <button
          type="button"
          id="togglePassword"
          class="absolute inset-y-0 right-0 pr-3 flex items-center"
        >
          <i class="fas fa-eye text-gray-400" id="eyeOpen"></i>
          <i class="fas fa-eye-slash text-gray-400 hidden" id="eyeClosed"></i>
        </button>
      </div>
      <span class="text-red-500 text-xs hidden" id="error-contrasenia"></span>
      <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
    </div>
    
    <div class="md:col-span-2">
      <label for="id_rol" class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
      <select
        id="id_rol"
        name="user[id_rol]"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900"
        required
      >
        <option value="" disabled <?= empty($usuarioData['id_rol']) ? 'selected' : '' ?>>Seleccione un rol</option>
        <option value="2" <?= ($usuarioData['id_rol'] ?? '') == 2 ? 'selected' : '' ?>>Ponente</option>
        <option value="3" <?= ($usuarioData['id_rol'] ?? '') == 3 ? 'selected' : '' ?>>Invitado</option>
        <option value="4" <?= ($usuarioData['id_rol'] ?? '') == 4 ? 'selected' : '' ?>>Control</option>
      </select>
    
      <?php if (($usuarioData['id_rol'] ?? '') == 2 || ($usuarioData['id_rol'] ?? '') == 3): ?>
      <p class="text-xs text-amber-600 mt-1">
        ⚠️ Este usuario tiene información específica de su rol. No se puede cambiar el rol sin perder los datos.
      </p>
      <?php endif; ?>

    </div>
  </div>
</div>
