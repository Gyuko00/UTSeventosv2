<?php

/**
 * ValidateEventData: modelo para validar los datos de un evento
 */
class ValidateEventData {
    public function validate(array $eventData): void {
        if (empty(trim($eventData['titulo_evento'] ?? ''))) {
            throw new InvalidArgumentException('El título del evento es obligatorio.');
        }

        if (empty($eventData['fecha']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventData['fecha'])) {
            throw new InvalidArgumentException('La fecha del evento es inválida o vacía.');
        }

        if (empty($eventData['hora_inicio']) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $eventData['hora_inicio'])) {
            throw new InvalidArgumentException('La hora de inicio es inválida o vacía.');
        }

        if (empty($eventData['hora_fin']) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $eventData['hora_fin'])) {
            throw new InvalidArgumentException('La hora de fin es inválida o vacía.');
        }

        if (!isset($eventData['cupo_maximo']) || !is_numeric($eventData['cupo_maximo']) || (int) $eventData['cupo_maximo'] <= 0) {
            throw new InvalidArgumentException('El cupo máximo debe ser un número positivo.');
        }

        if (!isset($eventData['id_usuario_creador']) || !is_numeric($eventData['id_usuario_creador']) || (int) $eventData['id_usuario_creador'] <= 0) {
            throw new InvalidArgumentException('El ID del usuario creador es obligatorio y válido.');
        }
    }
}
