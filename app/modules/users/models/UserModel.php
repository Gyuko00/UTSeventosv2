<!--
Modelo de gestión de usuarios del sistema

Este modelo permite consultar, registrar, editar, activar/desactivar y
listar usuarios del sistema. Incluye operaciones conjuntas con la tabla 
personas y roles, siguiendo relaciones foráneas.
-->
<?php

require_once(__DIR__ . '/../../../core/Model.php');

class UserModel extends Model
{
    // Obtener todos los usuarios con su información personal y rol
    public function getAll()
    {
        $sql = "SELECT u.id_usuario, u.usuario, u.id_rol, r.nombre_rol,
                       p.id_persona, p.tipo_documento, p.numero_documento, p.nombres, 
                       p.apellidos, p.telefono, p.correo_personal, p.departamento, 
                       p.municipio, p.direccion
                FROM usuarios u
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol";
        return $this->fetchAll($sql);
    }

    // Obtener un usuario por ID
    public function getById(int $id_usuario)
    {
        $sql = "SELECT u.*, p.*, r.nombre_rol
                FROM usuarios u
                INNER JOIN personas p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = :id";
        return $this->fetch($sql, ['id' => $id_usuario]);
    }

    // Crear una persona asociada al usuario
    public function createPersona(array $data): int
    {
        $sql = "INSERT INTO personas (tipo_documento, numero_documento, nombres, apellidos, telefono, correo_personal, departamento, municipio, direccion)
                VALUES (:tipo_documento, :numero_documento, :nombres, :apellidos, :telefono, :correo_personal, :departamento, :municipio, :direccion)";
        return $this->insert($sql, $data);
    }

    // Crear el usuario
    public function createUsuario(array $data): int
    {
        $sql = "INSERT INTO usuarios (usuario, contrasenia, id_rol, id_persona)
                VALUES (:usuario, :contrasenia, :id_rol, :id_persona)";
        return $this->insert($sql, $data);
    }

    // Actualizar información de persona
    public function updatePersona(int $id_persona, array $data): bool
    {
        $sql = "UPDATE personas SET tipo_documento = :tipo_documento, numero_documento = :numero_documento, 
                nombres = :nombres, apellidos = :apellidos, telefono = :telefono, correo_personal = :correo_personal, 
                departamento = :departamento, municipio = :municipio, direccion = :direccion
                WHERE id_persona = :id_persona";

        $data['id_persona'] = $id_persona;
        return $this->execute($sql, $data);
    }

    // Actualizar información del usuario
    public function updateUsuario(int $id_usuario, array $data): bool
    {
        $sql = "UPDATE usuarios SET usuario = :usuario, id_rol = :id_rol
                WHERE id_usuario = :id_usuario";

        $data['id_usuario'] = $id_usuario;
        return $this->execute($sql, $data);
    }

    // Cambiar contraseña del usuario
    public function changePassword(int $id_usuario, string $hashedPassword): bool
    {
        $sql = "UPDATE usuarios SET contrasenia = :contrasenia WHERE id_usuario = :id_usuario";
        return $this->execute($sql, [
            'contrasenia' => $hashedPassword,
            'id_usuario' => $id_usuario
        ]);
    }

    // Eliminar usuario y su persona relacionada (opcional: validación de integridad referencial)
    public function delete(int $id_usuario, int $id_persona): bool
    {
        $this->execute("DELETE FROM usuarios WHERE id_usuario = :id", ['id' => $id_usuario]);
        return $this->execute("DELETE FROM personas WHERE id_persona = :id", ['id' => $id_persona]);
    }

    // Verificar existencia por nombre de usuario (para validación de unicidad)
    public function existsByUsername(string $usuario): bool
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
        $result = $this->fetchColumn($sql, ['usuario' => $usuario]);
        return $result > 0;
    }

    // Obtener todos los roles disponibles
    public function getRoles(): array
    {
        return $this->fetchAll("SELECT * FROM roles");
    }
}
