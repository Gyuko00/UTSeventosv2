<?php

require_once (__DIR__ . '/UsersProfileService.php');
require_once (__DIR__ . '/UsersInscripcionService.php');
require_once (__DIR__ . '/UsersEventService.php');

class UserService
{
    private $profileService;
    private $inscripcionService;
    private $eventoService;

    public function __construct(PDO $db)
    {
        $this->profileService = new UsersProfileService($db);
        $this->inscripcionService = new UsersInscripcionService($db);
        $this->eventoService = new UsersEventoService($db);
    }

    // 👤 Perfil
    public function perfil(): array
    {
        return $this->profileService->perfil();
    }

    public function editarPerfilForm(): void
    {
        $this->profileService->editarPerfilForm();
    }

    // 📋 Inscripciones
    public function home(): array
    {
        return $this->inscripcionService->home();
    }

    public function misEventos(): array
    {
        return $this->inscripcionService->misEventos();
    }

    public function inscribirEvento(): void
    {
        $this->inscripcionService->inscribirEvento();
    }

    public function cancelarInscripcion(): void
    {
        $this->inscripcionService->cancelarInscripcion();
    }

    // 📅 Evento
    public function evento(): array
    {
        return $this->eventoService->evento();
    }
}
