<div class="min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl w-full space-y-8">
    <div>
      <h2 class="text-center text-3xl font-extrabold text-[#c9d230]">Editar Perfil</h2>
    </div>

    <form id="formEditarPerfil" class="space-y-6" method="POST" action="<?= URL_PATH ?>/user/editarPerfilForm">
      <!-- Información personal -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <input type="hidden" name="id_persona" value="<?= $perfil['id_persona'] ?>">

        <div>
          <label class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
          <input type="text" name="tipo_documento" value="<?= $perfil['tipo_documento'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
          <input type="text" name="numero_documento" value="<?= $perfil['numero_documento'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Nombres</label>
          <input type="text" name="nombres" value="<?= $perfil['nombres'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Apellidos</label>
          <input type="text" name="apellidos" value="<?= $perfil['apellidos'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Teléfono</label>
          <input type="text" name="telefono" value="<?= $perfil['telefono'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Correo Personal</label>
          <input type="email" name="correo_personal" value="<?= $perfil['correo_personal'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Departamento</label>
          <select id="departamento" name="departamento" data-valor="<?= $perfil['departamento'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]"></select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Municipio</label>
          <select id="municipio" name="municipio" data-valor="<?= $perfil['municipio'] ?>" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]"></select>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Dirección</label>
          <input type="text" name="direccion" value="<?= $perfil['direccion'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text" name="usuario" value="<?= $perfil['usuario'] ?>"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
      </div>
      
      <!-- Cambiar contraseña -->
      <div>
        <button type="button" id="btnCambiarContrasena" class="text-sm text-blue-600 hover:underline">
          ¿Cambiar contraseña?
        </button>
      </div>
      
      <div id="seccionContrasena" class="hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="relative">
            <label class="block text-sm font-medium text-gray-700">Contraseña actual</label>
            <input type="password" name="contrasenia_actual" id="contrasenia_actual"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 pr-10 focus:ring-red-500 focus:border-red-500">
              <button type="button"
                class="absolute right-0 top-0 bottom-0 flex items-center px-3 text-gray-500 hover:text-gray-700 togglePassword"
                data-target="contrasenia_actual">
              <svg class="eyeClosed h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.04 10.04 0 012.614-4.362M6.153 6.153A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.422 5.225M6.153 6.153L3 3m0 0l18 18" />
              </svg>
              <svg class="eyeOpen h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
      
          <div class="relative">
            <label class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
            <input type="password" name="nueva_contrasenia" id="nueva_contrasenia"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 pr-10 focus:ring-red-500 focus:border-red-500">
            <button type="button" 
              class="absolute right-0 top-0 bottom-0 flex items-center px-3 text-gray-500 hover:text-gray-700 togglePassword"
              data-target="nueva_contrasenia">
              <svg class="eyeClosed h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.04 10.04 0 012.614-4.362M6.153 6.153A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.422 5.225M6.153 6.153L3 3m0 0l18 18" />
              </svg>
              <svg class="eyeOpen h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>
      </div>  
      <div class="flex justify-between">
        <a href="<?= URL_PATH ?>/user/perfil"
          class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">← Cancelar</a>
        <button type="submit"
          class="bg-[#c9d230] text-white font-bold py-2 px-6 rounded hover:bg-[#b5bf28] transition">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<script src="<?= URL_PATH ?>/app/modules/user/js/ValidatePerfilEdition.js"></script>
<script src="<?= URL_PATH ?>/app/utils/ColombiaData.js"></script>
