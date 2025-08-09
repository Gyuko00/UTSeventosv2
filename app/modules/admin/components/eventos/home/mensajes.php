<?php
// app/modules/admin/components/eventos/home/mensajes.php
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= $_SESSION['success_message'] ?></span>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= $_SESSION['error_message'] ?></span>
        <?php unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>