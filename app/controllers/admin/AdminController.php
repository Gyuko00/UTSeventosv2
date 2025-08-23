<?php

/**
 * AdminController: controlador para gestión de eventos desde el administrador.
 */

use \Dompdf\Dompdf;
use \Dompdf\Options;

class AdminController extends Controller
{
    private AdminUserController $userController;
    private AdminEventController $eventController;
    private AdminEventGuestController $eventGuestController;
    private AdminEventSpeakerController $eventSpeakerController;
    private AdminEventReportService $eventReportService;
    private AdminGlobalReportService $globalReportService;
    private AdminEventService $eventService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userController = new AdminUserController($db);
        $this->eventController = new AdminEventController($db);
        $this->eventGuestController = new AdminEventGuestController($db);
        $this->eventSpeakerController = new AdminEventSpeakerController($db);
        $this->eventReportService = new AdminEventReportService($db);
        $this->globalReportService = new AdminGlobalReportService($db);

        $this->eventService = new AdminEventService($db);
    }

    public function home()
    {
        $this->verificarAccesoConRoles([1]);

        $eventos = $this->eventService->getAllEvents(); 

        $this->view('admin/home', [
            'eventos' => $eventos['data'] ?? []
        ], 'admin');
    }

    public function cerrarSesion()
    {
        session_destroy();
        header('Location: ' . URL_PATH . '/auth/login');
        exit;
    }

    public function listarUsuarios()
    {
        $this->userController->listarUsuarios();
    }

    public function detalleUsuario(int $id)
    {
        $this->userController->detalleUsuario($id);
    }

    public function crearUsuario()
    {
        $this->userController->crearUsuario();
    }

    public function editarUsuario(int $id)
    {
        $this->userController->editarUsuario($id);
    }

    public function activarUsuario(int $id)
    {
        $this->userController->activarUsuario($id);
    }

    public function eliminarUsuario($id = null)
    {
        $this->userController->eliminarUsuario($id);
    }

    public function listarEventos()
    {
        $this->eventController->listarEventos();
    }

    public function detalleEvento(int $id)
    {
        $this->eventController->detalleEvento($id);
    }

    public function crearEvento()
    {
        $this->eventController->crearEvento();
    }

    public function getOccupiedSlots()
    {
        $this->eventController->getOccupiedSlots();
    }

    public function editarEvento(int $id)
    {
        $this->eventController->editarEvento($id);
    }

    public function eliminarEvento(int $id)
    {
        $this->eventController->eliminarEvento($id);
    }

    public function listarInvitados()
    {
        $this->eventGuestController->listarInvitados();
    }

    public function detalleInvitado(int $id)
    {
        $this->eventGuestController->detalleInvitado($id);
    }

    public function asignarInvitado()
    {
        $this->eventGuestController->asignarInvitado();
    }

    public function editarAsignacionInvitado(int $id)
    {
        $this->eventGuestController->editarAsignacionInvitado($id);
    }

    public function eliminarAsignacionInvitado(int $id)
    {
        $this->eventGuestController->eliminarAsignacionInvitado($id);
    }

    public function listarPonentes()
    {
        $this->eventSpeakerController->listarPonentes();
    }

    public function detallePonenteEvento(int $id)
    {
        $this->eventSpeakerController->detallePonenteEvento($id);
    }

    public function asignarPonente()
    {
        $this->eventSpeakerController->asignarPonente();
    }

    public function editarAsignacionPonente(int $id)
    {
        $this->eventSpeakerController->editarAsignacionPonente($id);
    }

    public function eliminarAsignacionPonente(int $id)
    {
        $this->eventSpeakerController->eliminarAsignacionPonente($id);
    }

    public function reporteEvento(int $idEvento)
    {
        $this->verificarAccesoConRoles([1]);
        $service = new AdminEventReportService($this->db);
        $service->generateEventReport($idEvento);
    }

    public function reporteGlobal()
    {
        $this->verificarAccesoConRoles([1]);
        $service = new AdminGlobalReportService($this->db);
        $service->generateGlobalReport();
    }

    public function report($eventoId = null)
    {
        try {
            if (!$eventoId || !is_numeric($eventoId)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'ID del evento no válido',
                    'show_sweetalert' => true,
                    'alert_type' => 'error'
                ]);
                return;
            }

            $invitadosResult = $this->eventService->getEventInvitees((int) $eventoId);
            $statsResult = $this->eventService->getEventInviteesStats((int) $eventoId);

            if ($invitadosResult['status'] !== 'success' || $statsResult['status'] !== 'success') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al obtener datos del evento',
                    'show_sweetalert' => true,
                    'alert_type' => 'error'
                ]);
                return;
            }

            $invitados = $invitadosResult['data'];
            $stats = $statsResult['data'];

            if (empty($invitados)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'No hay invitados registrados para este evento. No se puede generar el reporte.',
                    'show_sweetalert' => true,
                    'alert_type' => 'warning',
                    'alert_title' => '⚠️ Sin invitados'
                ]);
                return;
            }

            $evento = $invitados[0]['evento'];
            $fecha = $invitados[0]['fecha'];

            $this->generateAndDownloadPDF($evento, $fecha, $invitados, $stats);
        } catch (Exception $e) {
            error_log('Error en reporte PDF: ' . $e->getMessage());

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error interno del servidor',
                'show_sweetalert' => true,
                'alert_type' => 'error'
            ]);
        }
    }

    /**
     * Genera el HTML del reporte PDF
     */
    private function generateReportHTML(string $evento, string $fecha, array $invitados, array $stats): string
    {
        $totalInvitados = $stats['total_invitados'];
        $topCarrera = $stats['top_carrera'];
        $topPrograma = $stats['top_programa'];
        $topFacultad = $stats['top_facultad'];

        $html = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Reporte de Invitados</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                margin: 15px; 
                font-size: 11px; 
                line-height: 1.4;
            }
            .header { 
                background-color: #f8f9fa; 
                padding: 20px; 
                text-align: center; 
                border: 2px solid #dee2e6;
                margin-bottom: 20px;
            }
            h1 { 
                color: #2c3e50; 
                margin: 0; 
                font-size: 18px; 
            }
            h2 { 
                color: #34495e; 
                margin: 5px 0; 
                font-size: 14px; 
            }
            h3 { 
                color: #7f8c8d; 
                margin: 5px 0; 
                font-size: 12px; 
                font-weight: normal;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 15px;
                margin: 20px 0;
            }
            .stat-box {
                background: #ffffff;
                border: 1px solid #dee2e6;
                padding: 15px;
                text-align: center;
                border-radius: 5px;
            }
            .stat-number {
                font-size: 20px;
                font-weight: bold;
                color: #3498db;
                display: block;
            }
            .stat-label {
                color: #7f8c8d;
                font-size: 10px;
                margin-top: 5px;
            }
            .section {
                margin: 25px 0;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 14px;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 15px;
                border-bottom: 2px solid #3498db;
                padding-bottom: 5px;
            }
            .charts-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin: 20px 0;
            }
            .chart-box {
                border: 1px solid #dee2e6;
                padding: 15px;
                background: #ffffff;
            }
            .chart-title {
                font-weight: bold;
                margin-bottom: 10px;
                color: #2c3e50;
                text-align: center;
            }
            .chart-item {
                display: flex;
                justify-content: space-between;
                padding: 3px 0;
                border-bottom: 1px dotted #dee2e6;
            }
            .chart-item:last-child {
                border-bottom: none;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
                font-size: 9px;
            }
            th, td {
                border: 1px solid #dee2e6;
                padding: 6px 4px;
                text-align: left;
                vertical-align: top;
            }
            th {
                background-color: #f8f9fa;
                font-weight: bold;
                color: #2c3e50;
            }
            tr:nth-child(even) {
                background-color: #f8f9fa;
            }
            .page-break {
                page-break-before: always;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                color: #7f8c8d;
                font-size: 9px;
                border-top: 1px solid #dee2e6;
                padding-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>📊 Reporte de Invitados al Evento</h1>
            <h2>🎯 " . htmlspecialchars($evento) . '</h2>
            <h3>📅 Fecha del evento: ' . date('d/m/Y', strtotime($fecha)) . '</h3>
            <h3>📄 Generado el: ' . date('d/m/Y H:i:s') . "</h3>
        </div>

        <div class='section'>
            <div class='section-title'>📈 Resumen Ejecutivo</div>
            <div class='stats-grid'>
                <div class='stat-box'>
                    <span class='stat-number'>{$totalInvitados}</span>
                    <div class='stat-label'>Total de Invitados Registrados</div>
                </div>
                <div class='stat-box'>
                    <span class='stat-number'>" . $topCarrera['cantidad'] . "</span>
                    <div class='stat-label'>Mayor participación por carrera<br><strong>" . implode(', ', $topCarrera['nombres']) . "</strong></div>
                </div>
                <div class='stat-box'>
                    <span class='stat-number'>" . $topPrograma['cantidad'] . "</span>
                    <div class='stat-label'>Mayor participación por programa<br><strong>" . implode(', ', $topPrograma['nombres']) . "</strong></div>
                </div>
            </div>
        </div>

        <div class='section'>
            <div class='section-title'>📊 Análisis por Categorías</div>
            <div class='charts-grid'>";

        $html .= "<div class='chart-box'>
                <div class='chart-title'>👨‍🎓 Distribución por Carrera</div>";
        foreach ($stats['stats_carreras'] as $carrera => $cantidad) {
            $porcentaje = round(($cantidad / $totalInvitados) * 100, 1);
            $html .= "<div class='chart-item'>
                    <span>" . htmlspecialchars($carrera) . "</span>
                    <span><strong>{$cantidad}</strong> ({$porcentaje}%)</span>
                  </div>";
        }
        $html .= '</div>';

        $html .= "<div class='chart-box'>
                <div class='chart-title'>🎓 Distribución por Programa</div>";
        foreach ($stats['stats_programas'] as $programa => $cantidad) {
            $porcentaje = round(($cantidad / $totalInvitados) * 100, 1);
            $html .= "<div class='chart-item'>
                    <span>" . htmlspecialchars($programa) . "</span>
                    <span><strong>{$cantidad}</strong> ({$porcentaje}%)</span>
                  </div>";
        }
        $html .= '</div>';

        $html .= '</div></div>';

        $html .= "<div class='section'>
                <div class='charts-grid'>";

        $html .= "<div class='chart-box'>
                <div class='chart-title'>🏛️ Distribución por Facultad</div>";
        foreach ($stats['stats_facultades'] as $facultad => $cantidad) {
            $porcentaje = round(($cantidad / $totalInvitados) * 100, 1);
            $html .= "<div class='chart-item'>
                    <span>" . htmlspecialchars($facultad) . "</span>
                    <span><strong>{$cantidad}</strong> ({$porcentaje}%)</span>
                  </div>";
        }
        $html .= '</div>';

        $html .= "<div class='chart-box'>
                <div class='chart-title'>✅ Estado de Asistencia</div>";
        foreach ($stats['stats_asistencia'] as $estado => $cantidad) {
            $porcentaje = round(($cantidad / $totalInvitados) * 100, 1);
            $estadoTexto = [
                'asistio' => '✅ Asistió',
                'no_asistio' => '❌ No asistió',
                'pendiente' => '⏳ Pendiente'
            ][$estado] ?? $estado;
            $html .= "<div class='chart-item'>
                    <span>{$estadoTexto}</span>
                    <span><strong>{$cantidad}</strong> ({$porcentaje}%)</span>
                  </div>";
        }
        $html .= '</div>';

        $html .= '</div></div>';

        $html .= "<div class='section page-break'>
                <div class='section-title'>📋 Listado Detallado de Invitados</div>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Documento</th>
                            <th>Email Personal</th>
                            <th>Email Institucional</th>
                            <th>Teléfono</th>
                            <th>Carrera</th>
                            <th>Programa</th>
                            <th>Facultad</th>
                            <th>Jornada</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>";

        foreach ($invitados as $inv) {
            $nombreCompleto = trim(($inv['nombres'] ?? '') . ' ' . ($inv['apellidos'] ?? ''));
            $estadoAsistencia = [
                'asistio' => '✅',
                'no_asistio' => '❌',
                'pendiente' => '⏳'
            ][$inv['estado_asistencia'] ?? 'pendiente'] ?? '⏳';

            $html .= '<tr>
                    <td>' . htmlspecialchars($nombreCompleto ?: 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['documento'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['email'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['correo_institucional'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['telefono'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['carrera'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['programa_academico'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['facultad'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($inv['jornada'] ?? 'N/A') . "</td>
                    <td style='text-align: center;'>{$estadoAsistencia}</td>
                  </tr>";
        }

        $html .= "</tbody>
                </table>
              </div>

              <div class='footer'>
                  <p><strong>Sistema de Gestión de Eventos UTS</strong> | Reporte generado automáticamente</p>
                  <p>Total de registros: {$totalInvitados} | Fecha de generación: " . date('d/m/Y H:i:s') . '</p>
              </div>
            </body>
            </html>';

        return $html;
    }

    public function generateAndDownloadPDF(string $evento, string $fecha, array $invitados, array $stats): void
    {
        $html = $this->generateReportHTML($evento, $fecha, $invitados, $stats);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'Reporte_Invitados_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $evento) . '_' . date('Y-m-d') . '.pdf';

        $dompdf->stream($fileName, ['Attachment' => true]);
        exit;
    }

    private function sendJsonError(string $message): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        exit;
    }

    public function getPonentesAsignados()
    {
        return $this->speakerService->getPonentesAsignados();
    }
}
