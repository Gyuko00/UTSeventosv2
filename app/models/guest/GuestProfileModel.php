<?php

class GuestProfileModel extends Model
{
    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public function getProfile($id_usuario)
    {
        $sql = 'SELECT u.id_usuario, u.usuario, u.id_rol,
                       p.id_persona, p.tipo_documento, p.numero_documento,
                       p.nombres, p.apellidos, p.telefono, p.correo_personal,
                       p.departamento, p.municipio, p.direccion
                FROM usuarios u
                JOIN personas p ON u.id_persona = p.id_persona
                WHERE u.id_usuario = :id_usuario AND u.activo = 1 AND p.activo = 1';

        $stmt = $this->query($sql, [':id_usuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data)
    {
        try {
            $this->getDB()->beginTransaction();

            // Actualizar datos de persona
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

            $this->query($sqlPersona, [
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

            // Actualizar usuario si es necesario
            if (!empty($data['usuario'])) {
                $sqlUsuario = 'UPDATE usuarios SET usuario = :usuario
                              WHERE id_usuario = :id_usuario';
                $this->query($sqlUsuario, [
                    ':usuario' => $data['usuario'],
                    ':id_usuario' => $data['id_usuario']
                ]);
            }

            $this->getDB()->commit();
            return true;
        } catch (PDOException $e) {
            $this->getDB()->rollBack();
            throw $e;
        }
    }

    public function usuarioExiste($usuario, $excluirIdUsuario = null)
    {
        $sql = 'SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario AND activo = 1';
        $params = [':usuario' => $usuario];

        if ($excluirIdUsuario) {
            $sql .= ' AND id_usuario != :id_usuario';
            $params[':id_usuario'] = $excluirIdUsuario;
        }

        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn() > 0;
    }

    public function documentoExiste($numeroDocumento, $excluirIdPersona = null)
    {
        $sql = 'SELECT COUNT(*) FROM personas WHERE numero_documento = :numero_documento AND activo = 1';
        $params = [':numero_documento' => $numeroDocumento];

        if ($excluirIdPersona) {
            $sql .= ' AND id_persona != :id_persona';
            $params[':id_persona'] = $excluirIdPersona;
        }

        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerHashContrasena(int $id_usuario): ?string
    {
        $sql = 'SELECT contrasenia FROM usuarios WHERE id_usuario = :id_usuario AND activo = 1';
        $stmt = $this->query($sql, [':id_usuario' => $id_usuario]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ? $resultado['contrasenia'] : null;
    }

    public function actualizarContrasena(int $id_usuario, string $nuevaContrasena): bool
    {
        $hashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        $sql = 'UPDATE usuarios SET contrasenia = :contrasenia WHERE id_usuario = :id_usuario AND activo = 1';
        $stmt = $this->query($sql, [
            ':contrasenia' => $hashContrasena,
            ':id_usuario' => $id_usuario
        ]);

        return $stmt->rowCount() > 0;
    }

    // En tu ProfileModel (o el model que uses para estos queries)

    public function getInvitadoIdByUsuario(int $id_usuario): ?int
    {
        $sql = '
            SELECT i.id_invitado
            FROM usuarios u
            JOIN invitados i ON i.id_persona = u.id_persona
            WHERE u.id_usuario = :id_usuario
            LIMIT 1
        ';
        $stmt = $this->query($sql, [':id_usuario' => $id_usuario]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id_invitado'] : null;
    }

    public function getEventosInscritos(int $id_invitado): array
    {
        $sql = '
        SELECT 
            e.id_evento,
            e.titulo_evento,
            e.tema,
            e.descripcion,
            e.fecha,
            e.hora_inicio,
            e.hora_fin,
            e.departamento_evento,
            e.municipio_evento,
            e.institucion_evento,
            e.lugar_detallado,
            e.cupo_maximo,
            ie.estado_asistencia,
            ie.fecha_inscripcion,
            ie.certificado_generado,
            ie.token,
            (SELECT COUNT(*) FROM invitados_evento ie2 WHERE ie2.id_evento = e.id_evento) as total_inscritos
        FROM invitados_evento ie
        JOIN eventos e ON ie.id_evento = e.id_evento
        WHERE ie.id_invitado = :id_invitado
        ORDER BY e.fecha DESC, e.hora_inicio DESC
    ';
        try {
            $stmt = $this->query($sql, [':id_invitado' => $id_invitado]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Error en getEventosInscritos: ' . $e->getMessage());
            return [];
        }
    }

    public function getEstadisticasEventos(int $id_invitado): array
    {
        $sql = '
        SELECT 
            COUNT(*) as total_eventos,
            SUM(CASE WHEN estado_asistencia = 1 THEN 1 ELSE 0 END) as eventos_asistidos,
            SUM(CASE WHEN estado_asistencia = 0 THEN 1 ELSE 0 END) as eventos_no_asistidos,
            SUM(CASE WHEN certificado_generado = 1 THEN 1 ELSE 0 END) as certificados_obtenidos,
            SUM(CASE WHEN e.fecha >= CURDATE() THEN 1 ELSE 0 END) as eventos_proximos,
            SUM(CASE WHEN e.fecha < CURDATE() THEN 1 ELSE 0 END) as eventos_pasados
        FROM invitados_evento ie
        JOIN eventos e ON ie.id_evento = e.id_evento
        WHERE ie.id_invitado = :id_invitado
    ';
        try {
            $stmt = $this->query($sql, [':id_invitado' => $id_invitado]);
            $r = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
            return [
                'total_eventos' => (int) ($r['total_eventos'] ?? 0),
                'eventos_asistidos' => (int) ($r['eventos_asistidos'] ?? 0),
                'eventos_no_asistidos' => (int) ($r['eventos_no_asistidos'] ?? 0),
                'certificados_obtenidos' => (int) ($r['certificados_obtenidos'] ?? 0),
                'eventos_proximos' => (int) ($r['eventos_proximos'] ?? 0),
                'eventos_pasados' => (int) ($r['eventos_pasados'] ?? 0),
            ];
        } catch (Exception $e) {
            error_log('Error en getEstadisticasEventos: ' . $e->getMessage());
            return [
                'total_eventos' => 0,
                'eventos_asistidos' => 0,
                'eventos_no_asistidos' => 0,
                'certificados_obtenidos' => 0,
                'eventos_proximos' => 0,
                'eventos_pasados' => 0
            ];
        }
    }
}
