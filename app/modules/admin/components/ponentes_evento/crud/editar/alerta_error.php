<?php
// app/modules/admin/components/ponentes_evento/crud/editar/alerta_error.php

// Verificar si hay mensajes de éxito o error en la sesión
$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;

// Verificar si hay error pasado como parámetro
$form_error = $error ?? null;

// Limpiar mensajes de la sesión después de mostrarlos
if ($success_message) {
    unset($_SESSION['success_message']);
}
if ($error_message) {
    unset($_SESSION['error_message']);
}
?>

<?php if ($success_message): ?>
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6" role="alert">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-green-800 mb-1">
                ¡Operación Exitosa!
            </h3>
            <p class="text-sm text-green-700">
                <?= htmlspecialchars($success_message) ?>
            </p>
        </div>
        <button type="button" class="flex-shrink-0 text-green-400 hover:text-green-600 transition-colors duration-200" onclick="this.parentElement.parentElement.remove()">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if ($error_message): ?>
<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6" role="alert">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-red-800 mb-1">
                Error en la Operación
            </h3>
            <p class="text-sm text-red-700">
                <?= htmlspecialchars($error_message) ?>
            </p>
        </div>
        <button type="button" class="flex-shrink-0 text-red-400 hover:text-red-600 transition-colors duration-200" onclick="this.parentElement.parentElement.remove()">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</div>
<?php endif; ?>

<?php if ($form_error): ?>
<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6" role="alert">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-red-800 mb-1">
                Error de Validación
            </h3>
            <p class="text-sm text-red-700">
                <?= htmlspecialchars($form_error) ?>
            </p>
            <div class="mt-2">
                <p class="text-xs text-red-600">
                    Por favor, revisa los datos ingresados e inténtalo de nuevo.
                </p>
            </div>
        </div>
        <button type="button" class="flex-shrink-0 text-red-400 hover:text-red-600 transition-colors duration-200" onclick="this.parentElement.parentElement.remove()">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</div>
<?php endif; ?>

<div id="dynamic-alerts" class="space-y-4 mb-6"></div>

<script type="module" src="<?= URL_PATH ?>/assets/js/admin/event/ponentes_evento/editar_asignacion/alerta_error.js"></script>