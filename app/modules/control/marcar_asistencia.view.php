<?php
// app/modules/control/marcar_asistencia.view.php
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$badge = [
  'success' => 'bg-green-100 text-green-800',
  'info'    => 'bg-blue-100 text-blue-800',
  'error'   => 'bg-red-100 text-red-800',
][$status ?? 'info'] ?? 'bg-blue-100 text-blue-800';
?>
<div class="max-w-xl mx-auto bg-white border border-gray-200 rounded-xl shadow p-6 mt-6">
  <div class="flex items-center gap-2 mb-2">
    <span class="px-2 py-1 text-xs rounded <?= $badge ?>"><?= $h($status ?? 'info') ?></span>
    <h1 class="text-lg font-semibold text-gray-900"><?= $h($title ?? 'Resultado') ?></h1>
  </div>

  <?php if (!empty($message)): ?>
    <p class="text-gray-700 mb-4"><?= $h($message) ?></p>
  <?php endif; ?>

  <?php if (!empty($evento)): ?>
    <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
      <div><span class="text-gray-500">Evento:</span> <strong><?= $h($evento) ?></strong></div>
      <?php if (!empty($nombre)): ?>
        <div><span class="text-gray-500">Invitado:</span> <strong><?= $h($nombre) ?></strong></div>
      <?php endif; ?>
      <?php if (!empty($fecha)): ?>
        <div><span class="text-gray-500">Fecha:</span> <?= $h($fecha) ?></div>
      <?php endif; ?>
      <?php if (!empty($hora_ini) && !empty($hora_fin)): ?>
        <div><span class="text-gray-500">Horario:</span> <?= $h($hora_ini) ?> – <?= $h($hora_fin) ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
