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

    public function getSpeakerById(int $id) {
        $this->validateId($id);
        $sql = "SELECT p.id_ponente, p.tema, p.descripcion_biografica, p.especializacion, 
                p.institucion_ponente,
                per.id_persona, per.tipo_documento, per.numero_documento, per.nombres, 
                per.apellidos, per.telefono, per.correo_personal, per.departamento, 
                per.municipio, per.direccion
                FROM ponentes p
                INNER JOIN personas per ON p.id_persona = per.id_persona 
                WHERE p.id_ponente = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        $speaker = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$speaker) {
            return ['status' => 'error', 'message' => 'Ponente no encontrado.'];
        }

        return ['status' => 'success', 'data' => $speaker];
    }
}