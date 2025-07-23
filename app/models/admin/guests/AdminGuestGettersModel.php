<?php

/**
 * AdminGuestGettersModel: obtiene los datos de invitados
 */
class AdminGuestGettersModel extends Model {

    public function getAllGuests(): array {
        $sql = "SELECT i.*, per.id_persona, per.tipo_documento, per.numero_documento, per.nombres, 
                per.apellidos, per.telefono, per.correo_personal, per.departamento, 
                per.municipio, per.direccion, 
                FROM invitados i
                INNER JOIN personas per ON i.id_persona = per.id_persona";
        $stmt = $this->query($sql);

        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getGuestByPersonId(int $id_persona): array {
        $this->validateId($id_persona);

        $sql = "SELECT i.*, per.id_persona, per.tipo_documento, per.numero_documento, per.nombres, 
                per.apellidos, per.telefono, per.correo_personal, per.departamento, 
                per.municipio, per.direccion
                FROM invitados i
                INNER JOIN personas per ON i.id_persona = per.id_persona
                WHERE per.id_persona = :id_persona";
        $stmt = $this->query($sql, [':id_persona' => $id_persona]);
        $guest = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$guest) {
            return ['status' => 'error', 'message' => 'Invitado no encontrado.'];
        }

        return ['status' => 'success', 'data' => $guest];
    }
}
