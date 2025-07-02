<!--
Tabla de eventos

Muestra una tabla con los eventos disponibles para inscribirse.
-->

<table class="w-full text-sm text-left text-gray-700 border border-gray-200 shadow-sm">
  <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
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
        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No hay eventos disponibles en este momento.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($eventos as $evento): ?>
        <tr class="border-t border-gray-200 hover:bg-gray-50">
          <td class="px-4 py-3 font-medium"><?= htmlspecialchars($evento['nombre']) ?></td>
          <td class="px-4 py-3"><?= date('d/m/Y', strtotime($evento['fecha'])) ?></td>
          <td class="px-4 py-3"><?= date('H:i', strtotime($evento['hora_inicio'])) ?> - <?= date('H:i', strtotime($evento['hora_fin'])) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($evento['lugar']) ?></td>
          <td class="px-4 py-3">
            <?= $evento['cupo_maximo'] - $evento['inscritos'] ?>
          </td>
          <td class="px-4 py-2 flex justify-center gap-2">
            <!-- Ver más -->
            <a href="<?= URL_PATH ?>/user/evento?id_evento=<?= $evento['id_evento'] ?>" 
               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
              Ver más
            </a>
            <!-- Formulario de inscripción -->
            <form action="<?= URL_PATH ?>/user/inscribirse" method="POST" onsubmit="return confirm('¿Deseas inscribirte en este evento?');">
              <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
              <input type="hidden" name="cupo_maximo" value="<?= $evento['cupo_maximo'] ?>">
              <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                Inscribirse
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
