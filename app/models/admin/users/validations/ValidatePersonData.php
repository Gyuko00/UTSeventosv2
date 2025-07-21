<?php

/**
 * ValidatePersonData: modelo para validar los datos de una persona
 */
class ValidatePersonData {
    public function validate(array $personData): void {
        if (empty(trim($personData['tipo_documento'] ?? ''))) {
            throw new InvalidArgumentException('El tipo de documento es obligatorio.');
        }

        if (empty($personData['numero_documento']) || !preg_match('/^\d{8}$/', $personData['numero_documento'])) {
            throw new InvalidArgumentException('El número de documento es inválido o vacío.');
        }

        if (empty(trim($personData['nombres'] ?? '')) || empty(trim($personData['apellidos'] ?? ''))) {
            throw new InvalidArgumentException('Los nombres y apellidos son obligatorios.');
        }

        if (empty($personData['telefono']) || !preg_match('/^\d{8}$/', $personData['telefono'])) {
            throw new InvalidArgumentException('El teléfono es inválido o vacío.');
        }

        if (empty($personData['correo_personal']) || !filter_var($personData['correo_personal'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El correo electrónico es inválido o vacío.');
        }

        if (empty(trim($personData['departamento'] ?? '')) || empty(trim($personData['municipio'] ?? ''))) {
            throw new InvalidArgumentException('El departamento y municipio son obligatorios.');
        }

        if (empty(trim($personData['direccion'] ?? ''))) {
            throw new InvalidArgumentException('La dirección es obligatoria.');
        }
    }
}
