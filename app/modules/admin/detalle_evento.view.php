<?php
// app/modules/admin/eventos/detalle_evento.view.php
?>
<div class="space-y-6">
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\informacion_evento.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\informacion_ubicacion.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\informacion_creador.php'; ?>
    
    <?php if (isset($evento['ponentes']) && !empty($evento['ponentes'])): ?>
        <?php include_once __DIR__ . '\components\eventos\crud\detalle\informacion_ponente.php'; ?>
    <?php endif; ?>
    
    <?php if (isset($evento['estadisticas'])): ?>
        <?php include_once __DIR__ . '\components\eventos\crud\detalle\estadisticas_evento.php'; ?>
    <?php endif; ?>
    
    <?php if (isset($evento['participantes']) && !empty($evento['participantes'])): ?>
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\lista_participantes.php'; ?>
    <?php endif; ?>
    
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\boton_reporte.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\crud\detalle\botones_accion.php'; ?>
    
</div>