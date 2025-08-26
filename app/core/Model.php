<?php
/**
 * Model: clase base para modelos de datos con acceso PDO.
 * Permite ejecutar consultas seguras y reutilizables desde los modelos específicos.
 */

abstract class Model
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute($params)) {
            throw new Exception('Error en la consulta: ' . implode(', ', $stmt->errorInfo()));
        }
        return $stmt;
    }

    public function validateId(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido');
        }
    }

    public function getDB(): PDO
    {
        return $this->db;
    }
}
