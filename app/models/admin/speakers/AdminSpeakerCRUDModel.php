<?php

/**
 * AdminSpeakerModel: CRUD de ponentes desde el administrador
 */
class AdminSpeakerCRUDModel extends Model
{
    protected ValidateSpeakerData $validateSpeakerData;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validateSpeakerData = new ValidateSpeakerData();
    }

    public function createSpeaker(array $speakerData): array
    {
        try {
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = 'INSERT INTO ponentes 
                    (id_persona, tema, descripcion_biografica, especializacion, institucion_ponente)
                    VALUES (:id_persona, :tema, :descripcion_biografica, :especializacion, :institucion_ponente)';
            $this->query($sql, $speakerData);

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente creado exitosamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateSpeaker(int $personId, array $speakerData): array
    {
        try {
            $this->validateId($personId);
            $this->validateSpeakerData->validate($speakerData);

            $this->getDB()->beginTransaction();

            $sql = 'UPDATE ponentes SET
                        tema = :tema,
                        descripcion_biografica = :descripcion_biografica,
                        especializacion = :especializacion,
                        institucion_ponente = :institucion_ponente
                    WHERE id_persona = :id_persona';

            $params = [
                ':id_persona' => $personId,
                ':tema' => $speakerData['tema'] ?? '',
                ':descripcion_biografica' => $speakerData['descripcion_biografica'] ?? '',
                ':especializacion' => $speakerData['especializacion'] ?? '',
                ':institucion_ponente' => $speakerData['institucion_ponente'] ?? ''
            ];

            $result = $this->query($sql, $params);

            if ($result->rowCount() === 0) {
                $sqlInsert = 'INSERT INTO ponentes (id_persona, tema, descripcion_biografica, especializacion, institucion_ponente) 
                             VALUES (:id_persona, :tema, :descripcion_biografica, :especializacion, :institucion_ponente)';
                $this->query($sqlInsert, $params);
            }

            $this->getDB()->commit();

            return ['status' => 'success', 'message' => 'Ponente actualizado exitosamente.'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteSpeakerByPersonId(int $id_persona): array
    {
        try {
            $this->validateId($id_persona);
            $this->getDB()->beginTransaction();
    
            $sqlCheck = 'SELECT COUNT(*) AS count FROM ponentes WHERE id_persona = :id_persona';
            $stmt = $this->query($sqlCheck, [':id_persona' => $id_persona]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
            if ($count == 0) {
                $this->getDB()->rollBack();
                throw new InvalidArgumentException('Ponente no encontrado.');
            }
    
            $this->query('UPDATE ponentes SET activo = 0 WHERE id_persona = :id_persona', [':id_persona' => $id_persona]);
    
            $this->getDB()->commit();
    
            return ['status' => 'success', 'message' => 'Ponente desactivado correctamente.'];
        } catch (Exception $e) {
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
