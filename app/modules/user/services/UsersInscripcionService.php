<?php

require_once (__DIR__ . '/BaseUserService.php');
require_once (__DIR__ . '/../../events/models/EventModel.php');

class UsersInscripcionService extends BaseUserService
{
    private $eventModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->eventModel = new EventModel($db);
    }

    public function home(): array
    {
        $ids = $this->obtenerIdPersona();
        $eventos = $this->eventModel->obtenerEventosConEstado($ids['id_persona']);
        return ['eventos' => $eventos];
    }

    public function misEventos(): array
    {
        $ids = $this->obtenerIdPersona();
        $eventos = $this->eventModel->obtenerMisEventos($ids['id_persona']);
        return ['eventos' => $eventos];
    }

    public function inscribirEvento(): void
    {
        $this->iniciarSesionSegura();
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
        $id_evento = $_POST['id_evento'] ?? null;
        if (!$id_evento) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
            return;
        }
        $ids = $this->obtenerIdPersona();
        $id_persona = $ids['id_persona'];
        if ($this->eventModel->yaInscrito($id_evento, $id_persona)) {
            echo json_encode(['status' => 'error', 'message' => 'Ya estás inscrito en este evento.']);
            return;
        }
        $cupos_actuales = $this->eventModel->contarInscritos($id_evento);
        $evento = $this->eventModel->obtenerEventoPorId($id_evento);
        if (!$evento || $cupos_actuales >= $evento['cupo_maximo']) {
            echo json_encode(['status' => 'error', 'message' => 'El evento ya no tiene cupos disponibles.']);
            return;
        }
        $this->eventModel->inscribirAEvento($id_persona, $id_evento);
        echo json_encode(['status' => 'success', 'message' => 'Inscripción exitosa.']);
    }

    public function cancelarInscripcion(): void
    {
        $this->iniciarSesionSegura();
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }
        $id_evento = $_POST['id_evento'] ?? null;
        if (!$id_evento) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
            return;
        }
        $ids = $this->obtenerIdPersona();
        $id_persona = $ids['id_persona'];
        $eventos = $this->eventModel->obtenerMisEventos($id_persona);
        foreach ($eventos as $evento) {
            if ($evento['id_evento'] == $id_evento) {
                $fechaEvento = strtotime($evento['fecha']);
                if ($fechaEvento < strtotime(date('Y-m-d'))) {
                    echo json_encode(['status' => 'error', 'message' => 'No puedes cancelar la inscripción a un evento ya finalizado.']);
                    return;
                }
                if ($evento['estado_asistencia'] === 'si') {
                    echo json_encode(['status' => 'error', 'message' => 'No puedes cancelar la inscripción a un evento al que ya asististe.']);
                    return;
                }
            }
        }
        $cancelado = $this->eventModel->cancelarInscripcion($id_persona, $id_evento);
        if ($cancelado) {
            echo json_encode(['status' => 'success', 'message' => 'Inscripción cancelada con éxito.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo cancelar la inscripción.']);
        }
    }
}
