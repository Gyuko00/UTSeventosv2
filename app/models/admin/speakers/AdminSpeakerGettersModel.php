<?php

/** 
 * AdminSpeakerGettersModel: Getters del crud de los ponentes desde el administrador
 */
class AdminSpeakerGettersModel extends Model {
    
    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllSpeakers() {
        $sql = "SELECT p.id_ponente, p.tema, p.descripcion_biografica, p.especializacion, 
                p.institucion_ponente,
                per.id_persona, per.tipo_documento, per.numero_documento, per.nombres, 
                per.apellidos, per.telefono, per.correo_personal, per.departamento, 
                per.municipio, per.direccion
                FROM ponentes p
                INNER JOIN personas per ON p.id_persona = per.id_persona";
        $stmt = $this->query($sql);
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function getSpeakerByPersonId(int $id_persona) {
        $this->validateId($id_persona);
        $sql = "SELECT p.id_ponente, p.tema, p.descripcion_biografica, p.especializacion, 
                p.institucion_ponente,
                per.id_persona, per.tipo_documento, per.numero_documento, per.nombres, 
                per.apellidos, per.telefono, per.correo_personal, per.departamento, 
                per.municipio, per.direccion
                FROM ponentes p
                INNER JOIN personas per ON p.id_persona = per.id_persona 
                WHERE per.id_persona = :id_persona";
        $stmt = $this->query($sql, [':id_persona' => $id_persona]);
        $speaker = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$speaker) {
            return ['status' => 'error', 'message' => 'Ponente no encontrado.'];
        }

        return ['status' => 'success', 'data' => $speaker];
    }
}