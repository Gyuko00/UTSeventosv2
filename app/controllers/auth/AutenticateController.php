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
        // DEBUGGING: Generar hash de la contraseña actual
        $hash_from_db = '$2y$10$03S4X8r99Vl8Ot7dkybmee.p.2E64czeU2HIbBPENDDQnnNtrPpmK';
        $new_hash = password_hash($contrasenia, PASSWORD_DEFAULT);

        var_dump('Contraseña ingresada: ' . $contrasenia);
        var_dump('Hash desde DB: ' . $hash_from_db);
        var_dump('Nuevo hash generado: ' . $new_hash);
        var_dump('Verify result: ' . (password_verify($contrasenia, $hash_from_db) ? 'true' : 'false'));

        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'Credenciales inválidas'
        ]);
        return;
    }
}
