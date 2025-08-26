<?php 
// app/modules/user/components/perfil/evento_card.php
// Este archivo debe ser incluido donde $evento esté definido
?>

<div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow bg-gray-50">
  <div class="flex justify-between items-start mb-3">
    <div class="flex-1">
      <h4 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
        <?= $evento['titulo'] ?>
      </h4>
      
      <?php if ($evento['tema'] !== 'Sin tema'): ?>
        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-2">
          <?= $evento['tema'] ?>
        </span>
      <?php endif; ?>
    </div>
    
    <!-- Estado del evento -->
    <div class="flex flex-col items-end gap-1 ml-4">
      <?php if ($evento['es_proximo']): ?>
        <?php if ($evento['dias_restantes'] == 0): ?>
          <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Hoy</span>
        <?php elseif ($evento['dias_restantes'] == 1): ?>
          <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">Mañana</span>
        <?php elseif ($evento['dias_restantes'] <= 7): ?>
          <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2 py-1 rounded-full">
            <?= $evento['dias_restantes'] ?> días
          </span>
        <?php else: ?>
          <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">Próximo</span>
        <?php endif; ?>
      <?php else: ?>
        <?php if ($evento['estado_asistencia'] == 1): ?>
          <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">✓ Asistido</span>
        <?php else: ?>
          <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">No asistido</span>
        <?php endif; ?>
      <?php endif; ?>
      
      <!-- Certificado disponible -->
      <?php if ($evento['certificado_disponible']): ?>
        <button class="text-orange-600 hover:text-orange-700 text-xs underline certificado-btn"
                data-evento-id="<?= $evento['id_evento'] ?>"
                data-token="<?= $evento['token'] ?>">
          📄 Certificado
        </button>
      <?php endif; ?>
    </div>
  </div>
  
  <!-- Información del evento -->
  <div class="space-y-2 text-xs text-gray-600">
    <div class="flex items-center gap-2">
      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
      </svg>
      <span><?= $evento['fecha_formateada'] ?></span>
    </div>
    
    <div class="flex items-center gap-2">
      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
      </svg>
      <span><?= $evento['hora_inicio'] ?> - <?= $evento['hora_fin'] ?></span>
    </div>
    
    <div class="flex items-start gap-2">
      <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
      </svg>
      <span class="line-clamp-2"><?= $evento['ubicacion'] ?></span>
    </div>
    
    <?php if ($evento['descripcion']): ?>
      <div class="flex items-start gap-2">
        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
        </svg>
        <span class="line-clamp-3"><?= $evento['descripcion'] ?></span>
      </div>
    <?php endif; ?>
  </div>
  
  <!-- Footer con cupos -->
  <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
    <div class="text-xs text-gray-500">
      Inscritos: <?= $evento['total_inscritos'] ?>/<?= $evento['cupo_maximo'] ?>
    </div>
    
    <div class="text-xs text-gray-400">
      Inscrito el <?= date('d/m/Y', strtotime($evento['fecha_inscripcion'])) ?>
    </div>
  </div>
</div>

<style>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>