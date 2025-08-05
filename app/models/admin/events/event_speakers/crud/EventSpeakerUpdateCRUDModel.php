<?php
/**
 * Modelo para actualizar ponentes a los eventos
 */
class EventSpeakerUpdateCRUDModel extends Model
{
    protected ValidateEventSpeakerData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateEventSpeakerData();
    }

    public function updateSpeakerEvent(int $id, array $data): array
    {
        try {
            $this->validateId($id);
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = 'UPDATE ponentes_evento SET 
                        id_ponente = :id_ponente,
                        id_evento = :id_evento,
                        hora_participacion = :hora_participacion,
                        estado_asistencia = :estado_asistencia,
                        certificado_generado = :certificado_generado,
                        fecha_registro = :fecha_registro
                    WHERE id_ponente_evento = :id';

            $data['id'] = $id;

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Registro de ponente en evento actualizado.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
