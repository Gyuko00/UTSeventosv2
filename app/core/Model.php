<?php

/*
Core Model
Clase base Model que proporciona funciones reutilizables para cualquier
modelo del sistema. Incluye operaciones CRUD seguras con PDO, manejo
de errores, sanitización y trazabilidad básica.

Uso: Heredar esta clase desde los modelos de cada módulo.
Ejemplo: class Usuario extends Model
*/

class Model
{
    /** @var PDO */
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Ejecuta una consulta SQL directa
    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute($params)) {
            throw new Exception('Error en la ejecución de la consulta.');
        }
        return $stmt;
    }

    public function getDB()
    {
        return $this->db;
    }
}

?>
