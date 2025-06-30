<!--
Modelo de autenticación para el sistema de eventos

Este modelo maneja el registro y login de usuarios, validando la unicidad
de documento y nombre de usuario. Se asegura de registrar a la persona y
el usuario con rol de invitado (id_rol = 3), encriptando la contraseña.
-->

<?php

class AuthModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function existeDocumento($numeroDocumento)
    {
        $sql = 'SELECT id_persona FROM personas WHERE numero_documento = :numero_documento';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':numero_documento', $numeroDocumento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function existeUsuario($usuario)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE usuario = :usuario';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function registrar(array $personaData, array $usuarioData)
    {
        try {
            $this->db->beginTransaction();

            // Verifica duplicados
            if ($this->existeDocumento($personaData['numero_documento'])) {
                throw new Exception('El número de documento ya está registrado.');
            }

            if ($this->existeUsuario($usuarioData['usuario'])) {
                throw new Exception('El nombre de usuario ya está en uso.');
            }

            // Insertar en personas
            $sqlPersona = 'INSERT INTO personas (tipo_documento, numero_documento, nombres, apellidos, telefono, correo_personal, departamento, municipio, direccion)
                           VALUES (:tipo_documento, :numero_documento, :nombres, :apellidos, :telefono, :correo_personal, :departamento, :municipio, :direccion)';
            $this->query($sqlPersona, $personaData);
            $id_persona = $this->db->lastInsertId();

            // Insertar en usuarios con rol invitado
            $sqlUsuario = 'INSERT INTO usuarios (usuario, contrasenia, id_rol, id_persona)
                           VALUES (:usuario, :contrasenia, :id_rol, :id_persona)';
            $usuarioData['contrasenia'] = password_hash($usuarioData['contrasenia'], PASSWORD_DEFAULT);
            $usuarioData['id_persona'] = $id_persona;
            $usuarioData['id_rol'] = 3;

            $this->query($sqlUsuario, $usuarioData);

            $this->db->commit();
            return ['status' => 'success', 'message' => 'Registro exitoso.'];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function login($usuario, $contrasenia)
    {
        $sql = 'SELECT u.id_usuario, u.contrasenia, u.id_rol, p.nombres, p.apellidos
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.usuario = :usuario';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($contrasenia, $usuarioEncontrado['contrasenia'])) {
            return [
                'status' => 'success',
                'usuario' => $usuarioEncontrado['id_usuario'],
                'nombre_completo' => $usuarioEncontrado['nombres'] . ' ' . $usuarioEncontrado['apellidos'],
                'rol' => $usuarioEncontrado['id_rol']
            ];
        } else {
            return ['status' => 'error', 'message' => 'Credenciales incorrectas.'];
        }
    }
}
