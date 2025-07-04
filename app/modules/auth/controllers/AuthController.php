
<?php

/*
Controlador de Autenticación (Login y Registro)

Este controlador gestiona las operaciones de autenticación del sistema,
incluyendo el registro de nuevos invitados y el login de usuarios.
Utiliza el modelo AuthModel y renderiza vistas mediante Render.
*/

require_once (__DIR__ . '/../models/AuthModel.php');
require_once (__DIR__ . '/../../../core/Render.php');

class AuthController
{
    private $model;
    private $render;

    public function __construct(PDO $db)
    {
        $this->model = new AuthModel($db);
        $this->render = new Render();
    }

    public function loginForm()
    {
        $this->render->render('auth/login', [], 'auth');
    }

    public function registerForm()
    {
        $this->render->render('auth/register', [], 'auth');
    }

    public function accesoDenegado()
    {
        $this->render->render('auth/acceso_denegado', [], 'auth');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        header('Content-Type: application/json');

        // Validar y sanitizar entrada
        $persona = [
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

        $usuario = [
            'usuario' => $_POST['usuario'] ?? null,
            'contrasenia' => $_POST['contrasenia'] ?? null
        ];

        // Validaciones básicas (podrías extender con regex, longitudes, etc.)
        if (in_array(null, $persona, true) || in_array(null, $usuario, true)) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
            return;
        }

        // Registrar usuario
        $response = $this->model->registrar($persona, $usuario);
        echo json_encode($response);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        $usuario = $_POST['usuario'] ?? null;
        $contrasenia = $_POST['contrasenia'] ?? null;

        if (!$usuario || !$contrasenia) {
            echo json_encode(['status' => 'error', 'message' => 'Credenciales incompletas.']);
            return;
        }

        $result = $this->model->login($usuario, $contrasenia);

        if ($result['status'] === 'success') {
            // Establecer sesión
            session_start();
            $_SESSION['id_usuario'] = $result['usuario'];
            $_SESSION['nombre'] = $result['nombre_completo'];
            $_SESSION['rol'] = $result['rol'];

            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso.', 'rol' => $result['rol']]);
        } else {
            echo json_encode($result);
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . URL_PATH . '/auth/loginForm');
        exit;
    }
}
