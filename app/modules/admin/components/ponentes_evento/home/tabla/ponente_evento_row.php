<?php
// app/modules/admin/components/ponentes_evento/home/tabla/ponente_evento_row.php
?>

<tr 
  class="hover:bg-lime-50 transition-colors duration-150"
  data-evento-id="<?= htmlspecialchars($ponente['id_evento']) ?>"
  data-ponente-id="<?= htmlspecialchars($ponente['id_ponente']) ?>"
>
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-sm font-medium text-gray-900 mb-1">
        ID Ponente: <?= htmlspecialchars($ponente['id_ponente']) ?>
      </div>
      <div class="text-xs text-gray-500">
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
          <?= htmlspecialchars($ponente['tema']) ?>
        </span>
      </div>
      <div class="text-xs text-gray-500 mt-1">
        <?= htmlspecialchars($ponente['institucion_ponente']) ?>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-sm text-gray-900 font-medium">
        <?= htmlspecialchars($ponente['titulo_evento']) ?>
      </div>
      <div class="text-xs text-gray-500">
        <?= date('d/m/Y', strtotime($ponente['fecha'])) ?>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <?php if (!empty($ponente['hora_participacion'])): ?>
        <div class="text-sm font-medium text-gray-900">
          <?= date('H:i', strtotime($ponente['hora_participacion'])) ?>
        </div>
        <div class="text-xs text-gray-500">
          Hora de participación
        </div>
      <?php else: ?>
        <div class="text-sm text-gray-500">
          Sin hora asignada
        </div>
      <?php endif; ?>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col space-y-1">
      <!-- Estado de Asistencia -->
      <div class="flex items-center">
        <?php
        $estado_clase = '';
        $estado_texto = '';
        switch ($ponente['estado_asistencia']) {
          case 'confirmado':
            $estado_clase = 'bg-green-100 text-green-800';
            $estado_texto = 'Confirmado';
            break;
          case 'pendiente':
            $estado_clase = 'bg-yellow-100 text-yellow-800';
            $estado_texto = 'Pendiente';
            break;
          case 'ausente':
            $estado_clase = 'bg-red-100 text-red-800';
            $estado_texto = 'Ausente';
            break;
          default:
            $estado_clase = 'bg-gray-100 text-gray-800';
            $estado_texto = 'Sin estado';
        }
        ?>
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $estado_clase ?>">
          <?= $estado_texto ?>
        </span>
      </div>
      
      <!-- Certificado -->
      <div class="flex items-center">
        <?php if ($ponente['certificado_generado'] == 1): ?>
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Certificado generado
          </span>
        <?php else: ?>
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            Sin certificado
          </span>
        <?php endif; ?>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <?php
    $archivo_acciones = __DIR__ . '\..\..\..\helpers\acciones_ponente_evento.php';
    if (file_exists($archivo_acciones)) {
      include $archivo_acciones;
    } else {
      echo '<div class="flex items-center justify-end space-x-2">';
      echo '<button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Editar</button>';
      echo '<button class="text-red-600 hover:text-red-900 text-sm font-medium ml-3">Eliminar</button>';
      echo '</div>';
    }
    ?>
  </td>
</tr>