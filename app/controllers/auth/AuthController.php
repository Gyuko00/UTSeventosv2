<?php

/** 
 * AuthController: controlador de autenticación para el sistema de gestión de eventos.
 */
class AuthController extends Controller {

    private AuthService $authService;
    private StoreController $storeController;
    private AutenticateController $autenticateController;
    
    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->authService = new AuthService($db);
        $this->storeController = new StoreController($db);
        $this->autenticateController = new AutenticateController($db);
    }

    public function login() {
        $data = [];
        $this->view('auth/login', $data, 'auth');
    }

    public function register() {
        $data = [];
        $this->view('auth/register', $data, 'auth');
    }

    public function store() {
        $this->storeController->store();
    }

    public function autenticate() {
        $this->autenticateController->autenticate();
    }

    public function notFound() {
        $data = [];
        $this->view('auth/404', $data, 'blank');
    }

    public function logout() {
        $this->authService->logout();
        $this->redirect('auth/login');
    }

}
