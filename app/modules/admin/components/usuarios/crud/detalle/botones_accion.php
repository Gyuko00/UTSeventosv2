<div class="flex flex-col sm:flex-row gap-3 justify-end pt-6">
    <a href="<?php echo URL_PATH; ?>/admin/editarUsuario/<?php echo $usuario['id_usuario']; ?>" 
       class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
        <i class="fas fa-edit mr-2"></i>
        Editar Usuario
    </a>
    <a href="<?php echo URL_PATH; ?>/admin/listarUsuarios" 
       class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200 shadow-sm hover:shadow-md">
        <i class="fas fa-arrow-left mr-2"></i>
        Volver a la Lista
    </a>
</div>