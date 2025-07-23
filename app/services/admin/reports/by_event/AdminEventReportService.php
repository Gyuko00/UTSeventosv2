<?php

/**
 * AdminEventReportService: servicio para generar reportes PDF de invitados por evento
 */

use Mpdf\Mpdf;

class AdminEventReportService extends Service
{
    private AdminEventGuestGettersModel $gettersModel;
    private AdminEventReportTemplate $template;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->gettersModel = new AdminEventGuestGettersModel($db);
        $this->template = new AdminEventReportTemplate();
    }

    public function generateEventReport(int $idEvento): void
    {
        $resultado = $this->gettersModel->getGuestsByEventId($idEvento);

        if ($resultado['status'] !== 'success') {
            die('Error: ' . $resultado['message']);
        }

        $data = $resultado['data'];
        $html = $this->template->buildHtml($data);

        $mpdf = new Mpdf(['format' => 'A4-L']);
        $mpdf->WriteHTML($html);
        $evento = $data[0]['titulo_evento'] ?? 'Evento';
        $mpdf->Output("Reporte_Invitados_{$evento}.pdf", \Mpdf\Output\Destination::DOWNLOAD);
        exit;
    }
}
