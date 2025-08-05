<?php
/**
 * Modelo para agregar ponentes a los eventos
 */
class EventSpeakerCreateCRUDModel extends Model
{
    protected ValidateEventSpeakerData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateEventSpeakerData();
    }

    public function addSpeakerToEvent(array $data): array
    {
        try {
            $this->validator->validate($data);

            $this->getDB()->beginTransaction();

            $sql = 'INSERT INTO ponentes_evento 
                    (id_ponente, id_evento, hora_participacion, estado_asistencia, certificado_generado, fecha_registro) 
                    VALUES 
                    (:id_ponente, :id_evento, :hora_participacion, :estado_asistencia, :certificado_generado, :fecha_registro)';

            $this->query($sql, $data);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente asignado al evento correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
