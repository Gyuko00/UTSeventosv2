<?php // app/modules/admin/components/eventos/crud/editar/botones_accion.php ?>

<div class="flex flex-col sm:flex-row gap-4 justify-end pt-8 border-t border-gray-200">
  <a href="<?= URL_PATH ?>/admin/listarEventos" 
     class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
    Cancelar
  </a>
  
  <button
    type="submit"
    class="inline-flex items-center justify-center px-6 py-3 bg-lime-600 border border-transparent rounded-xl text-sm font-medium text-white hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition-colors duration-200 shadow-md hover:shadow-lg"
  >
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    Actualizar Evento
  </button>
</div>