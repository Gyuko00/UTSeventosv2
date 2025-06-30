/*
Core Database Connection

Clase para manejar la conexión PDO a la base de datos MySQL.
Centraliza la configuración y permite el acceso seguro a través
del método getConnection(). Incluye manejo de errores y soporte
para UTF-8 y atributos PDO seguros.
*/

<?php

class Database
{
    private string $host = 'localhost';
    private string $db_name = 'utseventos';
    private string $username = 'root';
    private string $password = '';
    private ?PDO $conn = null;

    public function getConnection(): ?PDO
    {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }

        return $this->conn;
    }
}

?>
