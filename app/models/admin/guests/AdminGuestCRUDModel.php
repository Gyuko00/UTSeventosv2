<?php

/**
 * AdminGuestCRUDModel: CRUD para la tabla invitados
 */
class AdminGuestCRUDModel extends Model {

    protected ValidateAdminGuestData $validator;

    public function __construct(PDO $db) {
        parent::__construct($db);
        $this->validator = new ValidateAdminGuestData();
    }

    public function createGuest(array $data): array {
        try {
            $this->validator->validate($data);

            $sql = "INSERT INTO invitados 
                    (id_persona, tipo_invitado, correo_institucional, programa_academico, nombre_carrera, jornada, facultad, cargo, sede_institucion)
                    VALUES
                    (:id_persona, :tipo_invitado, :correo_institucional, :programa_academico, :nombre_carrera, :jornada, :facultad, :cargo, :sede_institucion)";

            $this->query($sql, $data);

            return ['status' => 'success', 'message' => 'Invitado creado exitosamente.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateGuest(int $id, array $data): array {
        try {
            $this->validateId($id);
            $this->validator->validate($data);

            $sql = "UPDATE invitados SET
                        id_persona = :id_persona,
                        tipo_invitado = :tipo_invitado,
                        correo_institucional = :correo_institucional,
                        programa_academico = :programa_academico,
                        nombre_carrera = :nombre_carrera,
                        jornada = :jornada,
                        facultad = :facultad,
                        cargo = :cargo,
                        sede_institucion = :sede_institucion
                    WHERE id_invitado = :id";

            $data['id'] = $id;

            $this->query($sql, $data);

            return ['status' => 'success', 'message' => 'Invitado actualizado correctamente.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteGuest(int $id): array {
        try {
            $this->validateId($id);

            $sql = "DELETE FROM invitados WHERE id_invitado = :id";

            $this->query($sql, [':id' => $id]);

            return ['status' => 'success', 'message' => 'Invitado eliminado correctamente.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
