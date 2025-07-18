<?php
/**
 * Service: clase base para servicios del sistema.
 * Facilita el acceso a la conexión PDO para lógica de negocio y reutilización.
 */

abstract class Service
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}
