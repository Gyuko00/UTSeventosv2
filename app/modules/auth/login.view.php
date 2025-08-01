<!--
/**
 * FORMULARIO DE INICIO DE SESIÓN
 * 
 * Interfaz de autenticación para usuarios del sistema UTSeventos.
 * Incluye validación de credenciales, mostrar/ocultar contraseña
 * y manejo de errores con diseño responsivo.
 * 
 * Características:
 * - Logo UTS con gradiente corporativo
 * - Campos de usuario y contraseña con validación
 * - Toggle de visibilidad de contraseña con iconos SVG
 * - Manejo de errores con mensajes destacados
 * - Enlace directo al formulario de registro
 * 
 */
-->

<div class="w-full max-w-md mx-auto p-8 space-y-6 bg-white rounded-xl shadow-lg border border-gray-100">
  <div class="flex justify-center items-center">
    <div class="p-1 bg-gradient-to-tr from-[#c9d230] to-lime-500 rounded-xl shadow-lg">
      <img src="<?= URL_PATH ?>/assets/images/UTS-logo.webp" alt="Logo UTS" class="w-20 h-20 object-cover rounded-lg">
    </div>
  </div>

  <h2 class="text-center text-2xl font-bold text-lime-600 mt-4">Iniciar Sesión en UTSeventos</h2>

  <?php if (!empty($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm text-sm text-center">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form id="loginForm" class="space-y-6" method="POST" action="<?= URL_PATH ?>/auth/autenticate">
    <div>
      <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
      <input id="usuario" name="usuario" type="text" required
             class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 focus:outline-none text-gray-800 placeholder-gray-400"
             placeholder="Nombre de usuario">
    </div>

    <div class="relative">
      <label for="contrasenia" class="block text-sm font-medium text-gray-700">Contraseña</label>
      <input id="contrasenia" name="contrasenia" type="password" required
             class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 focus:outline-none pr-12 text-gray-800 placeholder-gray-400"
             placeholder="Contraseña">
      <button type="button" id="togglePassword"
              class="absolute right-0 top-1/2 transform -translate-y-1/2 flex items-center pr-3 text-gray-500 hover:text-gray-700 transition">
        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.04 10.04 0 012.614-4.362M6.153 6.153A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
      </button>
    </div>

    <button type="submit"
      class="w-full py-3 px-4 bg-gradient-to-r from-lime-600 to-lime-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-opacity-50">
      Iniciar Sesión
    </button>
  </form>

  <p class="text-center text-sm mt-4 text-gray-600">
    ¿No tienes cuenta?
    <a href="<?= URL_PATH ?>/auth/register" class="text-lime-600 font-semibold hover:underline">Registrarse</a>
  </p>
</div>

<script src="<?= URL_PATH ?>/assets/js/auth/login_validation.js"></script>
