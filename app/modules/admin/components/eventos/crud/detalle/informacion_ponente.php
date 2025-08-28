<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/informacion_ponente.php

$ponentes = $evento['ponentes'] ?? null;
$estadoMapClases = [
    'asistio'      => 'bg-green-100 text-green-800',
    'confirmado'   => 'bg-green-100 text-green-800',
    'no_asistio'   => 'bg-red-100 text-red-800',
    'cancelado'    => 'bg-red-100 text-red-800',
    'ausente'      => 'bg-red-100 text-red-800',
    'pendiente'    => 'bg-yellow-100 text-yellow-800',
];

$estadoMapTextos = [
    'asistio'      => 'Asistió',
    'confirmado'   => 'Confirmado',
    'no_asistio'   => 'No asistió',
    'cancelado'    => 'Cancelado',
    'ausente'      => 'Ausente',
    'pendiente'    => 'Pendiente',
];
?>

<div class="bg-white shadow rounded-lg p-6">
  <h2 class="text-lg font-medium text-gray-900 mb-4">
    Información del Ponente<?= !empty($ponentes) && count($ponentes) > 1 ? 's Asignados' : ' Asignado' ?>
  </h2>

  <?php if (!empty($ponentes) && is_array($ponentes)): ?>
    <div class="space-y-6">
      <?php foreach ($ponentes as $p): 
        $estado = strtolower((string)($p['estado_asistencia'] ?? 'pendiente'));
        $badgeClase = $estadoMapClases[$estado] ?? $estadoMapClases['pendiente'];
        $badgeTexto = $estadoMapTextos[$estado] ?? 'Pendiente';
      ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border rounded-lg p-4">
          <div>
            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
            <dd class="mt-1 text-sm text-gray-900">
              <?= htmlspecialchars(trim(($p['ponente_nombres'] ?? '').' '.($p['ponente_apellidos'] ?? ''))) ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
            <dd class="mt-1 text-sm text-gray-900">
              <?php $mail = $p['ponente_email'] ?? ''; ?>
              <?php if ($mail): ?>
                <a href="mailto:<?= htmlspecialchars($mail) ?>" class="text-blue-600 hover:text-blue-500">
                  <?= htmlspecialchars($mail) ?>
                </a>
              <?php else: ?>
                <span class="text-gray-500">No disponible</span>
              <?php endif; ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Hora de Participación</dt>
            <dd class="mt-1 text-sm text-gray-900">
              <?= !empty($p['hora_participacion']) ? date('H:i', strtotime($p['hora_participacion'])) : 'No especificada' ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Estado de Asistencia</dt>
            <dd class="mt-1">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badgeClase ?>">
                <?= $badgeTexto ?>
              </span>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Certificado</dt>
            <dd class="mt-1">
              <?php if ((int)($p['certificado_generado'] ?? 0) === 1): ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  Generado
                </span>
              <?php else: ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  Pendiente
                </span>
              <?php endif; ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
            <dd class="mt-1 text-sm text-gray-900">
              <?= !empty($p['fecha_registro']) ? date('d/m/Y H:i', strtotime($p['fecha_registro'])) : 'No disponible' ?>
            </dd>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <?php // Fallback: si aún existe $evento['ponente'] individual, se muestra ese. ?>
    <?php if (!empty($evento['ponente'])): 
      $p = $evento['ponente'];
      $estado = strtolower((string)($p['estado_asistencia'] ?? 'pendiente'));
      $badgeClase = $estadoMapClases[$estado] ?? $estadoMapClases['pendiente'];
      $badgeTexto = $estadoMapTextos[$estado] ?? 'Pendiente';
    ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
          <dd class="mt-1 text-sm text-gray-900">
            <?= htmlspecialchars(trim(($p['ponente_nombres'] ?? '').' '.($p['ponente_apellidos'] ?? ''))) ?>
          </dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
          <dd class="mt-1 text-sm text-gray-900">
            <a href="mailto:<?= htmlspecialchars($p['ponente_email'] ?? '') ?>" class="text-blue-600 hover:text-blue-500">
              <?= htmlspecialchars($p['ponente_email'] ?? 'No disponible') ?>
            </a>
          </dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500">Hora de Participación</dt>
          <dd class="mt-1 text-sm text-gray-900">
            <?= !empty($p['hora_participacion']) ? date('H:i', strtotime($p['hora_participacion'])) : 'No especificada' ?>
          </dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500">Estado de Asistencia</dt>
          <dd class="mt-1">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badgeClase ?>">
              <?= $badgeTexto ?>
            </span>
          </dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500">Certificado</dt>
          <dd class="mt-1">
            <?php if ((int)($p['certificado_generado'] ?? 0) === 1): ?>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Generado
              </span>
            <?php else: ?>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                Pendiente
              </span>
            <?php endif; ?>
          </dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
          <dd class="mt-1 text-sm text-gray-900">
            <?= !empty($p['fecha_registro']) ? date('d/m/Y H:i', strtotime($p['fecha_registro'])) : 'No disponible' ?>
          </dd>
        </div>
      </div>
    <?php else: ?>
      <p class="text-sm text-gray-600">No hay ponentes asignados a este evento.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>
