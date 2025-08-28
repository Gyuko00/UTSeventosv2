<?php

class EventControlService extends Service {
    private EventControlModel $controlModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->controlModel = new EventControlModel($db);
    }

    public function getAllEvents(): array
    {
        return $this->controlModel->getAllEvents();
    }

    public function markByToken(string $token): array {
        $row = $this->controlModel->findByToken($token);
        if (!$row) {
            return [
                'status'  => 'error',
                'code'    => 'TOKEN_INVALID',
                'message' => 'Token inválido o expirado.'
            ];
        }

        if ((int)($row['estado_asistencia'] ?? 0) === 1) {
            return [
                'status'  => 'info',
                'code'    => 'ALREADY_MARKED',
                'message' => 'La asistencia ya estaba registrada.',
                'data'    => $row
            ];
        }

        $ok = $this->controlModel->markAttendanceAndInvalidate((int)$row['id_invitado_evento'], $token, true);
        if (!$ok) {
            return [
                'status'  => 'error',
                'code'    => 'UPDATE_FAILED',
                'message' => 'No fue posible registrar la asistencia.'
            ];
        }

        $row['estado_asistencia'] = 1;
        $row['token'] = null;

        return [
            'status'  => 'success',
            'code'    => 'MARKED_OK',
            'message' => 'Asistencia registrada correctamente.',
            'data'    => $row
        ];
    }

}