<?php 

/**
 * StoreController: controlador de almacenamiento de los registros de los usuarios.
 */

class StoreController extends Controller {

    private AuthService $authService;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->authService = new AuthService($db);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Method not allowed'
            ]);
            return;
        }
        header('Content-Type: application/json');
        
        $personData = [
            'tipo_documento' => $_POST['tipo_documento'] ?? null,
            'numero_documento' => $_POST['numero_documento'] ?? null,
            'nombres' => $_POST['nombres'] ?? null,
            'apellidos' => $_POST['apellidos'] ?? null,
            'telefono' => $_POST['telefono'] ?? null,
            'correo_personal' => $_POST['correo_personal'] ?? null,
            'departamento' => $_POST['departamento'] ?? null,
            'municipio' => $_POST['municipio'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
        ];

        $userData = [
            'usuario' => $_POST['usuario'] ?? null,
            'contrasenia' => $_POST['contrasenia'] ?? null,
        ];

        if (in_array(null, $personData) || in_array(null, $userData)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios'
            ]);
            return;
        }
        $register = $this->authService->register($personData, $userData);
        if ($register['status'] === 'success') {
            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'message' => 'Usuario creado exitosamente'
            ]);
            return;
        } else {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $register['message'] ?? 'Error al registrar el usuario.'
            ]);
            return;
        }
    } 

}