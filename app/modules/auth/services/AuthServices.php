<!--

Servicios de autenticación para el módulo Auth

Este archivo define funciones auxiliares para validar entradas, sanitizar
datos del usuario y manejar lógica común de autenticación. Se utiliza en
conjunto con AuthController para mejorar la legibilidad y modularidad.
-->

<?php

class AuthService
{
    /**
     * Sanitiza y estructura los datos personales recibidos del formulario.
     */
    public static function parsePersonaData(array $input): array
    {
        return [
            'tipo_documento' => trim($input['tipo_documento'] ?? ''),
            'numero_documento' => trim($input['numero_documento'] ?? ''),
            'nombres' => trim($input['nombres'] ?? ''),
            'apellidos' => trim($input['apellidos'] ?? ''),
            'telefono' => trim($input['telefono'] ?? ''),
            'correo_personal' => trim($input['correo_personal'] ?? ''),
            'departamento' => trim($input['departamento'] ?? ''),
            'municipio' => trim($input['municipio'] ?? ''),
            'direccion' => trim($input['direccion'] ?? ''),
        ];
    }

    /**
     * Sanitiza y estructura los datos del usuario recibidos del formulario.
     */
    public static function parseUsuarioData(array $input): array
    {
        return [
            'usuario' => trim($input['usuario'] ?? ''),
            'contrasenia' => trim($input['contrasenia'] ?? '')
        ];
    }

    /**
     * Valida que todos los campos obligatorios estén presentes.
     */
    public static function validarCamposObligatorios(array $persona, array $usuario): array
    {
        foreach ($persona as $campo => $valor) {
            if (empty($valor)) {
                return ['status' => 'error', 'message' => "El campo '$campo' es obligatorio."];
            }
        }

        foreach ($usuario as $campo => $valor) {
            if (empty($valor)) {
                return ['status' => 'error', 'message' => "El campo '$campo' es obligatorio."];
            }
        }

        return ['status' => 'success'];
    }

    /**
     * Verifica si una cadena es un correo electrónico válido.
     */
    public static function esCorreoValido(string $correo): bool
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Verifica si un campo tiene longitud mínima.
     */
    public static function longitudMinima(string $valor, int $min): bool
    {
        return mb_strlen($valor) >= $min;
    }
}
