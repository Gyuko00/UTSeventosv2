<?php
// app/modules/admin/components/ponentes_evento/home/tabla/ponente_evento_row.php

$id_evento = $ponente['id_evento'] ?? 'N/A';
$id_ponente = $ponente['id_ponente'] ?? 'N/A';
$nombres = $ponente['nombres'] ?? 'Sin nombre';
$apellidos = $ponente['apellidos'] ?? 'Sin apellido';
$tema = $ponente['tema'] ?? 'Sin tema';
$institucion = $ponente['institucion_ponente'] ?? 'Sin institución';
$titulo_evento = $ponente['titulo_evento'] ?? 'Sin título';
$fecha = $ponente['fecha'] ?? null;
$hora_participacion = $ponente['hora_participacion'] ?? null;
$estado_asistencia = $ponente['estado_asistencia'] ?? 'pendiente';
$certificado_generado = $ponente['certificado_generado'] ?? 0;
?>

<tr 
  class="hover:bg-lime-50 transition-colors duration-150"
  data-evento-id="<?= htmlspecialchars($id_evento) ?>"
  data-ponente-id="<?= htmlspecialchars($id_ponente) ?>"
  data-nombre="<?= strtolower($nombres . ' ' . $apellidos) ?>"
  data-tema="<?= strtolower($tema) ?>"
>
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center gap-3">
      <div class="h-11 w-11 flex-shrink-0 rounded-full bg-green-100 flex items-center justify-center shadow-sm">
        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 640 640">
          <path d="M192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C51.6 288 0 339.6 0 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zM480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm48 32h-3.8c-13.9 4.8-28.6 8-44.2 8s-30.3-3.2-44.2-8H432c-20.4 0-39.2 5.9-55.7 15.4 24.4 26.3 39.7 61.2 39.7 99.8v38.4c0 2.2-.5 4.3-.6 6.4H592c26.5 0 48-21.5 48-48 0-61.9-50.1-112-112-112z"/>
        </svg>
      </div>
      
      <div>
        <div class="text-base font-semibold text-gray-900 leading-5">
          <?= htmlspecialchars($nombres . ' ' . $apellidos) ?>
        </div>
        <div class="text-sm text-gray-600 leading-4 flex items-center gap-2">
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            <?= htmlspecialchars($tema) ?>
          </span>
          <span class="text-xs text-gray-500">ID: <?= htmlspecialchars($id_ponente) ?></span>
        </div>
        <div class="text-xs text-gray-500 mt-1">
          <?= htmlspecialchars($institucion) ?>
        </div>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <div class="text-base font-medium text-gray-900 leading-5">
        <?= htmlspecialchars($titulo_evento) ?>
      </div>
      <div class="text-sm text-gray-600 leading-4">
        <?php if ($fecha): ?>
          <?= date('d/m/Y', strtotime($fecha)) ?>
        <?php else: ?>
          <span class="text-gray-400">Sin fecha</span>
        <?php endif; ?>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-col">
      <?php if (!empty($hora_participacion)): ?>
        <div class="text-base font-medium text-gray-900 leading-5">
          <?= date('H:i', strtotime($hora_participacion)) ?>
        </div>
        <div class="text-sm text-gray-600 leading-4">
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
    <div class="flex flex-col space-y-2">
      <div class="flex items-center">
        <?php
        $estado_clase = '';
        $estado_texto = '';
        switch ($estado_asistencia) {
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
          case 'cancelado':
            $estado_clase = 'bg-gray-100 text-gray-800';
            $estado_texto = 'Cancelado';
            break;
          default:
            $estado_clase = 'bg-gray-100 text-gray-800';
            $estado_texto = 'Sin estado';
        }
        ?>
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold <?= $estado_clase ?>">
          <?= $estado_texto ?>
        </span>
      </div>
      
      <div class="flex items-center">
        <?php if ($certificado_generado == 1): ?>
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Certificado
          </span>
        <?php else: ?>
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            Sin certificado
          </span>
        <?php endif; ?>
      </div>
    </div>
  </td>
  
  <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
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