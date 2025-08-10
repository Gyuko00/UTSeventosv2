<!-- components/eventos/crud/editar/informacion_basica.php -->
<div class="border-b border-gray-200 pb-8">
  <h2 class="text-xl font-semibold text-gray-900 mb-6">Información Básica</h2>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label for="titulo_evento" class="block text-sm font-medium text-gray-700 mb-2">
        Título del Evento <span class="text-red-500">*</span>
      </label>
      <input
        type="text"
        id="titulo_evento"
        name="event[titulo_evento]"
        value="<?= htmlspecialchars($evento['titulo_evento'] ?? '') ?>"
        required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
        placeholder="Ingrese el título del evento"
      >
    </div>

    <div>
      <label for="tema" class="block text-sm font-medium text-gray-700 mb-2">
        Tema <span class="text-red-500">*</span>
      </label>
      <input
        type="text"
        id="tema"
        name="event[tema]"
        value="<?= htmlspecialchars($evento['tema'] ?? '') ?>"
        required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
        placeholder="Tema principal del evento"
      >
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
        value="<?= htmlspecialchars($evento['cupo_maximo'] ?? '') ?>"
      >
      <p class="text-sm text-gray-500 mt-1">Deja vacío para sin límite</p>
    </div>
  </div>
</div>