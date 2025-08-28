<?php
// app/modules/admin/components/eventos/home/tabla.php
?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden border border-lime-200">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-lime-700">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M152 24C152 10.7 162.7 0 176 0H336C349.3 0 360 10.7 360 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24C280 10.7 290.7 0 304 0H456C469.3 0 480 10.7 480 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24zM152 24H336V64H152V24z"/>
              </svg>
              Código Evento
            </div>
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M152 24C152 10.7 162.7 0 176 0H336C349.3 0 360 10.7 360 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24C280 10.7 290.7 0 304 0H456C469.3 0 480 10.7 480 24V64H512C533.5 64 552 80.5 552 104V560C552 583.5 533.5 600 512 600H128C105.5 600 88 583.5 88 560V104C88 80.5 105.5 64 128 64H280V24zM152 24H336V64H152V24z"/>
              </svg>
              Evento
            </div>
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M128 252.6C128 148.4 214 64 320 64C426 64 512 148.4 512 252.6C512 371.9 391.8 514.9 341.6 569.4C329.8 582.2 310.1 582.2 298.3 569.4C248.1 514.9 127.9 371.9 127.9 252.6zM320 320C355.3 320 384 291.3 384 256C384 220.7 355.3 192 320 192C284.7 192 256 220.7 256 256C256 291.3 284.7 320 320 320z"/>
              </svg>
              Lugar
            </div>
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M464 64C508.2 64 544 99.8 544 144V336C544 380.2 508.2 416 464 416H448V464C448 490.5 426.5 512 400 512H240C213.5 512 192 490.5 192 464V416H176C131.8 416 96 380.2 96 336V144C96 99.8 131.8 64 176 64H464zM192 336C192 354.2 206.8 368 224 368H416C433.2 368 448 354.2 448 336V144C448 125.8 433.2 112 416 112H224C206.8 112 192 125.8 192 144V336z"/>
              </svg>
              Detalles
            </div>
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M464 0C481.7 0 496 14.3 496 32V64H512C565 64 608 107 608 160V512C608 565 565 608 512 608H128C75 608 32 565 32 512V160C32 107 75 64 128 64H144V32C144 14.3 158.3 0 176 0C193.7 0 208 14.3 208 32V64H432V32C432 14.3 446.3 0 464 0zM128 128C110.3 128 96 142.3 96 160V192H544V160C544 142.3 529.7 128 512 128H128zM544 256H96V512C96 529.7 110.3 544 128 544H512C529.7 544 544 529.7 544 512V256z"/>
              </svg>
              Fecha y Hora
            </div>
          </th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
              </svg>
              Cupo
            </div>
          </th>
          <th class="px-6 py-4 text-right text-sm font-semibold text-white uppercase tracking-wider">
            <div class="flex items-center justify-end gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/>
              </svg>
              Acciones
            </div>
          </th>
        </tr>
      </thead>
      <tbody id="tablaEventos" class="bg-white divide-y divide-lime-100 hover:divide-lime-200">
        <?php if (empty($eventos)): ?>
        <?php include_once __DIR__ . '/tabla/empty_state.php'; ?>
        <?php else: ?>
        <?php foreach ($eventos as $evento): ?>
        <?php include __DIR__ . '/tabla/evento_row.php'; ?>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>