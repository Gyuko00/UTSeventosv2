<!--
Evento

Renderiza la información detallada de un evento, incluyendo su descripción, 
fecha, hora, lugar, cupo máximo y los ponentes.
-->


<section class="space-y-6">
  <h2 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($evento['titulo_evento']) ?></h2>

  <div class="bg-white p-6 rounded shadow border border-gray-200">
    <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($evento['descripcion'])) ?></p>
    <p class="mt-2"><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($evento['fecha'])) ?></p>
    <p><strong>Hora:</strong> <?= date('H:i', strtotime($evento['hora_inicio'])) ?> - <?= date('H:i', strtotime($evento['hora_fin'])) ?></p>
    <p><strong>Departamento:</strong> <?= htmlspecialchars($evento['departamento_evento']) ?></p>
    <p><strong>Municipio:</strong> <?= htmlspecialchars($evento['municipio_evento']) ?></p>
    <p><strong>Institución:</strong> <?= htmlspecialchars($evento['institucion_evento']) ?></p>
    <p><strong>Lugar detallado:</strong> <?= htmlspecialchars($evento['lugar_detallado']) ?></p>
    <p><strong>Cupo máximo:</strong> <?= $evento['cupo_maximo'] ?></p>
  </div>

  <?php if (!empty($ponentes)): ?>
    <div class="mt-8">
      <h3 class="text-2xl font-semibold text-gray-700 mb-4">Invitados especiales</h3>
      <div class="grid md:grid-cols-2 gap-4">
        <?php foreach ($ponentes as $ponente): ?>
          <div class="bg-gray-50 border rounded p-4 shadow-sm">
            <h4 class="text-lg font-bold text-gray-800 mb-1"><?= htmlspecialchars($ponente['nombres'] . ' ' . $ponente['apellidos']) ?></h4>
            <p><strong>Hora participación:</strong> <?= htmlspecialchars($ponente['hora_participacion']) ?></p>
            <p><strong>Tema:</strong> <?= htmlspecialchars($ponente['tema']) ?></p>
            <p><strong>Especialización:</strong> <?= htmlspecialchars($ponente['especializacion']) ?></p>
            <p><strong>Institución:</strong> <?= htmlspecialchars($ponente['institucion_ponente']) ?></p>
            <p class="mt-2 text-sm text-gray-600"><strong>Biografía:</strong><br><?= nl2br(htmlspecialchars($ponente['descripcion_biografica'])) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="mt-6 flex gap-4">
    <a href="<?= URL_PATH ?>/user/home" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm">
      ← Volver
    </a>

    <form action="<?= URL_PATH ?>/user/inscribirse" method="POST" onsubmit="return confirm('¿Deseas inscribirte en este evento?');">
      <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
      <input type="hidden" name="cupo_maximo" value="<?= $evento['cupo_maximo'] ?>">
      <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
        Inscribirse
      </button>
    </form>
  </div>
</section>
