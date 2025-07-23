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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['id_usuario'] = $userData['id_usuario'];
        $_SESSION['id_rol'] = $userData['id_rol'];
        $_SESSION['nombre'] = $userData['nombre'];
        
        error_log("Sesión iniciada: " . json_encode($_SESSION));
    }
    
    public function logout() {
        return $this->authModel->logout();
    }

}
