<?php

/*
Modelo de gestión de usuarios

Este modelo permite que un usuario pueda actualizar su perfil, listar eventos disponibles y inscribirse a ellos después de validar su cupo.
También obtiene los eventos a los que el usuario ya se ha inscrito.
*/

require_once (__DIR__ . '/../../../core/Model.php');

class UserModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    // Obtener los datos personales y de usuario
    public function obtenerPerfil($id_usuario)
    {
        $sql = 'SELECT u.id_usuario, u.usuario, u.id_rol,
                       p.id_persona, p.tipo_documento, p.numero_documento,
                       p.nombres, p.apellidos, p.telefono, p.correo_personal,
                       p.departamento, p.municipio, p.direccion
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.id_usuario = :id_usuario';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar información personal y de usuario
    public function actualizarPerfil($data)
    {
        // Actualizar persona
        $sqlPersona = 'UPDATE personas SET
                          tipo_documento = :tipo_documento,
                          numero_documento = :numero_documento,
                          nombres = :nombres,
                          apellidos = :apellidos,
                          telefono = :telefono,
                          correo_personal = :correo_personal,
                          departamento = :departamento,
                          municipio = :municipio,
                          direccion = :direccion
                      WHERE id_persona = :id_persona';
        $stmt1 = $this->db->prepare($sqlPersona);
        $stmt1->execute([
            ':tipo_documento' => $data['tipo_documento'],
            ':numero_documento' => $data['numero_documento'],
            ':nombres' => $data['nombres'],
            ':apellidos' => $data['apellidos'],
            ':telefono' => $data['telefono'],
            ':correo_personal' => $data['correo_personal'],
            ':departamento' => $data['departamento'],
            ':municipio' => $data['municipio'],
            ':direccion' => $data['direccion'],
            ':id_persona' => $data['id_persona']
        ]);

        // Actualizar nombre de usuario si aplica
        if (!empty($data['usuario'])) {
            $sqlUsuario = 'UPDATE usuarios SET usuario = :usuario WHERE id_usuario = :id_usuario';
            $stmt2 = $this->db->prepare($sqlUsuario);
            $stmt2->execute([
                ':usuario' => $data['usuario'],
                ':id_usuario' => $data['id_usuario']
            ]);
        }

        return true;
    }

    // Eventos disponibles (no inscritos, cupo disponible)
    public function obtenerEventosDisponibles($id_persona)
    {
        $sql = '
            SELECT e.*, 
                (SELECT COUNT(*) FROM invitados_evento ie WHERE ie.id_evento = e.id_evento) AS inscritos
            FROM eventos e
            WHERE NOT EXISTS (
                SELECT 1 FROM invitados_evento ie 
                WHERE ie.id_evento = e.id_evento AND ie.id_persona = :id_persona
            )
            HAVING inscritos < e.cupo_maximo
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inscribir usuario a un evento
    public function inscribirAEvento($id_persona, $id_evento, $tipo_invitado = 'invitado')
    {
        $sql = "INSERT INTO invitados_evento (
                    id_evento, id_persona, tipo_invitado, fecha_inscripcion, estado_asistencia, certificado_generado
                ) VALUES (
                    :id_evento, :id_persona, :tipo_invitado, NOW(), 'no', 0
                )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_evento' => $id_evento,
            ':id_persona' => $id_persona,
            ':tipo_invitado' => $tipo_invitado
        ]);
    }

    // Obtener eventos a los que ya está inscrito
    public function obtenerMisEventos($id_persona)
    {
        $sql = '
            SELECT e.*, ie.fecha_inscripcion, ie.estado_asistencia, ie.certificado_generado
            FROM invitados_evento ie
            JOIN eventos e ON e.id_evento = ie.id_evento
            WHERE ie.id_persona = :id_persona
            ORDER BY e.fecha DESC
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar si ya está inscrito
    public function yaInscrito($id_evento, $id_persona)
    {
        $sql = 'SELECT COUNT(*) FROM invitados_evento
                WHERE id_evento = :id_evento AND id_persona = :id_persona';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_evento' => $id_evento,
            ':id_persona' => $id_persona
        ]);

        return $stmt->fetchColumn() > 0;
    }

    // Contar inscritos en un evento (para validación de cupo)
    public function contarInscritos($id_evento)
    {
        $sql = 'SELECT COUNT(*) FROM invitados_evento WHERE id_evento = :id_evento';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}

?>