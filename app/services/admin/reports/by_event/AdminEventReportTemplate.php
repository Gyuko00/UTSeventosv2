<?php

/**
 * AdminEventReportTemplate: genera la plantilla HTML para el reporte PDF de invitados por evento
 */

class AdminEventReportTemplate
{
    public function buildHtml(array $data): string
    {
        $evento = $data[0]['titulo_evento'];
        $tema = $data[0]['tema'];
        $fecha = $data[0]['fecha'];
        $horaInicio = $data[0]['hora_inicio'];
        $institucion = $data[0]['institucion_evento'];

        $total = count($data);
        $asistieron = count(array_filter($data, fn($row) => $row['estado_asistencia'] == 1));
        $noAsistieron = $total - $asistieron;

        $categorias = [
            'tipo_invitado' => [],
            'nombre_carrera' => [],
            'jornada' => [],
            'facultad' => [],
            'sede_institucion' => [],
            'programa_academico' => [],
            'cargo' => [],
            'fecha_inscripcion' => [],
        ];

        foreach ($data as $row) {
            foreach ($categorias as $campo => &$conteo) {
                $valor = $row[$campo] ?: 'No especificado';
                $conteo[$valor] = ($conteo[$valor] ?? 0) + 1;
            }
        }

        $buildList = fn(array $conteo): string => implode('', array_map(
            fn($label, $count) => "<li>{$label}: {$count}</li>",
            array_keys($conteo),
            $conteo
        ));

        $buildTable = fn(array $data): string => implode('', array_map(
            function ($i, $row) {
                return "<tr>
                    <td>" . ($i + 1) . "</td>
                    <td>{$row['id_persona']}</td>
                    <td>{$row['tipo_invitado']}</td>
                    <td>{$row['nombre_carrera']}</td>
                    <td>{$row['programa_academico']}</td>
                    <td>{$row['jornada']}</td>
                    <td>{$row['facultad']}</td>
                    <td>{$row['sede_institucion']}</td>
                    <td>{$row['cargo']}</td>
                    <td>{$row['correo_institucional']}</td>
                    <td>" . ($row['estado_asistencia'] == 1 ? 'Sí' : 'No') . "</td>
                    <td>{$row['fecha_inscripcion']}</td>
                </tr>";
            },
            array_keys($data),
            $data
        ));

        return "
        <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section-title { font-weight: bold; margin-top: 15px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: left; }
        th { background: #eee; }
        .stat-block { display: inline-block; margin-right: 20px; vertical-align: top; }
        </style>

        <div class='header'>
            <h2>Reporte de Invitados al Evento</h2>
            <h3>{$evento}</h3>
            <p>Tema: {$tema} | Fecha: {$fecha} | Hora inicio: {$horaInicio} | Institución: {$institucion}</p>
        </div>

        <div class='section-title'>Totales Generales</div>
        <p>
            Total invitados: <strong>{$total}</strong> |
            Asistieron: <strong>{$asistieron}</strong> |
            No asistieron: <strong>{$noAsistieron}</strong>
        </p>

        <div class='section-title'>Estadísticas por Categorías</div>

        <div class='stat-block'>
            <strong>Por tipo de invitado</strong>
            <ul>{$buildList($categorias['tipo_invitado'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por carrera</strong>
            <ul>{$buildList($categorias['nombre_carrera'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por jornada</strong>
            <ul>{$buildList($categorias['jornada'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por facultad</strong>
            <ul>{$buildList($categorias['facultad'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por sede institucional</strong>
            <ul>{$buildList($categorias['sede_institucion'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por programa académico</strong>
            <ul>{$buildList($categorias['programa_academico'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por cargo</strong>
            <ul>{$buildList($categorias['cargo'])}</ul>
        </div>

        <div class='stat-block'>
            <strong>Por fecha de inscripción</strong>
            <ul>{$buildList($categorias['fecha_inscripcion'])}</ul>
        </div>

        <div style='clear:both;'></div>

        <div class='section-title'>Listado Detallado de Invitados</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Persona ID</th>
                    <th>Tipo</th>
                    <th>Carrera</th>
                    <th>Programa</th>
                    <th>Jornada</th>
                    <th>Facultad</th>
                    <th>Sede</th>
                    <th>Cargo</th>
                    <th>Correo</th>
                    <th>Asistencia</th>
                    <th>Fecha inscripción</th>
                </tr>
            </thead>
            <tbody>
                {$buildTable($data)}
            </tbody>
        </table>";
    }
}
