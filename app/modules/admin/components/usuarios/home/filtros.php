<?php
// app/modules/admin/components/usuarios/filtros.php
?>

<div class="bg-white rounded-lg shadow-sm px-6 py-4">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        
        <div class="flex-1 min-w-[250px]">
            <label for="buscarUsuario" class="block text-sm text-gray-600 mb-1 font-medium">Buscar usuario</label>
            <input 
                type="text" 
                id="buscarUsuario" 
                placeholder="Nombre, usuario o documento..." 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent placeholder-gray-400"
            >
        </div>

        <div class="min-w-[200px]">
            <label for="filtroRol" class="block text-sm text-gray-600 mb-1 font-medium">Rol</label>
            <select 
                id="filtroRol" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los roles</option>
                <option value="1">Administrador</option>
                <option value="2">Ponente</option>
                <option value="3">Invitado</option>
                <option value="4">Control</option>
            </select>
        </div>

        <div class="min-w-[200px]">
            <label for="filtroEstado" class="block text-sm text-gray-600 mb-1 font-medium">Estado</label>
            <select 
                id="filtroEstado" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los estados</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="mt-5 sm:mt-6">
            <button 
                onclick="limpiarFiltros()" 
                class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800 font-semibold"
            >
                <i class="fas fa-times"></i>
                Limpiar
            </button>
        </div>
    </div>
</div>
