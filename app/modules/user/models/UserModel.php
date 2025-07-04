<?php

/*
Modelo de gestión de usuarios

Este modelo permite que un usuario pueda actualizar su perfil, listar eventos disponibles y inscribirse a ellos después de validar su cupo.
También obtiene los eventos a los que el usuario ya se ha inscrito.
*/

require_once (__DIR__ . '/../../../core/Model.php');

class UserModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function obtenerPerfil($id_usuario)
    {
        $sql = 'SELECT u.id_usuario, u.usuario, u.id_rol,
                       p.id_persona, p.tipo_documento, p.numero_documento,
                       p.nombres, p.apellidos, p.telefono, p.correo_personal,
                       p.departamento, p.municipio, p.direccion
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.id_usuario = :id_usuario';

        $stmt = $this->query($sql, [':id_usuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($data)
    {
        $sqlPersona = 'UPDATE personas SET
                          tipo_documento = :tipo_documento,
                          numero_documento = :numero_documento,
                          nombres = :nombres,
                          apellidos = :apellidos,
                          telefono = :telefono,
                          correo_personal = :correo_personal,
                          departamento = :departamento,
                          municipio = :municipio,
                          direccion = :direccion
                      WHERE id_persona = :id_persona';
        $stmt1 = $this->query($sqlPersona, [
            ':tipo_documento' => $data['tipo_documento'],
            ':numero_documento' => $data['numero_documento'],
            ':nombres' => $data['nombres'],
            ':apellidos' => $data['apellidos'],
            ':telefono' => $data['telefono'],
            ':correo_personal' => $data['correo_personal'],
            ':departamento' => $data['departamento'],
            ':municipio' => $data['municipio'],
            ':direccion' => $data['direccion'],
            ':id_persona' => $data['id_persona']
        ]);

        if (!empty($data['usuario'])) {
            $sqlUsuario = 'UPDATE usuarios SET usuario = :usuario WHERE id_usuario = :id_usuario';
            $stmt2 = $this->query($sqlUsuario, [
                ':usuario' => $data['usuario'],
                ':id_usuario' => $data['id_usuario']
            ]);
        }

        return true;
    }

    public function obtenerHashContrasena($id_usuario)
    {
        $sql = 'SELECT contrasenia FROM usuarios WHERE id_usuario = :id_usuario';
        $stmt = $this->query($sql, [':id_usuario' => $id_usuario]);
        return $stmt->fetchColumn();
    }

    public function actualizarContrasena($id_usuario, $nuevaContrasena)
    {
        $hash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuarios SET contrasenia = :contrasenia WHERE id_usuario = :id_usuario';
        return $this->query($sql, [
            ':contrasenia' => $hash,
            ':id_usuario' => $id_usuario
        ]);
    }
}

?>