/*
Core Model

Clase base Model que proporciona funciones reutilizables para cualquier
modelo del sistema. Incluye operaciones CRUD seguras con PDO, manejo
de errores, sanitización y trazabilidad básica.

Uso: Heredar esta clase desde los modelos de cada módulo.
Ejemplo: class Usuario extends Model
*/

<?php

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

    // Inserta y retorna el último ID insertado
    protected function insert(string $sql, array $params = []): int
    {
        $this->query($sql, $params);
        return (int) $this->db->lastInsertId();
    }

    // Ejecuta un SELECT y retorna una fila (asociativa)
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Ejecuta un SELECT y retorna múltiples filas
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ejecuta un UPDATE y retorna número de filas afectadas
    protected function update(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // Ejecuta un DELETE y retorna número de filas eliminadas
    protected function delete(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // Método general para validar campos requeridos
    protected function validateRequired(array $fields, array $data): bool
    {
        foreach ($fields as $field) {
            if (empty($data[$field]))
                return false;
        }
        return true;
    }

    // Método general para limpiar strings
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    // Devuelve JSON estándar de error
    protected function error(string $message): string
    {
        return json_encode(['status' => 'error', 'message' => $message]);
    }

    // Devuelve JSON estándar de éxito
    protected function success(string $message, array $data = []): string
    {
        return json_encode(['status' => 'success', 'message' => $message, 'data' => $data]);
    }
}

?>
