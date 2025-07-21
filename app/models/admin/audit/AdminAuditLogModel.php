<?php

/**
 * AdminAuditLogModel: obtiene los logs de auditoria
 */

class AdminAuditLogModel extends Model {

    public function __construct(PDO $db) {
        parent::__construct($db);
    }

    public function getAllLogs(): array {
        $sql = "SELECT a.*, u.usuario
                FROM auditoria_admin a
                INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                ORDER BY a.fecha_hora DESC";
        $stmt = $this->query($sql);
        return [
            'status' => 'success',
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    public function log(int $idUsuario, string $accion, string $tabla, ?string $detalle = null): void {
        $sql = "INSERT INTO auditoria_admin 
                (id_usuario, accion_realizada, tabla_afectada, fecha_hora, detalle_opcional)
                VALUES 
                (:id_usuario, :accion, :tabla, NOW(), :detalle)";
                
        $params = [
            ':id_usuario' => $idUsuario,
            ':accion'     => $accion,
            ':tabla'      => $tabla,
            ':detalle'    => $detalle
        ];

        $this->query($sql, $params);
    }
}
