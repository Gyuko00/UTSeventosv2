<?php

/**
 * Modelo para crear invitados a los eventos
 */
class EventGuestCreateCRUDModel extends Model
{
    protected ValidateEventGuestData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateEventGuestData();
    }

    public function addGuestToEvent(array $data): array
    {
        try {
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = 'INSERT INTO invitados_evento 
                    (id_persona, id_evento, token, estado_asistencia,
                    fecha_inscripcion, certificado_generado) 
                    VALUES 
                    (:id_persona, :id_evento, :token, :estado_asistencia,
                    :fecha_inscripcion, :certificado_generado)';

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Invitado asignado al evento correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
