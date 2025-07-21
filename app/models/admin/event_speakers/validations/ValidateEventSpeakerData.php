<?php

/**
 * ValidateEventSpeakerData: valida la asignación de un ponente a un evento
 */
class ValidateEventSpeakerData {
    public function validate(array $data): void {
        if (!isset($data['id_ponente']) || !is_numeric($data['id_ponente']) || (int)$data['id_ponente'] <= 0) {
            throw new InvalidArgumentException('El ID del ponente es obligatorio y válido.');
        }

        if (!isset($data['id_evento']) || !is_numeric($data['id_evento']) || (int)$data['id_evento'] <= 0) {
            throw new InvalidArgumentException('El ID del evento es obligatorio y válido.');
        }

        if (empty(trim($data['hora_participacion'] ?? ''))) {
            throw new InvalidArgumentException('La hora de participación es obligatoria.');
        }

        if (!isset($data['estado_asistencia'])) {
            throw new InvalidArgumentException('El estado de asistencia es obligatorio.');
        }

        if (!isset($data['certificado_generado'])) {
            throw new InvalidArgumentException('El indicador de certificado es obligatorio.');
        }

        if (empty(trim($data['fecha_registro'] ?? ''))) {
            throw new InvalidArgumentException('La fecha de registro es obligatoria.');
        }
    }
}
