<?php

/**
 * AdminGuestCRUDModel: CRUD para la tabla invitados
 */
class AdminGuestCRUDModel extends Model
{
    protected ValidateAdminGuestData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateAdminGuestData();
    }

    public function createGuest(array $data): array 
    {
        try {
            $this->validator->validate($data);
    
            $sql = 'INSERT INTO invitados 
                    (id_persona, tipo_invitado, correo_institucional, programa_academico,
                    nombre_carrera, jornada, facultad, cargo, sede_institucion)
                    VALUES
                    (:id_persona, :tipo_invitado, :correo_institucional, :programa_academico,
                    :nombre_carrera, :jornada, :facultad, :cargo, :sede_institucion)';
            $params = [
                ':id_persona' => $data['id_persona'] ?? null,
                ':tipo_invitado' => $data['tipo_invitado'] ?? '',
                ':correo_institucional' => $data['correo_institucional'] ?? '',
                ':programa_academico' => $data['programa_academico'] ?? '',
                ':nombre_carrera' => $data['nombre_carrera'] ?? '',
                ':jornada' => $data['jornada'] ?? '',
                ':facultad' => $data['facultad'] ?? '',
                ':cargo' => $data['cargo'] ?? '',
                ':sede_institucion' => $data['sede_institucion'] ?? ''
            ];
    
            $this->query($sql, $params);
    
            return ['status' => 'success', 'message' => 'Invitado creado exitosamente.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateGuest(int $personId, array $data): array 
    {
        try {
            $this->validateId($personId);
            $this->validator->validate($data);
    
            $this->getDB()->beginTransaction();
    
            $sql = 'UPDATE invitados SET
                        tipo_invitado = :tipo_invitado,
                        correo_institucional = :correo_institucional,
                        programa_academico = :programa_academico,
                        nombre_carrera = :nombre_carrera,
                        jornada = :jornada,
                        facultad = :facultad,
                        cargo = :cargo,
                        sede_institucion = :sede_institucion
                    WHERE id_persona = :id_persona';
    
            $params = [
                ':id_persona' => $personId,
                ':tipo_invitado' => $data['tipo_invitado'] ?? '',
                ':correo_institucional' => $data['correo_institucional'] ?? '',
                ':programa_academico' => $data['programa_academico'] ?? '',
                ':nombre_carrera' => $data['nombre_carrera'] ?? '',
                ':jornada' => $data['jornada'] ?? '',
                ':facultad' => $data['facultad'] ?? '',
                ':cargo' => $data['cargo'] ?? '',
                ':sede_institucion' => $data['sede_institucion'] ?? ''
            ];
    
            $result = $this->query($sql, $params);
    
            if ($result->rowCount() === 0) {
                $sqlInsert = 'INSERT INTO invitados (id_persona, tipo_invitado, correo_institucional, programa_academico,
                                                    nombre_carrera, jornada, facultad, cargo, sede_institucion)
                              VALUES (:id_persona, :tipo_invitado, :correo_institucional, :programa_academico,
                                     :nombre_carrera, :jornada, :facultad, :cargo, :sede_institucion)';
                $this->query($sqlInsert, $params);
            }
    
            $this->getDB()->commit();
    
            return ['status' => 'success', 'message' => 'Invitado actualizado correctamente.'];
        } catch (Exception $e) {
            
            if ($this->getDB()->inTransaction()) {
                $this->getDB()->rollBack();
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteGuestByPersonId(int $id_persona): array
    {
        try {
            $this->validateId($id_persona);
            $this->getDB()->beginTransaction();
    
            $sqlCheck = 'SELECT COUNT(*) AS count FROM invitados WHERE id_persona = :id_persona';
            $stmt = $this->query($sqlCheck, [':id_persona' => $id_persona]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
            if ($count == 0) {
                $this->getDB()->rollBack();
                throw new InvalidArgumentException('Invitado no encontrado.');
            }
    
            // Soft delete en invitados
            $sql = 'UPDATE invitados SET activo = 0 WHERE id_persona = :id_persona';
            $this->query($sql, [':id_persona' => $id_persona]);
    
            $this->getDB()->commit();
    
            return ['status' => 'success', 'message' => 'Invitado desactivado correctamente.'];
        } catch (Exception $e) {
            $this->getDB()->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
}
