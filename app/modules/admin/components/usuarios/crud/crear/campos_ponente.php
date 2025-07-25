<div id="camposPonente" class="bg-white p-6 rounded-lg shadow-sm hidden">
  <h3 class="text-lg font-medium text-gray-800 mb-6 flex items-center">
    <i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>
    Información del Ponente
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">Tema *</label>
      <input
        type="text"
        name="roleSpecific[tema]"
        id="tema"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-tema"></span>
    </div>

    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Descripción Biográfica *</label
      >
      <textarea
        name="roleSpecific[descripcion_biografica]"
        id="descripcionBiografica"
        rows="4"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      ></textarea>
      <span
        class="text-red-500 text-xs hidden"
        id="error-descripcionBiografica"
      ></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Especialización *</label
      >
      <input
        type="text"
        name="roleSpecific[especializacion]"
        id="especializacion"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span
        class="text-red-500 text-xs hidden"
        id="error-especializacion"
      ></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Institución del Ponente *</label
      >
      <input
        type="text"
        name="roleSpecific[institucion_ponente]"
        id="institucionPonente"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span
        class="text-red-500 text-xs hidden"
        id="error-institucionPonente"
      ></span>
    </div>
  </div>
</div>
