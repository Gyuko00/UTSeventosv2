<!-- Vista: Formulario de Registro de Usuario e Información Personal -->
<div class="min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-2xl w-full space-y-8">
    <div>
      <h2 class="text-center text-3xl font-extrabold text-[#c9d230]">Registro de Usuario en UTSeventos</h2>
    </div>
    <form id="registroForm" class="space-y-6" method="POST" action="/utseventos/auth/register" data-login-url="/utseventos/auth/loginForm">
      <!-- Datos de Persona -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
          <select name="tipo_documento"  
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
          <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
          <input type="text" name="numero_documento"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Nombres</label>
          <input type="text" name="nombres"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Apellidos</label>
          <input type="text" name="apellidos"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Teléfono</label>
          <input type="text" name="telefono"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Correo Personal</label>
          <input type="email" name="correo_personal"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <!-- Departamento -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Departamento</label>
          <select id="departamento" name="departamento"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
            <option value="">Seleccione...</option>
          </select>
        </div>
            
        <!-- Municipio -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Municipio</label>
          <select id="municipio" name="municipio"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
            <option value="">Seleccione un departamento primero...</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700">Dirección</label>
          <input type="text" name="direccion"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
      </div>

      <!-- Datos de Usuario -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text" name="usuario"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" name="contrasenia"  
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]">
        </div>
      </div>

      <div>
        <button type="submit"
          class="w-full bg-[#c9d230] text-white font-bold py-2 px-4 rounded hover:bg-[#b5bf28] focus:outline-none focus:ring-2 focus:ring-[#c9d230]">
          Registrarse
        </button>
      </div>
      <p class="text-sm text-center mt-4">
        ¿Ya tienes cuenta? <a href="<?= URL_PATH ?>/auth/loginForm" class="text-[#c9d230] font-semibold hover:underline">Iniciar Sesión</a>
      </p>
    </form>
  </div>
</div>

<script src="<?= URL_PATH ?>/app/modules/auth/js/ColombiaData.js"></script>
<script src="<?= URL_PATH ?>/app/modules/auth/js/RegisterValidation.js"></script>


