<?php

require_once (__DIR__ . '/../models/UserModel.php');
require_once (__DIR__ . '/BaseUserService.php');

class UsersProfileService extends BaseUserService
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function perfil(): array
    {
        $ids = $this->obtenerIdPersona();
        $perfil = $this->userModel->obtenerPerfil($ids['id_usuario']);
        return ['perfil' => $perfil];
    }

    public function editarPerfilForm(): void
    {
        header('Content-Type: application/json');
        $ids = $this->obtenerIdPersona();
        $id_usuario = $ids['id_usuario'];
        if (!$id_usuario) {
            echo json_encode(['status' => 'error', 'message' => 'No autenticado.']);
            return;
        }
        $data = $_POST;
        $data['id_usuario'] = $id_usuario;
        $data['id_persona'] = $ids['id_persona'];
        if (!empty($data['contrasenia_actual']) || !empty($data['nueva_contrasenia'])) {
            if (empty($data['contrasenia_actual']) || empty($data['nueva_contrasenia'])) {
                echo json_encode(['status' => 'error', 'message' => 'Debe completar ambos campos de contraseña.']);
                return;
            }
            $hashActual = $this->userModel->obtenerHashContrasena($id_usuario);
            if (!password_verify($data['contrasenia_actual'], $hashActual)) {
                echo json_encode(['status' => 'error', 'message' => 'La contraseña actual no coincide.']);
                return;
            }
            $this->userModel->actualizarContrasena($id_usuario, $data['nueva_contrasenia']);
        }
        $this->userModel->actualizarPerfil($data);
        echo json_encode(['status' => 'success', 'message' => 'Perfil actualizado correctamente.']);
    }
}
