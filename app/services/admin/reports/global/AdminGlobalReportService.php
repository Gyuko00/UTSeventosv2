<?php

/**
 * AdminGlobalReportService: genera y descarga reportes PDF globales de invitados en todos los eventos.
 */

use Mpdf\Mpdf;

class AdminGlobalReportService extends Service
{
    private AdminEventGuestGettersModel $gettersModel;
    private AdminGlobalReportTemplate $template;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->gettersModel = new AdminEventGuestGettersModel($db);
        $this->template = new AdminGlobalReportTemplate();
    }

    public function generateGlobalReport(): void
    {
        $result = $this->gettersModel->getAllGuestStatistics();

        if ($result['status'] !== 'success') {
            die($result['message']);
        }

        $data = $result['data'];

        $estadisticas = $this->calcularEstadisticasGlobales($data);

        $html = $this->template->render($data, $estadisticas);

        $mpdf = new Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Reporte_Global_Invitados.pdf', 'D');
        exit;
    }

    private function calcularEstadisticasGlobales(array $data): array
    {
        $totalInvitados = count($data);
        $carreras = [];
        $facultades = [];
        $sedes = [];
        $estadoAsistencia = ['asistieron' => 0, 'no_asistieron' => 0];

        foreach ($data as $inv) {
            $carrera = $inv['nombre_carrera'] ?? 'No especificado';
            $facultad = $inv['facultad'] ?? 'No especificado';
            $sede = $inv['sede_institucion'] ?? 'No especificado';

            $carreras[$carrera] = ($carreras[$carrera] ?? 0) + 1;
            $facultades[$facultad] = ($facultades[$facultad] ?? 0) + 1;
            $sedes[$sede] = ($sedes[$sede] ?? 0) + 1;

            if ((int)$inv['estado_asistencia'] === 1) {
                $estadoAsistencia['asistieron']++;
            } else {
                $estadoAsistencia['no_asistieron']++;
            }
        }

        arsort($carreras);
        arsort($facultades);
        arsort($sedes);

        return [
            'total' => $totalInvitados,
            'carreras' => $carreras,
            'facultades' => $facultades,
            'sedes' => $sedes,
            'asistencia' => $estadoAsistencia
        ];
    }
}
