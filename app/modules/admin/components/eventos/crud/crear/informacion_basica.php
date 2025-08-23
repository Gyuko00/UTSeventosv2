<?php // app/modules/admin/components/eventos/crud/crear/informacion_basica.php ?>

<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
  <div class="flex items-center gap-3 mb-6">
    <div class="bg-lime-100 p-2 rounded-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <h2 class="text-xl font-semibold text-gray-800">Información Básica</h2>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="lg:col-span-2">
      <label for="titulo_evento" class="block text-sm font-medium text-gray-700 mb-2">
        Título del Evento <span class="text-red-500">*</span>
      </label>
      <input
        type="text"
        id="titulo_evento"
        name="event[titulo_evento]"
        required
        maxlength="150"
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
        placeholder="Ingresa el título del evento"
        value="<?= isset($_POST['titulo_evento']) ? htmlspecialchars($_POST['titulo_evento']) : '' ?>"
      >
      <p class="text-sm text-gray-500 mt-1">Máximo 150 caracteres</p>
    </div>

    <div>
      <label for="tema" class="block text-sm font-medium text-gray-700 mb-2">
        Tema <span class="text-red-500">*</span>
      </label>
      <input
        type="text"
        id="tema"
        name="event[tema]"
        required
        maxlength="100"
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
        placeholder="Tema o categoría del evento"
        value="<?= isset($_POST['tema']) ? htmlspecialchars($_POST['tema']) : '' ?>"
      >
      <p class="text-sm text-gray-500 mt-1">Máximo 100 caracteres</p>
    </div>

    <div>
      <label for="cupo_maximo" class="block text-sm font-medium text-gray-700 mb-2">
        Cupo Máximo
      </label>
      <input
        type="number"
        id="cupo_maximo"
        name="event[cupo_maximo]"
        min="1"
        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-transparent transition-all duration-200"
        placeholder="Número máximo de asistentes"
        value="<?= isset($_POST['cupo_maximo']) ? htmlspecialchars($_POST['cupo_maximo']) : '' ?>"
      >
      <p class="text-sm text-gray-500 mt-1">Deja vacío para sin límite</p>
    </div>
  </div>
</div>