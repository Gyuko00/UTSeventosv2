<?php
// app/modules/admin/usuarios/detalle_usuario.view.php
?>
<div class="space-y-6">
    <?php include_once __DIR__ . '\components\usuarios\crud\detalle\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\usuarios\crud\detalle\informacion_personal.php'; ?>
        
    <?php include_once __DIR__ . '\components\usuarios\crud\detalle\informacion_ubicacion.php'; ?>

    <?php include_once __DIR__ . '\components\usuarios\crud\detalle\informacion_usuario.php'; ?>
    
    <?php if (($usuario['id_rol'] ?? 0) == 2 && isset($usuario['tema'])): ?>
        <?php include_once __DIR__ . '\components\usuarios\crud\detalle\informacion_ponente.php'; ?>
    <?php endif; ?>
    
    <?php if (($usuario['id_rol'] ?? 0) == 3 && isset($usuario['tipo_invitado'])): ?>
        <?php include_once __DIR__ . '\components\usuarios\crud\detalle\informacion_invitado.php'; ?>
    <?php endif; ?>
    
    <?php include_once __DIR__ . '\components\usuarios\crud\detalle\botones_accion.php'; ?>
</div>