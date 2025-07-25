<?php

/** 
 * AdminUserGettersModel: Getters del crud de los usuarios desde el administrador
 */

class AdminUserGettersModel extends Model{
    
    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllUsers() {
        $sql = "SELECT u.id_usuario, u.usuario, u.activo, u.id_rol, 
                       p.id_persona, p.tipo_documento, p.numero_documento, 
                       p.nombres, p.apellidos, p.telefono, p.correo_personal,
                       p.departamento, p.municipio, p.direccion, 
                       r.nombre_rol
                FROM usuarios u
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario DESC";
        
        $stmt = $this->query($sql);
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
    public function getUserById(int $idUsuario): array
    {
        try {
            $sql = "SELECT u.id_usuario, u.usuario, u.activo, u.id_rol, 
                           p.id_persona, p.tipo_documento, p.numero_documento, 
                           p.nombres, p.apellidos, p.telefono, p.correo_personal,
                           p.departamento, p.municipio, p.direccion, 
                           r.nombre_rol
                    FROM usuarios u
                    INNER JOIN personas p ON u.id_persona = p.id_persona
                    INNER JOIN roles r ON u.id_rol = r.id_rol
                    WHERE u.id_usuario = :id_usuario";
            
            $stmt = $this->query($sql, ['id_usuario' => $idUsuario]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                return [
                    'status' => 'success',
                    'data' => $usuario
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Usuario no encontrado',
                    'data' => null
                ];
            }
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener usuario: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function getUserByUsername($username): array{
        try {
            $sql = "SELECT u.id_usuario, u.usuario, u.activo, u.id_rol, 
                           p.id_persona, p.tipo_documento, p.numero_documento, 
                           p.nombres, p.apellidos, p.telefono, p.correo_personal,
                           p.departamento, p.municipio, p.direccion, 
                           r.nombre_rol
                    FROM usuarios u
                    INNER JOIN personas p ON u.id_persona = p.id_persona
                    INNER JOIN roles r ON u.id_rol = r.id_rol
                    WHERE u.usuario = :username";
            
            $stmt = $this->query($sql, ['username' => $username]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                return [
                    'status' => 'success',
                    'data' => $usuario
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Usuario no encontrado',
                    'data' => null
                ];
            }
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener usuario: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

}