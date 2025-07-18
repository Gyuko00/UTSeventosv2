<?php

/** 
 * AuthService: servicio de autenticación para el sistema de gestión de eventos.
 */

class AuthService extends Service {

    private AuthModel $authModel;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->authModel = new AuthModel($db);
    }

    public function login($usuario, $contrasenia) {
        return $this->authModel->login($usuario, $contrasenia);
    }

    public function register(array $personData, array $userData) {
        return $this->authModel->register($personData, $userData);
    }

    public function startSession(array $userData) {
        session_start();
        $_SESSION['id_usuario'] = $userData['usuario'];
        $_SESSION['id_rol'] = $userData['rol'];
        $_SESSION['nombre'] = $userData['nombre'];
    }
    
    public function logout() {
        return $this->authModel->logout();
    }

}
