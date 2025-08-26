<?php
// app/modules/admin/eventos/detalle_evento.view.php
?>
<div class="space-y-6">
    <?php include_once __DIR__ . '\components\detalle_evento\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_evento.php'; ?>
    
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_ubicacion.php'; ?>
    
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_creador.php'; ?>
    
    <?php if (isset($evento['ponente']) && !empty($evento['ponente'])): ?>
        <?php include_once __DIR__ . '\components\detalle_evento\informacion_ponente.php'; ?>
    <?php endif; ?>

    <?php if (isset($evento['participantes']) && !empty($evento['participantes'])): ?>
    <?php include_once __DIR__ . '\components\detalle_evento\lista_participantes.php'; ?>
    <?php endif; ?>
    
</div>