<?php
// app/modules/admin/components/eventos/home/header.php
?>

<div class="bg-gradient-to-r from-lime-600 to-lime-700 rounded-xl shadow-lg p-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m4 4V8a2 2 0 00-2-2H6a2 2 0 00-2 2v3M2 17h20v-2a2 2 0 00-2-2H4a2 2 0 00-2 2v2zM6 21v-4a2 2 0 012-2h8a2 2 0 012 2v4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Gestión de Eventos</h1>
                    <p class="text-lime-100 opacity-90 text-lg">Administra todos los eventos del sistema</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-6 text-sm">
                <div class="flex items-center gap-2">
                    <div class="bg-white/30 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span>Crear y administrar</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-white/30 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span>Gestión de ubicaciones</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-white/30 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>Control de horarios</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-white/30 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span>Capacidad y asistentes</span>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0">
            <a href="<?= URL_PATH ?>/admin/crearEvento" 
               class="inline-flex items-center gap-3 bg-white text-lime-700 hover:bg-lime-50 font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Nuevo Evento</span>
            </a>
        </div>
    </div>
</div>