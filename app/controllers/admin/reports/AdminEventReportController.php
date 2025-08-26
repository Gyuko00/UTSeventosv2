<?php

class AdminEventReportController extends Controller {

    private GenerateHTMLReport $generateHTMLReport;
    private AdminEventService $eventService;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->generateHTMLReport = new GenerateHTMLReport($db);
        $this->eventService = new AdminEventService($db);
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

            $this->generateHTMLReport->generateAndDownloadPDF($evento, $fecha, $invitados, $stats);
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
}