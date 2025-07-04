<!--
Tabla de eventos inscritos

Renderiza una tabla con la lista de eventos a los que el usuario ya se ha inscrito.
-->

<table class="w-full text-sm text-left text-gray-700 border border-gray-200 shadow-sm">
  <thead class="bg-green-100 text-green-800 uppercase text-xs">
    <tr>
      <th class="px-4 py-3">Evento</th>
      <th class="px-4 py-3">Fecha</th>
      <th class="px-4 py-3">Hora</th>
      <th class="px-4 py-3">Institución</th>
      <th class="px-4 py-3">Lugar</th>
      <th class="px-4 py-3 text-center">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($eventos)): ?>
      <tr>
        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No estás inscrito a ningún evento por ahora.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($eventos as $evento): ?>
        <?php
          $fechaEvento = strtotime($evento['fecha'] . ' ' . $evento['hora_fin']);
          $eventoFinalizado = $fechaEvento < time();
          $estaInscrito = $evento['inscrito'] ?? false;
          $asistio = $evento['estado_asistencia'] === 'si';
          $certGenerado = $evento['certificado_generado'] == 1;
        ?>
        <tr class="border-t border-gray-200 hover:bg-green-50">
          <td class="px-4 py-3 font-semibold text-green-900"><?= htmlspecialchars($evento['titulo_evento']) ?></td>
          <td class="px-4 py-3"><?= date('d/m/Y', strtotime($evento['fecha'])) ?></td>
          <td class="px-4 py-3"><?= date('H:i', strtotime($evento['hora_inicio'])) ?> - <?= date('H:i', strtotime($evento['hora_fin'])) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($evento['institucion_evento']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($evento['lugar_detallado']) ?></td>
          <td class="px-4 py-2 text-center">
            <?php if ($eventoFinalizado): ?>
              <?php if ($estaInscrito && $asistio && $certGenerado): ?>
                <a href="<?= URL_PATH ?>/certificates/descargar?id_evento=<?= $evento['id_evento'] ?>" 
                   class="text-green-700 hover:underline font-medium">Descargar certificado</a>
              <?php else: ?>
                <span class="text-gray-400 italic">No asististe o sin certificado</span>
              <?php endif; ?>
            <?php else: ?>
              <?php if ($estaInscrito): ?>
                <div class="flex gap-3 justify-center items-center">
                  <a href="<?= URL_PATH ?>/ticket/generarQR?id_evento=<?= $evento['id_evento'] ?>" 
                     class="text-green-700 font-medium hover:underline">Código QR</a>
                  <form class="form-cancelar" action="<?= URL_PATH ?>/user/cancelarInscripcion" method="POST">
                    <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                    <button type="submit" class="text-red-600 hover:underline font-medium">Cancelar inscripción</button>
                  </form>
                </div>
              <?php else: ?>
                <form class="form-inscribirse" action="<?= URL_PATH ?>/user/inscribirse" method="POST">
                  <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                  <button type="submit" class="text-green-700 hover:underline font-medium">Inscribirse</button>
                </form>
              <?php endif; ?>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<script src="<?= URL_PATH ?>/app/modules/user/js/ValidateRegistration.js"></script>
