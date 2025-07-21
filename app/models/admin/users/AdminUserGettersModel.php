<?php

/** 
 * AdminUserGettersModel: Getters del crud de los usuarios desde el administrador
 */

class AdminUserGettersModel extends Model{
    
    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllUsers() {
        $sql = "SELECT u.id_usuario, u.usuario, u.id_rol, p.id_persona, p.tipo_documento,
                p.numero_documento, p.nombres, p.apellidos, p.telefono, p.correo_personal,
                p.departamento, p.municipio, p.direccion, r.nombre_rol
                FROM usuarios u
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol";
        $stmt = $this->query($sql);
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getUserById(int $id) {
        $this->validateId($id);
        $sql = "SELECT u.id_usuario, u.usuario, u.id_rol, p.id_persona, p.tipo_documento,
                p.numero_documento, p.nombres, p.apellidos, p.telefono, p.correo_personal,
                p.departamento, p.municipio, p.direccion, r.nombre_rol
                FROM usuarios u
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['status' => 'error', 'message' => 'Usuario no encontrado'];
        }

        return ['status' => 'success', 'data' => $user];
    }

}