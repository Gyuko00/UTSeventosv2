<!--
/**
 * FORMULARIO DE REGISTRO DE USUARIO
 * 
 * Interfaz completa para registro de nuevos usuarios en UTSeventos.
 * Incluye campos personales, geográficos y de autenticación con
 * validación en tiempo real y diseño responsivo de dos columnas.
 * 
 * Características:
 * - Formulario completo con datos personales y de contacto
 * - Selectores dinámicos de departamento y municipio
 * - Validación de campos con mensajes de error
 * - Diseño responsive con grid adaptativo
 * - Integración con APIs de datos geográficos de Colombia
 * 
 */
-->

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-2xl w-full bg-white p-8 rounded-lg shadow-lg">
    <div class="text-center">
      <h2 class="text-3xl font-extrabold text-[#c9d230]">Registro de Usuario en UTSeventos</h2>
    </div>
    <form id="registroForm" class="mt-8 space-y-6" method="POST" action="<?= URL_PATH ?>/auth/store" data-login-url="<?= URL_PATH ?>/auth/login">
      <div class="grid grid-cols-1 gap-y-6 gap-x-4 md:grid-cols-2">
        <div>
          <label for="tipo_documento" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
          <select id="tipo_documento" name="tipo_documento"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
            <option value="">Seleccione un tipo</option>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="TI">Tarjeta de Identidad</option>
            <option value="CE">Cédula de Extranjería</option>
            <option value="PP">Pasaporte</option>
            <option value="RC">Registro Civil</option>
            <option value="NIT">NIT</option>
          </select>
          <span class="error-message text-red-500 text-xs hidden"></span>
        </div>
        <div>
          <label for="numero_documento" class="block text-sm font-medium text-gray-700">Número de Documento</label>
          <input type="text" id="numero_documento" name="numero_documento"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
          <input type="text" id="nombres" name="nombres"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
          <input type="text" id="apellidos" name="apellidos"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
          <input type="text" id="telefono" name="telefono"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="correo_personal" class="block text-sm font-medium text-gray-700">Correo Personal</label>
          <input type="email" id="correo_personal" name="correo_personal"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="departamento" class="block text-sm font-medium text-gray-700">Departamento</label>
          <select id="departamento" name="departamento"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
            <option value="">Seleccione...</option>
          </select>
        </div>
        <div>
          <label for="municipio" class="block text-sm font-medium text-gray-700">Municipio</label>
          <select id="municipio" name="municipio"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
            <option value="">Seleccione un departamento primero...</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
          <input type="text" id="direccion" name="direccion"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
      </div>
      <div class="grid grid-cols-1 gap-y-6 gap-x-4 md:grid-cols-2 mt-4">
        <div>
          <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text" id="usuario" name="usuario"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label for="contrasenia" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" id="contrasenia" name="contrasenia"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
      </div>
      <div class="mt-6">
        <button type="submit"
          class="w-full bg-[#c9d230] text-white font-bold py-2 px-4 rounded hover:bg-[#b5bf28] focus:outline-none focus:ring-2 focus:ring-[#c9d230] focus:ring-opacity-50">
          Registrarse
        </button>
      </div>
      <p class="text-sm text-center mt-4">
        ¿Ya tienes cuenta? <a href="<?= URL_PATH ?>/auth/login" class="text-[#c9d230] font-semibold hover:underline">Iniciar Sesión</a>
      </p>
    </form>
  </div>
</div>

<script type="module" src="<?= URL_PATH ?>/assets/js/auth/register_validation.js"></script>
<script src="<?= URL_PATH ?>/../utils/colombia_data.js"></script>
  