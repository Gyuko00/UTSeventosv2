<?php
// app/modules/admin/components/ponentes_evento/home/tabla/empty_state.php
?>

<tr>
  <td colspan="5" class="px-6 py-12 text-center">
    <div class="flex flex-col items-center justify-center space-y-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" viewBox="0 0 640 640" fill="currentColor">
        <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
      </svg>
      <div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay ponentes asignados a eventos</h3>
        <p class="text-gray-500 text-sm">Comienza asignando ponentes a los eventos disponibles</p>
      </div>
      <a href="<?= URL_PATH ?>/admin/asignarPonente" 
          class="inline-flex items-center gap-2 bg-lime-600 hover:bg-lime-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200">
        <i class="fas fa-plus"></i>
        Asignar Ponente
      </a>
    </div>
  </td>
</tr>