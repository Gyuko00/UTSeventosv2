<?php
/**
 * Database: gestor de conexión PDO para la base de datos del sistema.
 * Permite obtener la conexión de manera centralizada y segura.
 */

class Database
{
    private ?PDO $conn = null;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $config = [
            'host'     => 'localhost',
            'db_name'  => 'utseventos',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',
            'options'  => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT         => false,
            ],
        ];

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public function getConnection(): ?PDO
    {
        return $this->conn;
    }
}
