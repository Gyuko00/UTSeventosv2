<?php 
// app/modules/admin/eventos/components/eventos/crud/detalle/boton_agregar_ponente.php 
?>
<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                👨‍🏫 Gestionar Ponentes
            </h3>
            <p class="text-gray-600 text-sm">
                Agrega un ponente a este evento desde la lista de ponentes disponibles.
            </p>
        </div>
        
        <div class="flex gap-3">
            <?php if (isset($evento['ponente']) && !empty($evento['ponente'])): ?>
                <button 
                    id="btnCambiarPonente" 
                    data-evento-id="<?= htmlspecialchars($evento['id_evento']) ?>"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Cambiar Ponente
                </button>
            <?php else: ?>
                <button 
                    id="btnAgregarPonente" 
                    data-evento-id="<?= htmlspecialchars($evento['id_evento']) ?>"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Agregar Ponente
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>