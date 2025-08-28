<?php
// app/modules/admin/home.view.php  (o el archivo que renderiza tu “inicio”)
?>
<div class="space-y-6">

  <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
    <div class="flex items-start gap-4">
      <div class="bg-lime-100 p-3 rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-lime-700" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2a7 7 0 00-7 7v3H3a1 1 0 000 2h2v2a5 5 0 005 5h4a5 5 0 005-5v-2h2a1 1 0 000-2h-2V9a7 7 0 00-7-7zm-3 7a3 3 0 116 0v3H9V9zm0 5h6v2a3 3 0 01-3 3h-4a3 3 0 01-3-3v-2h4z"/>
        </svg>
      </div>
      <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Bienvenido a UTSeventos</h1>
        <p class="text-gray-600 mt-2">
          Administra usuarios, eventos, invitados y ponentes desde un solo lugar. 
          Aquí verás un calendario interactivo con todos los eventos. Puedes navegar por meses, 
          ver los eventos de un día específico y abrir su detalle con un clic.
        </p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-md border border-gray-100">
      <div class="p-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="bg-lime-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-lime-700" viewBox="0 0 24 24" fill="currentColor">
              <path d="M7 2a1 1 0 00-1 1v1H5a3 3 0 00-3 3v1h20V7a3 3 0 00-3-3h-1V3a1 1 0 10-2 0v1H8V3a1 1 0 00-1-1zM2 10v8a3 3 0 003 3h14a3 3 0 003-3v-8H2zm5 3h3v3H7v-3z"/>
            </svg>
          </div>
          <h2 id="cal-title" class="text-lg font-semibold text-gray-800">Calendario</h2>
        </div>
        <div class="flex items-center gap-2">
          <button id="cal-prev" class="px-3 py-1.5 text-sm rounded-lg border border-gray-200 hover:bg-gray-50">←</button>
          <button id="cal-today" class="px-3 py-1.5 text-sm rounded-lg border border-gray-200 hover:bg-gray-50">Hoy</button>
          <button id="cal-next" class="px-3 py-1.5 text-sm rounded-lg border border-gray-200 hover:bg-gray-50">→</button>
        </div>
      </div>

      <div class="p-4">
        <div class="grid grid-cols-7 text-center text-xs font-medium text-gray-500 mb-2">
          <div>Lu</div><div>Ma</div><div>Mi</div><div>Ju</div><div>Vi</div><div>Sá</div><div>Do</div>
        </div>
        <div id="cal-grid" class="grid grid-cols-7 gap-2"></div>
        <div class="mt-4 flex items-center gap-4 text-xs text-gray-600">
          <span class="inline-flex items-center gap-2"><span class="w-3 h-3 rounded bg-lime-200 border border-lime-300"></span> Con eventos</span>
          <span class="inline-flex items-center gap-2"><span class="w-3 h-3 rounded bg-gray-100 border border-gray-200"></span> Sin eventos</span>
          <span class="inline-flex items-center gap-2"><span class="w-3 h-3 rounded ring-2 ring-lime-500"></span> Hoy</span>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100">
      <div class="p-4 border-b border-gray-100">
        <h3 id="day-title" class="text-lg font-semibold text-gray-800">Eventos del día</h3>
        <p id="day-sub" class="text-sm text-gray-500">Selecciona una fecha para ver sus eventos</p>
      </div>
      <div id="day-list" class="p-4 space-y-3">
      </div>
    </div>
  </div>
</div>

<script>
  const URL_PATH = "<?= URL_PATH ?>";
  window.EVENTS = <?= json_encode(array_values($eventos ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script type="module" src="<?= URL_PATH ?>/assets/js/control/home/calendar.js"></script>

