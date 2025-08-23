<?php 
// app/modules/admin/detalle_ponente_evento.view.php 
?>
<div class="space-y-6">
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\informacion_ponente.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\informacion_asignacion.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\informacion_evento.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\informacion_estado.php'; ?>
    
    <?php include_once __DIR__ . '\components\ponentes_evento\crud\detalle\botones_accion.php'; ?>
</div>