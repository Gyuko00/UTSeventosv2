<?php
// app/modules/admin/components/usuarios/tabla.php
?>

<div
  class="bg-white rounded-xl shadow-lg overflow-hidden border border-lime-200"
>
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-lime-700">
        <tr>
          <th
            class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
              </svg>
              Usuario
            </div>
          </th>
          <th
            class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM288 224C288 206.3 302.3 192 320 192C337.7 192 352 206.3 352 224C352 241.7 337.7 256 320 256C302.3 256 288 241.7 288 224zM280 288L328 288C341.3 288 352 298.7 352 312L352 400L360 400C373.3 400 384 410.7 384 424C384 437.3 373.3 448 360 448L280 448C266.7 448 256 437.3 256 424C256 410.7 266.7 400 280 400L304 400L304 336L280 336C266.7 336 256 325.3 256 312C256 298.7 266.7 288 280 288z"/>
              </svg>
              Información Personal
            </div>
          </th>
          <th
            class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M468 64C487.2 64 505.6 71.6 519.1 85.2L554.8 120.9C568.4 134.4 576 152.8 576 172C576 191.2 568.4 209.6 554.8 223.1L509.9 268L372 130.1L416.9 85.2C430.4 71.6 448.8 64 468 64zM122.9 379.1L338.1 164L476 301.9L260.9 517.1C250.2 527.8 236.8 535.6 222.2 539.7L94.4 575.1C86.1 577.4 77.1 575.1 71 568.9C64.9 562.7 62.5 553.8 64.8 545.5L100.4 417.8C104.5 403.2 112.2 389.9 123 379.1zM289.4 144.8L144.8 289.4L75.7 220.3C60.1 204.7 60.1 179.4 75.7 163.7L163.7 75.7C179.3 60.1 204.6 60.1 220.3 75.7L226.2 81.6L169.9 137.9C162.1 145.7 162.1 158.4 169.9 166.2C177.7 174 190.4 174 198.2 166.2L254.5 109.9L289.4 144.8zM495.2 350.6L530.1 385.5L473.8 441.8C466 449.6 466 462.3 473.8 470.1C481.6 477.9 494.3 477.9 502.1 470.1L558.4 413.8L564.3 419.7C579.9 435.3 579.9 460.6 564.3 476.3L476.3 564.3C460.7 579.9 435.4 579.9 419.7 564.3L350.6 495.2L495.2 350.6z"/>
              </svg>
              Rol
            </div>
          </th>
          <th
            class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M512 320C512 214 426 128 320 128C214 128 128 214 128 320C128 426 214 512 320 512C426 512 512 426 512 320zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 400C364.2 400 400 364.2 400 320C400 275.8 364.2 240 320 240C275.8 240 240 275.8 240 320C240 364.2 275.8 400 320 400zM320 176C399.5 176 464 240.5 464 320C464 399.5 399.5 464 320 464C240.5 464 176 399.5 176 320C176 240.5 240.5 176 320 176zM288 320C288 302.3 302.3 288 320 288C337.7 288 352 302.3 352 320C352 337.7 337.7 352 320 352C302.3 352 288 337.7 288 320z"/>
              </svg>
              Estado
            </div>
          </th>
          <th
            class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider border-r border-lime-600 last:border-r-0"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M128 252.6C128 148.4 214 64 320 64C426 64 512 148.4 512 252.6C512 371.9 391.8 514.9 341.6 569.4C329.8 582.2 310.1 582.2 298.3 569.4C248.1 514.9 127.9 371.9 127.9 252.6zM320 320C355.3 320 384 291.3 384 256C384 220.7 355.3 192 320 192C284.7 192 256 220.7 256 256C256 291.3 284.7 320 320 320z"/>
              </svg>
              Ubicación
            </div>
          </th>
          <th
            class="px-6 py-4 text-right text-sm font-semibold text-white uppercase tracking-wider"
          >
            <div class="flex items-center justify-end gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-lime-200" viewBox="0 0 640 640" fill="currentColor">
                <path d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/>
              </svg>
              Acciones
            </div>
          </th>
        </tr>
      </thead>
      <tbody
        id="tablaUsuarios"
        class="bg-white divide-y divide-lime-100 hover:divide-lime-200"
      >
        <?php if (empty($usuarios)): ?>
        <?php include_once __DIR__ . '/tabla/empty_state.php'; ?>
        <?php else: ?>
        <?php foreach ($usuarios as $usuario): ?>
        <?php include __DIR__ . '/tabla/usuario_rol.php'; ?>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
