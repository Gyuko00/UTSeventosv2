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
        name="event[descripcion]"
        rows="4"
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200 resize-vertical"
        placeholder="Describe los detalles, agenda, objetivos y cualquier información relevante sobre el evento..."
      ><?= htmlspecialchars($_POST['event']['descripcion'] ?? '') ?></textarea>
      <p class="text-sm text-gray-500 mt-1">Proporciona información detallada que ayude a los participantes a entender de qué se trata el evento</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="fecha_evento" class="block text-sm font-medium text-gray-700 mb-2">
          Fecha del Evento <span class="text-red-500">*</span>
        </label>
        <input
          type="date"
          id="fecha_evento"
          name="event[fecha]"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
          value="<?= htmlspecialchars($_POST['event']['fecha'] ?? '') ?>"
        />
      </div>
      <div>
        <label for="lugar_evento" class="block text-sm font-medium text-gray-700 mb-2">
          Lugar Detallado <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="lugar_evento"
          name="event[lugar_detallado]"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
          value="<?= htmlspecialchars($_POST['event']['lugar_detallado'] ?? '') ?>"
          placeholder="Ej: Auditorio Principal, Sala de Conferencias..."
        />
      </div>
    </div>

    <div class="space-y-4">
      <h3 class="text-lg font-medium text-gray-700">Seleccionar Horario</h3>

      <div class="bg-gray-50 p-4 rounded-xl">
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
            <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
            Disponible
          </span>
          <span class="inline-flex items-center px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
            <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
            Ocupado
          </span>
          <span class="inline-flex items-center px-2 py-1 text-xs bg-lime-100 text-lime-800 rounded-full">
            <div class="w-2 h-2 bg-lime-500 rounded-full mr-1"></div>
            Seleccionado
          </span>
        </div>

        <div id="timeline-container" class="space-y-2 max-h-96 overflow-y-auto"></div>

        <div id="occupied-events-info"></div>
      </div>

      <input type="hidden" id="hora_inicio" name="event[hora_inicio]" value="<?= htmlspecialchars($_POST['event']['hora_inicio'] ?? '') ?>" required />
      <input type="hidden" id="hora_fin"    name="event[hora_fin]"    value="<?= htmlspecialchars($_POST['event']['hora_fin'] ?? '') ?>" required />

      <div class="bg-lime-50 border border-lime-200 rounded-xl p-4">
        <div class="flex items-center gap-2 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <h4 class="font-medium text-lime-800">Horario Seleccionado</h4>
        </div>
        <div id="selected-time-display" class="text-sm text-lime-700">
          Selecciona un horario en la línea de tiempo
        </div>
        <div id="duracion-display" class="text-sm text-lime-600 font-medium mt-1"></div>
      </div>
    </div>
  </div>
</div>

<script>
  window.URL_PATH  = "<?= URL_PATH ?>";
  // En crear no hay ID existente: usa 0/null para que el script no intente excluir un evento
  window.EVENTO_ID = 0;
</script>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/franjas_horario/main.js"></script>
