<?php

/**
 * Modelo para actualizar invitados a los eventos
 */
class EventGuestUpdateCRUDModel extends Model
{
    protected ValidateEventGuestData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateEventGuestData();
    }

    public function updateGuestEvent(int $id, array $data): array
    {
        try {
            $this->validateId($id);
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = 'UPDATE invitados_evento SET 
                        id_persona = :id_persona,
                        id_evento = :id_evento,
                        token = :token,
                        estado_asistencia = :estado_asistencia,
                        fecha_inscripcion = :fecha_inscripcion,
                        certificado_generado = :certificado_generado
                    WHERE id_invitado_evento = :id';

            $data['id'] = $id;

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de invitado actualizado correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
