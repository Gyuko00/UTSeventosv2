<?php
// app/modules/admin/components/usuarios/filtros.php
?>

<!-- Filtros y búsqueda -->
<div class="bg-white rounded-lg shadow-sm p-4">
    <div class="flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-64">
            <input type="text" id="buscarUsuario" placeholder="Buscar por nombre, usuario o documento..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div>
            <select id="filtroRol" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los roles</option>
                <option value="1">Administrador</option>
                <option value="2">Ponente</option>
                <option value="3">Invitado</option>
                <option value="4">Control</option>
            </select>
        </div>
        <div>
            <select id="filtroEstado" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los estados</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
        <button onclick="limpiarFiltros()" class="text-gray-600 hover:text-gray-800 px-3 py-2">
            <i class="fas fa-times"></i> Limpiar
        </button>
    </div>
</div>