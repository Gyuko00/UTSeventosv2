<div class="space-y-10">
    <?php include __DIR__ . '\components\ponentes_evento\crud\asignar\header.php'; ?>
    
    <?php include __DIR__ . '\components\ponentes_evento\crud\asignar\alerta_error.php'; ?>
    
    <form 
        id="asignarPonenteForm"
        method="POST"
        action="<?= URL_PATH ?>/admin/asignarPonente"
        class="space-y-10 bg-white p-8 rounded-xl shadow-lg border border-gray-200"
    >
        <?php
            include __DIR__ . '\components\ponentes_evento\crud\asignar\seleccion_evento_ponente.php';
            include __DIR__ . '\components\ponentes_evento\crud\asignar\configuracion_participacion.php';
        ?>
        
        <?php include __DIR__ . '\components\ponentes_evento\crud\asignar\botones_accion.php'; ?>
    </form>
</div>

<script>
    const URL_PATH = "<?= URL_PATH ?>";
    window.eventosData = <?= json_encode($eventos ?? []) ?>;
    window.ponentesData = <?= json_encode($ponentes ?? []) ?>;
</script>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/asignar_ponente/timeline.js"></script>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/asignar_ponente/main.js"></script>