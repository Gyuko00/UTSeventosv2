<?php
// app/modules/admin/components/helpers/acciones-usuario.php
?>

<a href="<?= URL_PATH ?>/admin/detalleUsuario/<?= $usuario['id_usuario'] ?>" 
   class="text-blue-600 hover:text-blue-900 mr-3" title="Ver detalle">
    <i class="fas fa-eye"></i>
</a>
<a href="<?= URL_PATH ?>/admin/editarUsuario/<?= $usuario['id_usuario'] ?>" 
   class="text-indigo-600 hover:text-indigo-900 mr-3" title="Editar">
    <i class="fas fa-edit"></i>
</a>
<button onclick="confirmarEliminacion(<?= $usuario['id_usuario'] ?>, '<?= htmlspecialchars($usuario['usuario']) ?>')" 
        class="text-red-600 hover:text-red-900" title="Eliminar">
    <i class="fas fa-trash"></i>
</button>