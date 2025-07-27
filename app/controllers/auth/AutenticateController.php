<?php

/**
 * AutenticateController: controlador de autenticación para el sistema de gestión de eventos.
 */
class AutenticateController extends Controller
{
    private AuthService $authService;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->authService = new AuthService($db);
    }

    public function autenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Method not allowed'
            ]);
            return;
        }
    
        $usuario = $_POST['usuario'] ?? null;
        $contrasenia = $_POST['contrasenia'] ?? null;
    
        if ($usuario === null || $contrasenia === null) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario y contraseña son obligatorios'
            ]);
            return;
        }
    
        $login = $this->authService->login($usuario, $contrasenia);
    
        if ($login['status'] === 'success') {
            $this->authService->startSession([
                'id_usuario' => $login['id_usuario'],
                'id_rol' => $login['id_rol'],
                'nombre' => $login['nombre']
            ]);
    
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Login exitoso',
                'id_rol' => $login['id_rol']
            ]);
            return;
        }
    
        $httpCode = 401; 
        
        switch ($login['code'] ?? '') {
            case 'EMPTY_FIELDS':
                $httpCode = 400; 
                break;
            case 'USER_NOT_FOUND':
                $httpCode = 401; 
                break;
            case 'USER_INACTIVE':
                $httpCode = 403; 
                break;
            case 'INVALID_PASSWORD':
                $httpCode = 401;
                break;
        }
    
        http_response_code($httpCode);
        echo json_encode([
            'status' => 'error',
            'message' => $login['message'],
            'code' => $login['code'] ?? 'UNKNOWN_ERROR'
        ]);
    }
}
