<?php
// app/modules/admin/components/eventos/home/filtros.php
?>

<div class="bg-white rounded-lg shadow-sm px-6 py-4">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        
        <div class="flex-1 min-w-[250px]">
            <label for="buscarEvento" class="block text-sm text-gray-600 mb-1 font-medium">Buscar evento</label>
            <input 
                type="text" 
                id="buscarEvento" 
                placeholder="Título, tema o institución..."
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent placeholder-gray-400"
            >
        </div>

        <div class="min-w-[200px]">
            <label for="filtroFecha" class="block text-sm text-gray-600 mb-1 font-medium">Fecha</label>
            <select 
                id="filtroFecha" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            >
                <option value="">Todas las fechas</option>
                <option value="hoy">Hoy</option>
                <option value="semana">Esta semana</option>
                <option value="mes">Este mes</option>
                <option value="proximos">Próximos eventos</option>
                <option value="pasados">Eventos pasados</option>
            </select>
        </div>

        <div class="min-w-[200px]">
            <label for="filtroInstitucion" class="block text-sm text-gray-600 mb-1 font-medium">Institución</label>
            <select 
                id="filtroInstitucion" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            >
                <option value="">Todas las instituciones</option>
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