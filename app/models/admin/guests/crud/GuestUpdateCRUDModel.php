<?php

/**
 * Modelo para actualizar invitados
 */
class GuestUpdateCRUDModel extends Model
{
    protected ValidateAdminGuestData $validator;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->validator = new ValidateAdminGuestData();
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
}
