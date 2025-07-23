<?php

/**
 * ValidateEventGuestData: valida la asignación de un invitado a un evento
 */
class ValidateEventGuestData {
    public function validate(array $data): void {
        if (!isset($data['id_persona']) || !is_numeric($data['id_persona']) || (int)$data['id_persona'] <= 0) {
            throw new InvalidArgumentException('El ID de la persona es obligatorio y válido.');
        }

        if (!isset($data['id_evento']) || !is_numeric($data['id_evento']) || (int)$data['id_evento'] <= 0) {
            throw new InvalidArgumentException('El ID del evento es obligatorio y válido.');
        }

        if (empty(trim($data['token'] ?? ''))) {
            throw new InvalidArgumentException('El token es obligatorio.');
        }

        if (empty(trim($data['tipo_invito'] ?? ''))) {
            throw new InvalidArgumentException('El tipo de invitado es obligatorio.');
        }

        if (empty(trim($data['correo_institucional'] ?? ''))) {
            throw new InvalidArgumentException('El correo institucional es obligatorio.');
        }

        if (empty(trim($data['programa_academico'] ?? ''))) {
            throw new InvalidArgumentException('El programa académico es obligatorio.');
        }

        if (empty(trim($data['nombre_carrera'] ?? ''))) {
            throw new InvalidArgumentException('El nombre de la carrera es obligatorio.');
        }

        if (empty(trim($data['jornada'] ?? ''))) {
            throw new InvalidArgumentException('La jornada es obligatoria.');
        }

        if (empty(trim($data['facultad'] ?? ''))) {
            throw new InvalidArgumentException('La facultad es obligatoria.');
        }

        if (empty(trim($data['cargo'] ?? ''))) {
            throw new InvalidArgumentException('El cargo es obligatorio.');
        }

        if (empty(trim($data['sede_institucion'] ?? ''))) {
            throw new InvalidArgumentException('La sede de la institución es obligatoria.');
        }

        if (!isset($data['estado_asistencia'])) {
            throw new InvalidArgumentException('El estado de asistencia es obligatorio.');
        }

        if (empty(trim($data['fecha_inscripcion'] ?? ''))) {
            throw new InvalidArgumentException('La fecha de inscripción es obligatoria.');
        }

        if (!isset($data['certificado_generado'])) {
            throw new InvalidArgumentException('El estado del certificado es obligatorio.');
        }
    }
}
