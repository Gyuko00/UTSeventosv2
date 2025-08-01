<div id="camposPonente" class="bg-white p-8 rounded-xl shadow-md border border-gray-200 hidden">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" viewBox="0 0 640 640" fill="currentColor">
      <path d="M128 160C128 124.7 156.7 96 192 96L544 96C579.3 96 608 124.7 608 160L608 400L512 400L512 384C512 366.3 497.7 352 480 352L416 352C398.3 352 384 366.3 384 384L384 400L254.9 400C265.8 381.2 272 359.3 272 336C272 265.3 214.7 208 144 208C138.6 208 133.2 208.3 128 209L128 160zM333 512C327.9 487.8 316.7 465.9 300.9 448L608 448C608 483.3 579.3 512 544 512L333 512zM64 336C64 291.8 99.8 256 144 256C188.2 256 224 291.8 224 336C224 380.2 188.2 416 144 416C99.8 416 64 380.2 64 336zM0 544C0 491 43 448 96 448L192 448C245 448 288 491 288 544C288 561.7 273.7 576 256 576L32 576C14.3 576 0 561.7 0 544z"/>
    </svg>
    Información del Ponente
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
      <label class="block text-base font-medium text-gray-700 mb-2">Tema *</label>
      <input
        type="text"
        name="roleSpecific[tema]"
        id="tema"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-tema"></span>
    </div>

    <div class="md:col-span-2">
      <label class="block text-base font-medium text-gray-700 mb-2">Descripción Biográfica *</label>
      <textarea
        name="roleSpecific[descripcion_biografica]"
        id="descripcionBiografica"
        rows="4"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      ></textarea>
      <span class="text-red-500 text-sm hidden mt-1" id="error-descripcionBiografica"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Especialización *</label>
      <input
        type="text"
        name="roleSpecific[especializacion]"
        id="especializacion"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-especializacion"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Institución del Ponente *</label>
      <input
        type="text"
        name="roleSpecific[institucion_ponente]"
        id="institucionPonente"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-institucionPonente"></span>
    </div>
  </div>
</div>
