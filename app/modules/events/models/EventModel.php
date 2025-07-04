<?php

require_once(__DIR__ . '/EventCrudModel.php');
require_once(__DIR__ . '/EventSpeakerModel.php');
require_once(__DIR__ . '/EventInscriptionModel.php');
require_once(__DIR__ . '/EventConsultModel.php');

class EventModel
{
    private EventCrudModel $crudModel;
    private EventSpeakerModel $speakerModel;
    private EventInscriptionModel $inscriptionModel;
    private EventConsultModel $consultModel;

    public function __construct(PDO $db)
    {
        $this->crudModel = new EventCrudModel($db);
        $this->speakerModel = new EventSpeakerModel($db);
        $this->inscriptionModel = new EventInscriptionModel($db);
        $this->consultModel = new EventConsultModel($db);
    }

    public function listarEventos(): array
    {
        return $this->crudModel->listarEventos();
    }

    public function crearEvento(array $data): int
    {
        return $this->crudModel->crearEvento($data);
    }

    public function editarEvento(int $id_evento, array $data): int
    {
        return $this->crudModel->editarEvento($id_evento, $data);
    }

    public function eliminarEvento(int $id_evento): int
    {
        return $this->crudModel->eliminarEvento($id_evento);
    }

    public function obtenerEventoPorId(int $id_evento): ?array
    {
        return $this->crudModel->obtenerEventoPorId($id_evento);
    }

    public function agregarPonenteAEvento(int $id_evento, int $id_ponente, string $hora_participacion): bool
    {
        return $this->speakerModel->agregarPonenteAEvento($id_evento, $id_ponente, $hora_participacion);
    }

    public function eliminarPonenteDeEvento(int $id_evento, int $id_ponente): bool
    {
        return $this->speakerModel->eliminarPonenteDeEvento($id_evento, $id_ponente);
    }

    public function obtenerPonentesPorEvento(int $id_evento): array
    {
        return $this->speakerModel->obtenerPonentesPorEvento($id_evento);
    }

    public function obtenerEventoConPonentes(int $id_evento): ?array
    {
        return $this->speakerModel->obtenerEventoConPonentes($id_evento);
    }

    public function inscribirAEvento(int $id_persona, int $id_evento, string $tipo_invitado = 'invitado'): bool
    {
        return $this->inscriptionModel->inscribirAEvento($id_persona, $id_evento, $tipo_invitado);
    }

    public function cancelarInscripcion(int $id_persona, int $id_evento): bool
    {
        return $this->inscriptionModel->cancelarInscripcion($id_persona, $id_evento);
    }

    public function yaInscrito(int $id_evento, int $id_persona): bool
    {
        return $this->inscriptionModel->yaInscrito($id_evento, $id_persona);
    }

    public function contarInscritos(int $id_evento): int
    {
        return $this->inscriptionModel->contarInscritos($id_evento);
    }

    public function obtenerMisEventos(int $id_persona): array
    {
        return $this->consultModel->obtenerMisEventos($id_persona);
    }

    public function obtenerEventosDisponibles(int $id_persona): array
    {
        return $this->consultModel->obtenerEventosDisponibles($id_persona);
    }

    public function obtenerEventosConEstado(int $id_persona): array
    {
        return $this->consultModel->obtenerEventosConEstado($id_persona);
    }
}
