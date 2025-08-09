<?php
// app/modules/admin/components/eventos/home/tabla/empty_state.php
?>

<tr>
  <td colspan="6" class="px-6 py-12 text-center">
    <div class="flex flex-col items-center justify-center space-y-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" viewBox="0 0 640 640" fill="currentColor">
        <path d="M152 24C152 10.7 162.7 0 176 0H336C349.3 0 360 10.7 360 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24C280 10.7 290.7 0 304 0H456C469.3 0 480 10.7 480 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24zM152 24H336V64H152V24z"/>
      </svg>
      <div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay eventos registrados</h3>
        <p class="text-gray-500 text-sm">Comienza creando tu primer evento</p>
      </div>
      <a href="<?= URL_PATH ?>/admin/crearEvento" 
         class="inline-flex items-center gap-2 bg-lime-600 hover:bg-lime-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
        <i class="fas fa-plus"></i>
        Crear Evento
      </a>
    </div>
  </td>
</tr>