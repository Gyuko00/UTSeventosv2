<?php

/*
Controlador de Usuarios

Gestiona:
Visualización y edición del perfil
Listado de eventos disponibles
Inscripción a eventos
Listado de eventos inscritos
*/

require_once (__DIR__ . '/../models/UserModel.php');
require_once (__DIR__ . '/../../../core/View.php');

class UserController
{
    private $model;
    private $view;

    public function __construct(PDO $db)
    {
        $this->model = new UserModel($db);
        $this->view = new View();
    }

    // GET: /users/perfil
    public function perfil()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            header('Location: /auth/loginForm');
            exit;
        }

        $perfil = $this->model->obtenerPerfil($id_usuario);
        $this->view->render('users/perfil', ['perfil' => $perfil], 'user');
    }

    // POST: /users/editarPerfil
    public function editarPerfil()
    {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        $data = $_POST;
        $data['id_usuario'] = $_SESSION['id_usuario'];
        $perfil = $this->model->obtenerPerfil($data['id_usuario']);
        $data['id_persona'] = $perfil['id_persona'];

        $actualizado = $this->model->actualizarPerfil($data);
        echo json_encode(['status' => 'success', 'message' => 'Perfil actualizado correctamente.']);
    }

    // GET: /users/home
    public function home()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            header('Location: /auth/loginForm');
            exit;
        }

        $perfil = $this->model->obtenerPerfil($id_usuario);
        $eventos = $this->model->obtenerEventosDisponibles($perfil['id_persona']);

        $this->view->render('user/home', ['eventos' => $eventos], 'user');
    }

    // POST: /users/inscribirEvento
    public function inscribirEvento()
    {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            return;
        }

        $id_evento = $_POST['id_evento'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_evento || !$id_usuario) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
            return;
        }

        $perfil = $this->model->obtenerPerfil($id_usuario);
        $id_persona = $perfil['id_persona'];

        if ($this->model->yaInscrito($id_evento, $id_persona)) {
            echo json_encode(['status' => 'error', 'message' => 'Ya estás inscrito en este evento.']);
            return;
        }

        $cupos_actuales = $this->model->contarInscritos($id_evento);

        if ($cupos_actuales >= $_POST['cupo_maximo']) {
            echo json_encode(['status' => 'error', 'message' => 'El evento ya no tiene cupos disponibles.']);
            return;
        }

        $this->model->inscribirAEvento($id_persona, $id_evento);
        echo json_encode(['status' => 'success', 'message' => 'Inscripción exitosa.']);
    }

    // GET: /users/misEventos
    public function misEventos()
    {
        session_start();
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            header('Location: /auth/loginForm');
            exit;
        }

        $perfil = $this->model->obtenerPerfil($id_usuario);
        $eventos = $this->model->obtenerMisEventos($perfil['id_persona']);

        $this->view->render('user/mis_eventos', ['eventos' => $eventos], 'user');
    }
}
