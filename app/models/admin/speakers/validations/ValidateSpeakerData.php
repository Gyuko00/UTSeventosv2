<?php

/**
 * ValidateSpeakerData: modelo para validar los datos de un ponente
 */
class ValidateSpeakerData {
    public function validate(array $speakerData): void {
        if (!isset($speakerData['id_persona']) || !is_numeric($speakerData['id_persona']) || (int)$speakerData['id_persona'] <= 0) {
            throw new InvalidArgumentException('El ID de la persona es obligatorio y válido.');
        }

        if (empty(trim($speakerData['tema'] ?? ''))) {
            throw new InvalidArgumentException('El tema es obligatorio.');
        }

        if (empty(trim($speakerData['descripcion_biografica'] ?? ''))) {
            throw new InvalidArgumentException('La descripción biográfica es obligatoria.');
        }

        if (empty(trim($speakerData['especializacion'] ?? ''))) {
            throw new InvalidArgumentException('La especialización es obligatoria.');
        }

        if (empty(trim($speakerData['institucion_ponente'] ?? ''))) {
            throw new InvalidArgumentException('La institución del ponente es obligatoria.');
        }
    }
}
