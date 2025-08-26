<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
    </svg>
    Mis Eventos
  </h3>

  <!-- Estado de carga -->
  <div id="eventos-loading" class="text-center py-8">
    <svg class="animate-spin h-8 w-8 text-orange-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <p class="text-gray-500 text-sm">Cargando tus eventos...</p>
  </div>

  <!-- Aquí se inyectará el contenido via AJAX -->
  <div id="eventos-content" class="hidden"></div>
</div>

