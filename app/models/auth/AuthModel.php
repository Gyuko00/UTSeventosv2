<?php

/**
 * AuthModel: modelo de autenticación para el sistema de gestión de eventos.
 */
class AuthModel extends Model
{
    private LoginUserModel $loginUserModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->loginUserModel = new LoginUserModel($db);
    }

    public function register(array $personData, array $userData): array
    {
        try {
            if ($this->loginUserModel->userExist($userData['usuario'])) {
                return [
                    'status' => 'error',
                    'code' => 'USER_EXISTS',
                    'message' => 'El nombre de usuario ya existe'
                ];
            }
    
            if ($this->loginUserModel->documentExist($personData['numero_documento'])) {
                return [
                    'status' => 'error',
                    'code' => 'DOCUMENT_EXISTS',
                    'message' => 'El documento ya está registrado'
                ];
            }
    
            $this->getDB()->beginTransaction();
    
            $personId = $this->loginUserModel->personRegister($personData);
    
            $userData['id_persona'] = $personId;
            $userData['id_rol'] = 3;
    
            $this->loginUserModel->userRegister($userData);
    
            $this->getDB()->commit();
    
            return [
                'status' => 'success',
                'message' => 'Usuario registrado exitosamente'
            ];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function login(string $usuario, string $contrasenia): array 
    {
        if (empty(trim($usuario)) || empty(trim($contrasenia))) {
            return [
                'status' => 'error',
                'code' => 'EMPTY_FIELDS',
                'message' => 'El usuario y la contraseña son obligatorios'
            ];
        }
    
        $sql = 'SELECT u.id_usuario, u.usuario, u.contrasenia, u.id_rol, u.activo, p.nombres, p.apellidos
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.usuario = :usuario';
        $stmt = $this->query($sql, [':usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            return [
                'status' => 'error',
                'code' => 'USER_NOT_FOUND',
                'message' => 'Usuario no encontrado'
            ];
        }
    
        if (!$user['activo']) {
            return [
                'status' => 'error',
                'code' => 'USER_INACTIVE',
                'message' => 'Tu cuenta ha sido desactivada. Contacta al administrador para más información.'
            ];
        }
    
        if (!password_verify($contrasenia, $user['contrasenia'])) {
            return [
                'status' => 'error',
                'code' => 'INVALID_PASSWORD',
                'message' => 'Contraseña inválida'
            ];
        }
    
        return [
            'status' => 'success',
            'id_usuario' => $user['id_usuario'],
            'id_rol' => $user['id_rol'],
            'nombre' => $user['nombres'] . ' ' . $user['apellidos'],
            'message' => 'Login exitoso'
        ];
    }

    public function logout(): array
    {
        session_start();
        session_unset();
        session_destroy();

        return [
            'status' => 'success',
            'message' => 'Sesión cerrada correctamente'
        ];
    }
}
