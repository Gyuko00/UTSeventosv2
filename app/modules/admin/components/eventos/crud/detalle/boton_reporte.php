<?php
// app/modules/admin/usuarios/components/eventos/crud/detalle/boton_reporte_pdf.php
?>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">📊 Reporte de Invitados</h3>
            <p class="text-gray-600 text-sm">
                Genera un reporte completo en PDF con estadísticas y listado detallado de todos los invitados registrados para este evento.
            </p>
        </div>
        
        <button 
            id="btnGenerarReportePDF" 
            type="button"
            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            data-evento-id="<?php echo htmlspecialchars($evento['id_evento'] ?? ''); ?>"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span id="btnText">Generar PDF</span>
            <svg id="loadingSpinner" class="hidden w-4 h-4 ml-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </div>
    
    <div class="mt-4 text-xs text-gray-500">
        <div class="flex flex-wrap gap-4">
            <span>📋 Incluye listado completo de invitados</span>
            <span>📊 Estadísticas por carrera y programa</span>
            <span>✅ Estados de asistencia</span>
            <span>🏛️ Distribución por facultad</span>
        </div>
    </div>
</div>


<script>
const URL_PATH = "<?= URL_PATH ?>";
document.addEventListener('DOMContentLoaded', function() {
    const btnGenerar = document.getElementById('btnGenerarReportePDF');
    const btnText = document.getElementById('btnText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    if (btnGenerar) {
        btnGenerar.addEventListener('click', function() {
            const eventoId = this.getAttribute('data-evento-id');
            
            if (!eventoId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener el ID del evento',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            Swal.fire({
                title: '📊 Generar Reporte PDF',
                text: '¿Deseas generar el reporte completo de invitados para este evento?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, generar PDF',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        btnGenerar.disabled = true;
                        btnText.textContent = 'Generando...';
                        loadingSpinner.classList.remove('hidden');
                        
                        const reportUrl = URL_PATH + `/admin/report/${eventoId}`;
                        
                        fetch(reportUrl, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json, application/pdf, */*'
                            }
                        })
                        .then(response => {
                            const contentType = response.headers.get('content-type');
                            
                            if (contentType && contentType.includes('application/pdf')) {
                                return response.blob().then(blob => {
                                    const url = window.URL.createObjectURL(blob);
                                    const a = document.createElement('a');
                                    a.href = url;
                                    a.download = `reporte_evento_${eventoId}.pdf`;
                                    document.body.appendChild(a);
                                    a.click();
                                    document.body.removeChild(a);
                                    window.URL.revokeObjectURL(url);
                                    resolve({ success: true, type: 'pdf' });
                                });
                            }
                            else if (contentType && contentType.includes('application/json')) {
                                return response.json().then(data => {
                                    resolve({ success: data.success, data: data, type: 'json' });
                                });
                            }
                            else {
                                reject(new Error('Tipo de respuesta inesperado'));
                            }
                        })
                        .catch(error => {
                            reject(error);
                        })
                        .finally(() => {
                            setTimeout(() => {
                                btnGenerar.disabled = false;
                                btnText.textContent = 'Generar PDF';
                                loadingSpinner.classList.add('hidden');
                            }, 500);
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const response = result.value;
                    
                    if (response.success && response.type === 'pdf') {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ PDF Generado',
                            text: 'El reporte se ha generado correctamente y se está descargando.',
                            confirmButtonColor: '#059669',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                    else if (response.type === 'json') {
                        const data = response.data;
                        
                        if (data.show_sweetalert || data.show_alert) {
                            Swal.fire({
                                icon: data.alert_type || 'warning',
                                title: data.alert_title || 'Atención',
                                text: data.message,
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: data.alert_type === 'error' ? '#dc2626' : '#f59e0b'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Ha ocurrido un error',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    }
                }
            }).catch((error) => {
                
                btnGenerar.disabled = false;
                btnText.textContent = 'Generar PDF';
                loadingSpinner.classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error al generar reporte',
                    text: 'Ocurrió un error al generar el PDF. Por favor, inténtalo de nuevo.',
                    confirmButtonColor: '#dc2626'
                });
            });
        });
    }
});
</script>