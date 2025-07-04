<!-- Vista: Lista de eventos disponibles para inscripción -->

<table class="w-full text-sm text-left text-gray-800 border border-green-300 shadow-sm rounded">
  <thead class="bg-green-100 text-green-900 uppercase text-xs">
    <tr>
      <th class="px-4 py-3">Evento</th>
      <th class="px-4 py-3">Fecha</th>
      <th class="px-4 py-3">Hora</th>
      <th class="px-4 py-3">Lugar</th>
      <th class="px-4 py-3">Cupos disponibles</th>
      <th class="px-4 py-3 text-center">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($eventos)): ?>
      <tr>
        <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">
          No hay eventos disponibles en este momento.
        </td>
      </tr>
    <?php else: ?>
      <?php foreach ($eventos as $evento): ?>
        <?php
        $yaFinalizo = strtotime($evento['fecha']) < strtotime(date('Y-m-d'));
        $disponibles = max(0, $evento['cupo_maximo'] - $evento['inscritos']);
        $estaInscrito = (int) $evento['inscrito'] === 1;
        ?>
        <tr class="border-t border-green-200 hover:bg-green-50 transition">
          <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($evento['nombre']) ?></td>
          <td class="px-4 py-3"><?= date('d/m/Y', strtotime($evento['fecha'])) ?></td>
          <td class="px-4 py-3"><?= date('H:i', strtotime($evento['hora_inicio'])) ?> - <?= date('H:i', strtotime($evento['hora_fin'])) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($evento['lugar']) ?></td>
          <td class="px-4 py-3"><?= $disponibles ?></td>
          <td class="px-4 py-3">
            <?php if ($yaFinalizo): ?>
              <span class="text-red-600 font-semibold text-sm">Evento finalizado</span>
            <?php else: ?>
              <div class="flex flex-wrap gap-2 justify-center">
                <a href="<?= URL_PATH ?>/user/evento?id_evento=<?= $evento['id_evento'] ?>" 
                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition">
                  Ver más
                </a>

                <?php if (!$estaInscrito): ?>
                  <!-- Inscribirse -->
                  <form action="<?= URL_PATH ?>/user/inscribirEvento" method="POST" class="form-inscribirse">
                  <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                  <button type="submit" class="bg-lime-500 hover:bg-lime-600 text-white px-3 py-1 rounded text-sm transition">
                    Inscribirse
                  </button>
                </form>

                <?php else: ?>
                  <!-- Descargar QR -->
                  <a href="<?= URL_PATH ?>/ticket/generarQR?id_evento=<?= $evento['id_evento'] ?>" target="_blank"
                     class="text-green-700 font-medium hover:underline">
                    Descargar QR
                  </a>

                  <!-- Cancelar inscripción -->
                  <form action="<?= URL_PATH ?>/user/cancelarInscripcion" method="POST" class="form-cancelar">
                    <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                      Cancelar inscripción
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<script src="<?= URL_PATH ?>/app/modules/user/js/ValidateRegistration.js"></script>

