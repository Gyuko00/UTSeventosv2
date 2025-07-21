<?php

/**
 * ValidateAdminGuestData: valida los datos de un invitado
 */
class ValidateAdminGuestData {
    public function validate(array $data): void {
        if (!isset($data['id_persona']) || !is_numeric($data['id_persona']) || (int)$data['id_persona'] <= 0) {
            throw new InvalidArgumentException('El ID de la persona es obligatorio y válido.');
        }

        if (empty(trim($data['tipo_invitado'] ?? ''))) {
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
    }
}
