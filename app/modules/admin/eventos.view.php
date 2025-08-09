<?php
// app/modules/admin/eventos.view.php
?>

<div class="space-y-6">
    <?php include_once __DIR__ . '\components\eventos\home\header.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\home\filtros.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\home\mensajes.php'; ?>
    
    <?php include_once __DIR__ . '\components\eventos\home\tabla.php'; ?>
</div>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/home/eventos.js"></script>