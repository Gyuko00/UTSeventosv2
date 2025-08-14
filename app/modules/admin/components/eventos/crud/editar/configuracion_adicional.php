<?php // app/modules/admin/components/eventos/crud/editar/configuracion_adicional.php ?>

<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <div class="flex items-center gap-3 mb-6">
    <div class="bg-lime-100 p-2 rounded-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
    </div>
    <h2 class="text-xl font-semibold text-gray-800">Usuario Creador</h2>
  </div>

  <div class="space-y-6">
    <input 
      type="hidden" 
      name="id_usuario_creador" 
      value="<?= $evento['id_usuario_creador'] ?>"
    >

    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
      <div class="flex items-center gap-3">
        <div class="bg-gray-100 p-2 rounded-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700">Evento creado originalmente por:</p>
          <p class="text-gray-600 font-medium">Usuario ID: <?= $evento['id_usuario_creador'] ?></p>
          <p class="text-xs text-gray-500">Este campo se mantiene intacto</p>
        </div>
      </div>
    </div>

    <div class="bg-lime-50 border border-lime-200 rounded-lg p-4">
      <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-lime-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="text-sm text-lime-800">
          <p class="font-medium mb-1">Información importante:</p>
          <ul class="space-y-1 text-lime-700">
            <li>• Estás editando un evento existente</li>
            <li>• El usuario creador original se mantiene sin cambios</li>
            <li>• Verifica que todos los cambios sean correctos antes de guardar</li>
            <li>• Los participantes registrados mantendrán su inscripción</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>