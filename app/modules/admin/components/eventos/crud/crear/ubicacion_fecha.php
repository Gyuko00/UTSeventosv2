<?php // app/modules/admin/components/eventos/crud/crear/ubicacion_fecha.php ?>

<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <div class="flex items-center gap-3 mb-6">
    <div class="bg-lime-100 p-2 rounded-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </div>
    <h2 class="text-xl font-semibold text-gray-800">Ubicación</h2>
  </div>

  <div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="departamento_evento" class="block text-sm font-medium text-gray-700 mb-2">
          Departamento
        </label>
        <select
          id="departamento_evento"
          name="departamento_evento"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
        >
          <option value="">Seleccione un departamento...</option>
        </select>
      </div>

      <div>
        <label for="municipio_evento" class="block text-sm font-medium text-gray-700 mb-2">
          Municipio
        </label>
        <select
          id="municipio_evento"
          name="municipio_evento"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
        >
          <option value="">Seleccione un municipio...</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="institucion_evento" class="block text-sm font-medium text-gray-700 mb-2">
          Institución / Organización
        </label>
        <input
          type="text"
          id="institucion_evento"
          name="
          event[institucion_evento]"
          maxlength="100"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
          placeholder="Nombre de la institución organizadora"
          value="<?= isset($_POST['institucion_evento']) ? htmlspecialchars($_POST['institucion_evento']) : '' ?>"
        >
        <p class="text-sm text-gray-500 mt-1">Máximo 100 caracteres</p>
      </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
      <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="text-sm text-blue-800">
          <p class="font-medium mb-1">Consejos para la ubicación:</p>
          <ul class="space-y-1 text-blue-700">
            <li>• Proporciona la dirección completa para facilitar la llegada de los asistentes</li>
            <li>• Incluye referencias como nombres de edificios, salones o puntos de referencia</li>
            <li>• Si es un evento virtual, esta información puede omitirse</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>