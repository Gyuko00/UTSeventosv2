<?php
// app/modules/admin/editar_asignacion_ponente.view.php
?>
<div class="space-y-10">
    <?php include __DIR__ . '\components\ponentes_evento\crud\editar\header.php'; ?>
    
    <?php include __DIR__ . '\components\ponentes_evento\crud\editar\alerta_error.php'; ?>
    
    <form 
        id="editarAsignacionForm"
        method="POST"
        action="<?= URL_PATH ?>/admin/editarAsignacionPonente/<?= $ponente['id_ponente_evento'] ?>"
        class="space-y-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200"
    >
        <?php
        include __DIR__ . '\components\ponentes_evento\crud\editar\informacion_ponente.php';
        include __DIR__ . '\components\ponentes_evento\crud\editar\informacion_evento.php';
        include __DIR__ . '\components\ponentes_evento\crud\editar\configuracion_participacion.php';
        ?>
        
        <?php include __DIR__ . '\components\ponentes_evento\crud\editar\botones_accion.php'; ?>
    </form>
</div>

<script>
    const URL_PATH = "<?= URL_PATH ?>";
    const PONENTE_EVENTO_ID = <?= $ponente['id_ponente_evento'] ?>;
    
    window.ponenteEventoData = <?= json_encode($ponente ?? []) ?>;
    document.addEventListener('DOMContentLoaded', () => {
        const sel = document.querySelector('select[name="speaker_event[id_evento]"]');
        if (sel && sel.value) sel.dispatchEvent(new Event('change'));
    });
</script>
<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/editar_asignacion/main.js"></script>
<script>
  window.eventosData = [
    {
      id_evento: <?= (int)($ponente['id_evento'] ?? 0) ?>,
      hora_inicio: "<?= htmlspecialchars($ponente['hora_inicio'] ?? '') ?>",
      hora_fin: "<?= htmlspecialchars($ponente['hora_fin'] ?? '') ?>"
    }
  ];
</script>
<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/asignar_ponente/timeline.js"></script>

