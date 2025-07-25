<div class="bg-white p-6 rounded-lg shadow-sm">
  <h3 class="text-lg font-medium text-gray-800 mb-6 flex items-center">
    <i class="fas fa-key mr-2 text-green-600"></i>
    Información de Usuario
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Usuario *</label
      >
      <input
        type="text"
        name="user[usuario]"
        id="usuario"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-usuario"></span>
      <p class="text-xs text-gray-500 mt-1">
        Entre 4 y 20 caracteres alfanuméricos
      </p>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Contraseña *</label
      >
      <div class="relative">
        <input
          type="password"
          name="user[contrasenia]"
          id="contrasenia"
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
      <p class="text-xs text-gray-500 mt-1">Mínimo 6 caracteres</p>
    </div>

    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
      <select
        name="user[id_rol]"
        id="rol"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar rol</option>
        <option value="2">Ponente</option>
        <option value="3">Invitado</option>
        <option value="4">Control</option>
      </select>
      <span class="text-red-500 text-xs hidden" id="error-rol"></span>
    </div>
  </div>
</div>
