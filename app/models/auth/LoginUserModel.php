<?php

/**
 * LoginUserModel: modelo de usuario para el sistema de gestión de eventos.
 */

class LoginUserModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function userExist($usuario) {
        $sql = "SELECT id_usuario FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->query($sql, [':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function documentExist($numero_documento) {
        $sql = "SELECT id_persona FROM personas WHERE numero_documento = :numero_documento";
        $stmt = $this->query($sql, [':numero_documento' => $numero_documento]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function userRegister($userData) {
        $sql = 'INSERT INTO usuarios (usuario, contrasenia, id_rol, id_persona)
                VALUES (:usuario, :contrasenia, :id_rol, :id_persona)';
        $userData['contrasenia'] = password_hash($userData['contrasenia'], PASSWORD_DEFAULT);
        $this->query($sql, $userData);
    }

    public function personRegister(array $personData) {
        $sql = "INSERT INTO personas (tipo_documento, numero_documento, nombres, apellidos, telefono, correo_personal, 
                departamento, municipio, direccion)
                VALUES (:tipo_documento, :numero_documento, :nombres, :apellidos, :telefono, :correo_personal, 
                :departamento, :municipio, :direccion)";
        $stmt = $this->query($sql, $personData);
        return $this->getDB()->lastInsertId();
    }

}

