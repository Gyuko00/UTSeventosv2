<?php

class GenerateHTMLReport extends Controller
{

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function generateHTMLReport(string $evento, string $fecha, array $invitados, array $stats): string
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
}
