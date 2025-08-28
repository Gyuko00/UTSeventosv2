<?php
// app/services/guest/EventGuestService.php
class EventGuestService extends Service
{
    private EventGuestModel $guestModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->guestModel = new EventGuestModel($this->db);
    }

    public function getAllEvents(): array
    {
        return $this->guestModel->getAllEvents();
    }

    public function getEventsWithFlagForUser(int $idUsuario): array
    {
        $idInvitado = $this->guestModel->getIdInvitadoByUsuario($idUsuario);
        if (!$idInvitado)
            return [];
        return $this->guestModel->getAllEventsWithRegisteredFlag($idInvitado);
    }

    public function registerToEvent(int $idUsuario, int $idEvento): array
    {
        $idInvitado = $this->guestModel->getIdInvitadoByUsuario($idUsuario);
        if (!$idInvitado)
            return ['status' => 'error', 'message' => 'No se encontró un invitado asociado a tu usuario.'];

        if (!$this->guestModel->eventExists($idEvento))
            return ['status' => 'error', 'message' => 'El evento no existe.'];

        if ($this->guestModel->isAlreadyRegistered($idInvitado, $idEvento))
            return ['status' => 'error', 'message' => 'Ya estás inscrito en este evento.'];

        if (!$this->guestModel->hasCapacity($idEvento))
            return ['status' => 'error', 'message' => 'El evento no tiene cupos disponibles.'];

        $token = bin2hex(random_bytes(16));
        $res = $this->guestModel->createRegistration($idInvitado, $idEvento, $token);

        if ($res['status'] === 'success') {
            return ['status' => 'success', 'message' => 'Inscripción realizada con éxito.'];
        }
        return ['status' => 'error', 'message' => 'No se pudo realizar la inscripción.', 'debug_db' => $res['db_error'] ?? null];
    }

    public function verificarInscripcionUsuario(int $id_evento, int $id_usuario): array
    {
        try {
            $resultado = $this->guestModel->verificarInscripcion($id_evento, $id_usuario);

            return [
                'status' => 'success',
                'data' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al verificar inscripción',
                'data' => [
                    'inscrito' => false,
                    'datos_inscripcion' => null
                ]
            ];
        }
    }

    public function cancelarInscripcionUsuario(int $id_evento, int $id_usuario): array
    {
        try {
            // Primero verificar que esté inscrito
            $verificacion = $this->verificarInscripcionUsuario($id_evento, $id_usuario);

            if ($verificacion['status'] !== 'success' || !$verificacion['data']['inscrito']) {
                return [
                    'status' => 'error',
                    'message' => 'No estás inscrito en este evento'
                ];
            }

            // Proceder a cancelar
            $resultado = $this->guestModel->cancelarInscripcion($id_evento, $id_usuario);

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Inscripción cancelada exitosamente'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No se pudo cancelar la inscripción'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al cancelar inscripción: ' . $e->getMessage()
            ];
        }
    }

    public function getEventById(int $id): array
    {
        return $this->guestModel->getEventById($id);
    }
}
