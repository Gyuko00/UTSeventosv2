<?php
// app/modules/admin/components/ponentes_evento/crud/detalle/header.php
?>
<div class="bg-gradient-to-r from-lime-600 to-lime-700 rounded-xl shadow-lg p-6 mb-6 flex justify-between items-center">
  <div>
    <h1 class="text-3xl font-bold text-white mb-2">
      Detalle de Asignación de Ponente
    </h1>
    <p class="text-lime-100 opacity-90">
      <?= htmlspecialchars($ponente['nombres'] . ' ' . $ponente['apellidos']) ?>
      en
      <?= htmlspecialchars($ponente['titulo_evento']) ?>
    </p>

    <div class="flex items-center gap-4 mt-3">
      <!-- Institución -->
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-green-700 shadow-sm">
        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z"/>
        </svg>
        <?= htmlspecialchars($ponente['institucion_ponente']) ?>
      </span>

      <!-- Fecha -->
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-green-700 shadow-sm">
        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
        </svg>
        <?= date('d/m/Y', strtotime($ponente['fecha'])) ?>
      </span>
    </div>
  </div>

  <div class="text-right">
    <div class="text-sm text-lime-100 mb-1">ID Asignación</div>
    <div class="text-2xl font-bold text-white">#<?= htmlspecialchars($ponente['id_ponente_evento']) ?></div>
  </div>

  <a
    href="<?= URL_PATH ?>/admin/listarPonentes"
    class="bg-white hover:bg-lime-50 text-lime-700 font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="w-5 h-5"
      viewBox="0 0 640 640"
      fill="currentColor"
    >
      <path
        d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z"
      />
    </svg>
    Volver
  </a>
</div>
