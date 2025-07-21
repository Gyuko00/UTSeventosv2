<?php

/**
 * ValidateUserData: modelo para validar los datos de un usuario
 */
class ValidateUserData {
    public function validate(array $userData): void {
        if (empty(trim($userData['usuario'] ?? ''))) {
            throw new InvalidArgumentException('El nombre de usuario es obligatorio.');
        }

        if (empty($userData['contrasenia']) || strlen($userData['contrasenia']) < 8) {
            throw new InvalidArgumentException('La contraseña es obligatoria y debe tener al menos 8 caracteres.');
        }

        if (!isset($userData['id_rol']) || !is_numeric($userData['id_rol']) || (int) $userData['id_rol'] <= 0) {
            throw new InvalidArgumentException('El ID del rol es obligatorio y válido.');
        }
    }
}
