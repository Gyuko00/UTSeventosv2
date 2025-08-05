<?php

/**
 * Modelo para crear invitados
 */
class GuestCreateCRUDModel extends Model
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
}
