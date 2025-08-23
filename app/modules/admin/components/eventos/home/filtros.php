<?php 
// app/modules/admin/components/eventos/home/filtros.php (corregido)
?>
<div class="bg-white rounded-lg shadow-sm px-6 py-4 mb-6">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        
        <div class="flex-1 min-w-[280px]">
            <label for="buscarEvento" class="block text-sm text-gray-600 mb-1 font-medium">Buscar evento</label>
            <input 
                type="text" 
                id="buscarEvento" 
                placeholder="Título, tema, institución, descripción..."
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent placeholder-gray-400"
            >
        </div>

        <div class="min-w-[180px]">
            <label for="filtroFecha" class="block text-sm text-gray-600 mb-1 font-medium">Fecha</label>
            <select 
                id="filtroFecha" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todas las fechas</option>
                <option value="hoy">Hoy</option>
                <option value="manana">Mañana</option>
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

        <div class="min-w-[180px]">
            <label for="filtroDepartamento" class="block text-sm text-gray-600 mb-1 font-medium">Departamento</label>
            <select 
                id="filtroDepartamento" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los departamentos</option>
            </select>
        </div>

        <div class="min-w-[180px]">
            <label for="filtroMunicipio" class="block text-sm text-gray-600 mb-1 font-medium">Municipio</label>
            <select 
                id="filtroMunicipio" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos los municipios</option>
            </select>
        </div>

        <div class="min-w-[160px]">
            <label for="filtroTema" class="block text-sm text-gray-600 mb-1 font-medium">Tema</label>
            <input 
                type="text" 
                id="filtroTema" 
                placeholder="Buscar tema..."
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent placeholder-gray-400"
            >
        </div>

        <div class="min-w-[140px]">
            <label for="filtroCapacidad" class="block text-sm text-gray-600 mb-1 font-medium">Capacidad</label>
            <select 
                id="filtroCapacidad" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todas</option>
                <option value="pequeno">Pequeño (1-50)</option>
                <option value="mediano">Mediano (51-150)</option>
                <option value="grande">Grande (151-500)</option>
                <option value="masivo">Masivo (500+)</option>
            </select>
        </div>

        <div class="min-w-[140px]">
            <label for="filtroHorario" class="block text-sm text-gray-600 mb-1 font-medium">Horario</label>
            <select 
                id="filtroHorario" 
                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-600 focus:border-transparent bg-white"
            >
                <option value="">Todos</option>
                <option value="manana">Mañana (6-12)</option>
                <option value="tarde">Tarde (12-18)</option>
                <option value="noche">Noche (18-24)</option>
            </select>
        </div>

        <div class="mt-5 sm:mt-6">
            <button 
                onclick="limpiarFiltrosEventos()"
                class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800 font-semibold transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Limpiar
            </button>
        </div>
    </div>

    <div class="mt-4 pt-3 border-t border-gray-100">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span id="contadorResultados">Mostrando todos los eventos</span>
            <div class="flex items-center gap-4">
                <button 
                    id="vistaCalendario"
                    class="inline-flex items-center gap-1 text-lime-600 hover:text-lime-800 font-medium transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m4 4V8a2 2 0 00-2-2H6a2 2 0 00-2 2v3M2 17h20v-2a2 2 0 00-2-2H4a2 2 0 00-2 2v2zM6 21v-4a2 2 0 012-2h8a2 2 0 012 2v4"></path>
                    </svg>
                    Calendario
                </button>
            </div>
        </div>
    </div>
</div>

