<?php
// app/modules/user/components/perfil/info_cuenta.php
?>
<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
    </svg>
    Información de Cuenta
  </h3>
  <div class="space-y-3 text-sm">
    <div class="flex justify-between">
      <span class="text-gray-600">Usuario:</span>
      <span class="font-medium"><?= h($perfil['usuario'] ?? null, '-') ?></span>
    </div>
    <div class="flex justify-between">
      <span class="text-gray-600">Rol:</span>
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-lime-100 text-lime-800">
        Invitado
      </span>
    </div>
  </div>
</div>
