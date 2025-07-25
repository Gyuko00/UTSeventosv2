<?php
// app/modules/admin/usuarios.view.php
?>

<div class="space-y-6">
    <?php include_once __DIR__ . '\components\usuarios\home\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\usuarios\home\filtros.php'; ?>
    
    <?php include_once __DIR__ . '\components\usuarios\home\mensajes.php'; ?>
    
    <?php include_once __DIR__ . '\components\usuarios\home\tabla.php'; ?>
</div>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/user/usuarios.js"></script>