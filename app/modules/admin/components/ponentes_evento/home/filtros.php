<?php 
// app/modules/admin/components/ponentes_evento/home/filtros.php 
?>
<div class="bg-white rounded-lg shadow-sm px-6 py-4 mb-6">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        
        <!-- Búsqueda general -->
        <div class="flex-1 min-w-[280px]">
            <label for="buscarPonenteEvento" class="block text-sm text-gray-600 mb-1 font-medium">Buscar ponente o evento</label>
            <input 
                type="text" 
                id="buscarPonenteEvento" 
                placeholder="Tema, institución, evento..."
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent placeholder-gray-400"
            >
        </div>

        <!-- Filtro por evento -->
        <div class="min-w-[200px]">
            <label for="filtroEvento" class="block text-sm text-gray-600 mb-1 font-medium">Evento</label>
            <select 
                id="filtroEvento" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los eventos</option>
                <?php if (isset($eventos) && !empty($eventos)): ?>
                    <?php foreach ($eventos as $evento): ?>
                        <option value="<?= $evento['id_evento'] ?>">
                            <?= htmlspecialchars($evento['titulo_evento']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Filtro por estado de asistencia -->
        <div class="min-w-[180px]">
            <label for="filtroEstado" class="block text-sm text-gray-600 mb-1 font-medium">Estado</label>
            <select 
                id="filtroEstado" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="confirmado">Confirmado</option>
                <option value="ausente">Ausente</option>
            </select>
        </div>

        <!-- Filtro por certificado -->
        <div class="min-w-[160px]">
            <label for="filtroCertificado" class="block text-sm text-gray-600 mb-1 font-medium">Certificado</label>
            <select 
                id="filtroCertificado" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos</option>
                <option value="1">Generado</option>
                <option value="0">Pendiente</option>
            </select>
        </div>

        <!-- Filtro por institución -->
        <div class="min-w-[200px]">
            <label for="filtroInstitucion" class="block text-sm text-gray-600 mb-1 font-medium">Institución</label>
            <select 
                id="filtroInstitucion" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todas las instituciones</option>
                <?php if (isset($instituciones) && !empty($instituciones)): ?>
                    <?php foreach ($instituciones as $institucion): ?>
                        <option value="<?= htmlspecialchars($institucion) ?>">
                            <?= htmlspecialchars($institucion) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Filtro por fecha del evento -->
        <div class="min-w-[180px]">
            <label for="filtroFecha" class="block text-sm text-gray-600 mb-1 font-medium">Fecha evento</label>
            <select 
                id="filtroFecha" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todas las fechas</option>
                <option value="hoy">Hoy</option>
                <option value="semana">Esta semana</option>
                <option value="mes">Este mes</option>
                <option value="proximos">Próximos</option>
                <option value="pasados">Pasados</option>
            </select>
        </div>

        <!-- Botón limpiar -->
        <div class="mt-5 sm:mt-6">
            <button 
                onclick="limpiarFiltrosPonentes()"
                class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800 font-semibold transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Limpiar
            </button>
        </div>
    </div>

    <!-- Contador de resultados -->
    <div class="mt-4 pt-3 border-t border-gray-100">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span id="contadorResultados">Mostrando todos los registros</span>
            <div class="flex items-center gap-4">
                <button 
                    id="exportarPonentes"
                    class="inline-flex items-center gap-1 text-lime-600 hover:text-lime-800 font-medium transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exportar
                </button>
            </div>
        </div>
    </div>
</div>

<script>

</script>