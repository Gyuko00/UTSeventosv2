<?php

/** 
 * AuthModel: modelo de autenticación para el sistema de gestión de eventos. 
 */

class AuthModel extends Model {

    private LoginUserModel $loginUserModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->loginUserModel = new LoginUserModel($db);
    }

    public function register(array $personData, array $userData) {
        try {
            if ($this->loginUserModel->userExist($userData['usuario'])) {
                return [
                    'status' => 'error',
                    'message' => 'Usuario ya existe'
                ];
            }
            if ($this->loginUserModel->documentExist($personData['numero_documento'])) {
                return [
                    'status' => 'error',
                    'message' => 'Documento ya existe'
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

    public function login($usuario, $contrasenia) {
        $sql = "SELECT u.id_usuario, u.contrasenia, u.id_rol, p.nombres, p.apellidos
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.usuario = :usuario";
        $stmt = $this->query($sql, [':usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($contrasenia, $user['contrasenia'])) {
            return [
                'status' => 'success',
                'usuario' => $user['id_usuario'],
                'rol' => $user['id_rol'],
                'nombre' => $user['nombres'] . ' ' . $user['apellidos'],
                'message' => 'Login exitoso'
            ];
        }
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ];
        }
        return [
            'status' => 'error',
            'message' => 'Contraseña incorrecta'
        ];
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

}




