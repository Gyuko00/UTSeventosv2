<?php
// app/modules/admin/eventos/detalle_evento.view.php
?>
<div class="space-y-6">
    <?php include_once __DIR__ . '\components\detalle_evento\header.php'; ?>
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_evento.php'; ?>
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_ubicacion.php'; ?>
    <?php include_once __DIR__ . '\components\detalle_evento\informacion_creador.php'; ?>
    
    <?php if (isset($evento['ponente']) && !empty($evento['ponente'])): ?>
        <?php include_once __DIR__ . '\components\detalle_evento\informacion_ponente.php'; ?>
    <?php endif; ?>
    
    <?php if (isset($evento['participantes']) && !empty($evento['participantes'])): ?>
        <?php include_once __DIR__ . '\components\detalle_evento\lista_participantes.php'; ?>
    <?php endif; ?>
    
    <?php if ($usuario_logueado): ?>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                Mis Acciones
            </h3>
            
            <?php if ($inscripcion['inscrito']): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-green-800 font-medium">¡Ya estás inscrito en este evento!</p>
                            <p class="text-green-600 text-sm">
                                Inscrito el <?= date('d/m/Y', strtotime($inscripcion['datos_inscripcion']['fecha_inscripcion'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button 
                        class="btn-entrada flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors"
                        data-evento-id="<?= $evento['id_evento'] ?>"
                        data-token="<?= $inscripcion['datos_inscripcion']['token'] ?>"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zM13 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                        </svg>
                        Entrada (QR)
                    </button>
                    
                    <button 
                        class="btn-certificado flex items-center justify-center gap-2 text-white px-4 py-3 rounded-lg transition-colors <?= $inscripcion['datos_inscripcion']['certificado_generado'] ? 'bg-purple-600 hover:bg-purple-700' : 'bg-gray-400 cursor-not-allowed' ?>"
                        data-evento-id="<?= $evento['id_evento'] ?>"
                        data-token="<?= $inscripcion['datos_inscripcion']['token'] ?>"
                        <?= !$inscripcion['datos_inscripcion']['certificado_generado'] ? 'disabled' : '' ?>
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                        <?= $inscripcion['datos_inscripcion']['certificado_generado'] ? 'Certificado' : 'Certificado no disponible' ?>
                    </button>
                    
                    <button 
                        class="btn-cancelar flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors"
                        data-evento-id="<?= $evento['id_evento'] ?>"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Cancelar Inscripción
                    </button>
                </div>
                
            <?php else: ?>
                <div class="text-center">
                    <button 
                        class="btn-inscribirse bg-green-600 hover:bg-green-700 text-white p-2 px-8 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 mx-auto"
                        data-evento-id="<?= $evento['id_evento'] ?>"
                        data-evento-titulo="<?= htmlspecialchars($evento['titulo_evento'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Inscribirme al Evento
                    </button>
                    
                    <?php if (isset($evento['estadisticas'])): ?>
                    <p class="text-gray-600 text-sm mt-3">
                        Cupos disponibles: <?= ($evento['cupo_maximo'] - ($evento['estadisticas']['total_inscritos'] ?? 0)) ?> de <?= $evento['cupo_maximo'] ?>
                    </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-yellow-800 font-medium">Inicia sesión para inscribirte</p>
                    <p class="text-yellow-600 text-sm">Necesitas una cuenta para participar en los eventos</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    const URL_PATH = "<?= URL_PATH ?>";
</script>

<script type="module" src="<?= URL_PATH ?>/assets/js/user/home/calendar.register.js"></script>
<script src="<?= URL_PATH ?>/assets/js/user/profile/perfil/acciones_detalle.js"></script>
