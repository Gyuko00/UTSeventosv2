<?php
// app/services/guest/EventGuestService.php
class EventGuestService extends Service
{
    private EventGuestModel $guestModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->guestModel = new EventGuestModel($this->db);
    }

    public function getEventsWithFlagForUser(int $idUsuario): array
    {
        $idInvitado = $this->guestModel->getIdInvitadoByUsuario($idUsuario);
        if (!$idInvitado) return [];
        return $this->guestModel->getAllEventsWithRegisteredFlag($idInvitado);
    }

    public function registerToEvent(int $idUsuario, int $idEvento): array
    {
        $idInvitado = $this->guestModel->getIdInvitadoByUsuario($idUsuario);
        if (!$idInvitado) return ['status'=>'error','message'=>'No se encontró un invitado asociado a tu usuario.'];
    
        if (!$this->guestModel->eventExists($idEvento))
            return ['status'=>'error','message'=>'El evento no existe.'];
    
        if ($this->guestModel->isAlreadyRegistered($idInvitado, $idEvento))
            return ['status'=>'error','message'=>'Ya estás inscrito en este evento.'];
    
        if (!$this->guestModel->hasCapacity($idEvento))
            return ['status'=>'error','message'=>'El evento no tiene cupos disponibles.'];
    
        $token = bin2hex(random_bytes(16));
        $res = $this->guestModel->createRegistration($idInvitado, $idEvento, $token);
    
        if ($res['status']==='success') {
            return ['status'=>'success','message'=>'Inscripción realizada con éxito.'];
        }
        return ['status'=>'error','message'=>'No se pudo realizar la inscripción.','debug_db'=>$res['db_error'] ?? null];
    }    
}
