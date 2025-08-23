<!-- components\ponentes_evento\crud\asignar\botones_accion.php -->
<div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
    <button 
        type="submit" 
        class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2 font-medium"
    >
        <i class="fas fa-save"></i>
        Asignar Ponente
    </button>
    
    <button 
        type="button" 
        id="btnLimpiar"
        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2 font-medium"
    >
        <i class="fas fa-eraser"></i>
        Limpiar
    </button>
    
    <a 
        href="<?= URL_PATH ?>/admin/listarPonentes"
        class="flex-1 bg-red-100 text-red-700 px-6 py-3 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center gap-2 font-medium text-center"
    >
        <i class="fas fa-times"></i>
        Cancelar
    </a>
</div>