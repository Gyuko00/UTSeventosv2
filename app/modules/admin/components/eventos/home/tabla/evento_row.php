<?php
// app/modules/admin/components/eventos/home/tabla/evento_row.php
?>

<tr class="hover:bg-lime-50 transition-colors duration-150">
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-sm font-medium text-gray-900 mb-1">
        <?= htmlspecialchars($evento['titulo_evento']) ?>
      </div>
      <div class="text-xs text-gray-500">
        <span
          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
        >
          <?= htmlspecialchars($evento['tema']) ?>
        </span>
      </div>
    </div>
  </td>

  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-sm text-gray-900 font-medium">
        <?= htmlspecialchars($evento['institucion_evento']) ?>
      </div>
      <div class="text-xs text-gray-500">
        <?= htmlspecialchars($evento['lugar_detallado']) ?>
      </div>
    </div>
  </td>

  <td class="px-6 py-4">
    <div class="text-sm text-gray-900">
      <?= htmlspecialchars($evento['descripcion']) ?>
    </div>
  </td>

  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-sm font-medium text-gray-900">
        <?= date('d/m/Y', strtotime($evento['fecha'])) ?>
      </div>
      <div class="text-xs text-gray-500">
        <?= date('H:i', strtotime($evento['hora_inicio'])) ?>
        -
        <?= date('H:i', strtotime($evento['hora_fin'])) ?>
      </div>
    </div>
  </td>

  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center">
      <div class="text-sm font-medium text-gray-900">
        <?= htmlspecialchars($evento['cupo_maximo']) ?>
      </div>
      <div class="ml-2">
        <span
          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
        >
          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            />
          </svg>
          Disponible
        </span>
      </div>
    </div>
  </td>

  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <?php
    $archivo_acciones = __DIR__ . '\..\..\..\helpers\acciones_evento.php';
    if (file_exists($archivo_acciones)) {
      include $archivo_acciones;
    } else {
      echo 'Archivo no encontrado: ' . $archivo_acciones;
    }
    ?>
    </td>
</tr>
