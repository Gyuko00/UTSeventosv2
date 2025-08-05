<?php

/**
 * AdminGuestCRUDModel: CRUD para la tabla invitados
 */
class AdminGuestCRUDModel extends Model
{
    protected GuestCreateCRUDModel $guestCreateCRUDModel;
    protected GuestUpdateCRUDModel $guestUpdateCRUDModel;
    protected GuestDeleteCRUDModel $guestDeleteCRUDModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->guestCreateCRUDModel = new GuestCreateCRUDModel($db);
        $this->guestUpdateCRUDModel = new GuestUpdateCRUDModel($db);
        $this->guestDeleteCRUDModel = new GuestDeleteCRUDModel($db);
    }

    public function createGuest(array $data): array 
    {
        return $this->guestCreateCRUDModel->createGuest($data);
    }

    public function updateGuest(int $personId, array $data): array 
    {
        return $this->guestUpdateCRUDModel->updateGuest($personId, $data);
    }

    public function deleteGuestByPersonId(int $id_persona): array
    {
        return $this->guestDeleteCRUDModel->deleteGuestByPersonId($id_persona);
    }
    
}
