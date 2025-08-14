<?php // app/modules/admin/components/eventos/crud/crear/detalles_evento.php ?>

<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <div class="flex items-center gap-3 mb-6">
    <div class="bg-lime-100 p-2 rounded-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
    </div>
    <h2 class="text-xl font-semibold text-gray-800">Detalles del Evento</h2>
  </div>

  <div class="space-y-6">
    <div>
      <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
        Descripción del Evento
      </label>
      <textarea
        id="descripcion"
        name="descripcion"
        rows="4"
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200 resize-vertical"
        placeholder="Describe los detalles, agenda, objetivos y cualquier información relevante sobre el evento..."
      ><?= isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : '' ?></textarea>
      <p class="text-sm text-gray-500 mt-1">Proporciona información detallada que ayude a los participantes a entender de qué se trata el evento</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-2">
          Hora de Inicio
        </label>
        <input
          type="time"
          id="hora_inicio"
          name="hora_inicio"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
          value="<?= isset($_POST['hora_inicio']) ? htmlspecialchars($_POST['hora_inicio']) : '' ?>"
        >
      </div>

      <div>
        <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-2">
          Hora de Finalización
        </label>
        <input
          type="time"
          id="hora_fin"
          name="hora_fin"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
          value="<?= isset($_POST['hora_fin']) ? htmlspecialchars($_POST['hora_fin']) : '' ?>"
        >
      </div>
    </div>
  </div>
</div>