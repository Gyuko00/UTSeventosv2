<!--
login.view.php

Formulario de inicio de sesión para el módulo auth.
Muestra el logo de UTS y una manzana verde al lado, con estilos modernos.
-->

<div class="w-full max-w-md mx-auto space-y-6">
  <!-- Logos superiores con gradiente y diseño horizontal -->
  <div class="flex justify-center items-center space-x-4">
    <div class="p-1 bg-gradient-to-tr from-[#c9d230] to-lime-500 rounded-xl shadow-lg">
      <img src="<?= URL_PATH ?>/public/assets/images/UTS-logo.webp" alt="Logo UTS"
           class="w-20 h-20 object-cover rounded-lg">
    </div>
  </div>

  <h2 class="text-center text-2xl font-bold text-[#c9d230] mt-2">Iniciar Sesión en UTSeventos</h2>

  <?php if (!empty($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form id="loginForm" class="space-y-4" method="POST" action="<?= URL_PATH ?>/auth/login">
    <div>
      <label for="usuario" class="sr-only">Usuario</label>
      <input id="usuario" name="usuario" type="text" required
             class="w-full px-4 py-2 border rounded focus:ring-[#c9d230] focus:border-[#c9d230]"
             placeholder="Nombre de usuario">
    </div>
  
    <div class="relative">
      <label for="contrasenia" class="sr-only">Contraseña</label>
      <input id="contrasenia" name="contrasenia" type="password" required
             class="w-full px-4 py-2 border rounded pr-10 focus:ring-[#c9d230] focus:border-[#c9d230]"
             placeholder="Contraseña">
      <button type="button" id="togglePassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

        <!-- Ícono ojo cerrado (inicialmente oculto) -->
        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.04 10.04 0 012.614-4.362M6.153 6.153A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.422 5.225M6.153 6.153L3 3m0 0l18 18" />
        </svg>

        <!-- Ícono ojo abierto por defecto -->
        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
      </button>
    </div>

  
    <button type="submit"
            class="w-full py-2 px-4 bg-[#c9d230] text-white font-semibold rounded hover:bg-[#b5bf28]">
      Iniciar Sesión
    </button>
  </form>


  <p class="text-center text-sm mt-4">
    ¿No tienes cuenta?
    <a href="<?= URL_PATH ?>/auth/registerForm" class="text-[#c9d230] font-medium hover:underline">Registrarse</a>
  </p>
</div>

<script src="<?= URL_PATH ?>/app/modules/auth/js/LoginValidation.js"></script>
