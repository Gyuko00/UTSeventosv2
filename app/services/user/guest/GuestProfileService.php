<?php

class GuestProfileService extends Service
{
    private GuestProfileModel $profileModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->profileModel = new GuestProfileModel($db);
    }

    public function obtenerPerfil(): array
    {
        if (!isset($_SESSION['id_usuario'])) {
            throw new Exception('Usuario no autenticado');
        }

        $id_usuario = (int) $_SESSION['id_usuario'];
        $perfil = $this->profileModel->getProfile($id_usuario);

        if (!$perfil) {
            throw new Exception('Perfil no encontrado');
        }

        return ['perfil' => $perfil];
    }

    public function actualizarPerfil(array $data): array
    {
        if (!isset($_SESSION['id_usuario'])) {
            return ['status' => 'error', 'message' => 'Usuario no autenticado'];
        }

        $id_usuario = (int) $_SESSION['id_usuario'];

        $errores = $this->validarDatosPerfil($data);
        if (!empty($errores)) {
            return [
                'status' => 'error',
                'message' => 'Datos inválidos: ' . implode(', ', $errores)
            ];
        }

        $perfilActual = $this->profileModel->getProfile($id_usuario);
        if (!$perfilActual) {
            return ['status' => 'error', 'message' => 'Perfil no encontrado'];
        }

        if (!empty($data['usuario']) && $data['usuario'] !== $perfilActual['usuario']) {
            if ($this->profileModel->usuarioExiste($data['usuario'], $id_usuario)) {
                return ['status' => 'error', 'message' => 'El nombre de usuario ya está en uso'];
            }
        }

        if (!empty($data['numero_documento']) && $data['numero_documento'] !== $perfilActual['numero_documento']) {
            if ($this->profileModel->documentoExiste($data['numero_documento'], $perfilActual['id_persona'])) {
                return ['status' => 'error', 'message' => 'El número de documento ya está registrado'];
            }
        }

        $datosActualizacion = [
            'id_usuario' => $id_usuario,
            'id_persona' => $perfilActual['id_persona'],
            'tipo_documento' => $data['tipo_documento'] ?? $perfilActual['tipo_documento'],
            'numero_documento' => $data['numero_documento'] ?? $perfilActual['numero_documento'],
            'nombres' => $data['nombres'] ?? $perfilActual['nombres'],
            'apellidos' => $data['apellidos'] ?? $perfilActual['apellidos'],
            'telefono' => $data['telefono'] ?? $perfilActual['telefono'],
            'correo_personal' => $data['correo_personal'] ?? $perfilActual['correo_personal'],
            'departamento' => $data['departamento'] ?? $perfilActual['departamento'],
            'municipio' => $data['municipio'] ?? $perfilActual['municipio'],
            'direccion' => $data['direccion'] ?? $perfilActual['direccion'],
            'usuario' => $data['usuario'] ?? $perfilActual['usuario']
        ];

        try {
            $resultado = $this->profileModel->updateProfile($datosActualizacion);

            if ($resultado) {
                $nuevoNombre = $datosActualizacion['nombres'] . ' ' . $datosActualizacion['apellidos'];
                $_SESSION['nombre'] = $nuevoNombre;

                if (isset($data['usuario'])) {
                    $_SESSION['usuario'] = $datosActualizacion['usuario'];
                }

                return [
                    'status' => 'success',
                    'message' => 'Perfil actualizado correctamente',
                    'nuevo_nombre' => $nuevoNombre
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No se pudo actualizar el perfil'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    public function cambiarContrasena(array $data): array
    {
        if (!isset($_SESSION['id_usuario'])) {
            return ['status' => 'error', 'message' => 'Usuario no autenticado'];
        }

        $id_usuario = (int) $_SESSION['id_usuario'];

        $contrasenaActual = trim($data['contrasena_actual'] ?? '');
        $nuevaContrasena = trim($data['nueva_contrasena'] ?? '');
        $confirmarContrasena = trim($data['confirmar_contrasena'] ?? '');

        if (empty($contrasenaActual) && empty($nuevaContrasena) && empty($confirmarContrasena)) {
            return [
                'status' => 'info',
                'message' => 'No se realizaron cambios en la contraseña'
            ];
        }

        if (empty($contrasenaActual) || empty($nuevaContrasena) || empty($confirmarContrasena)) {
            return [
                'status' => 'error',
                'message' => 'Para cambiar la contraseña, todos los campos son obligatorios'
            ];
        }

        if ($nuevaContrasena !== $confirmarContrasena) {
            return [
                'status' => 'error',
                'message' => 'La nueva contraseña y su confirmación no coinciden'
            ];
        }

        if (strlen($nuevaContrasena) < 6) {
            return [
                'status' => 'error',
                'message' => 'La nueva contraseña debe tener al menos 6 caracteres'
            ];
        }

        if ($contrasenaActual === $nuevaContrasena) {
            return [
                'status' => 'error',
                'message' => 'La nueva contraseña debe ser diferente a la actual'
            ];
        }

        try {
            $hashActual = $this->profileModel->obtenerHashContrasena($id_usuario);
            if (!$hashActual) {
                return ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }

            if (!password_verify($contrasenaActual, $hashActual)) {
                return [
                    'status' => 'error',
                    'message' => 'La contraseña actual es incorrecta'
                ];
            }

            $resultado = $this->profileModel->actualizarContrasena($id_usuario, $nuevaContrasena);

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Contraseña actualizada correctamente'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No se pudo actualizar la contraseña. Intenta nuevamente.'
                ];
            }
        } catch (Exception $e) {
            error_log("Error cambiando contraseña para usuario {$id_usuario}: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Error interno. Contacta al administrador.'
            ];
        }
    }

    private function validarDatosPerfil(array $data): array
    {
        $errores = [];

        if (!empty($data['nombres']) && strlen($data['nombres']) < 2) {
            $errores[] = 'Los nombres deben tener al menos 2 caracteres';
        }

        if (!empty($data['apellidos']) && strlen($data['apellidos']) < 2) {
            $errores[] = 'Los apellidos deben tener al menos 2 caracteres';
        }

        if (!empty($data['correo_personal']) && !filter_var($data['correo_personal'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido';
        }

        if (!empty($data['telefono']) && !preg_match('/^[0-9+\-\s()]{10,15}$/', $data['telefono'])) {
            $errores[] = 'El teléfono no tiene un formato válido';
        }

        if (!empty($data['numero_documento']) && !preg_match('/^[0-9]{6,15}$/', $data['numero_documento'])) {
            $errores[] = 'El número de documento debe tener entre 6 y 15 dígitos';
        }

        return $errores;
    }

    public function getMisEventos(): array
    {
        if (!isset($_SESSION['id_usuario'])) {
            return ['status' => 'error', 'message' => 'Usuario no autenticado'];
        }

        $id_usuario = (int) $_SESSION['id_usuario'];
        $id_invitado = $this->profileModel->getInvitadoIdByUsuario($id_usuario);

        if (!$id_invitado) {
            // Si no existe relación en tabla invitados, devuelve vacío (o error claro)
            return [
                'status' => 'success',
                'data' => [
                    'eventos_proximos' => [],
                    'eventos_pasados' => [],
                    'estadisticas' => [
                        'total_eventos' => 0,
                        'eventos_asistidos' => 0,
                        'eventos_no_asistidos' => 0,
                        'certificados_obtenidos' => 0,
                        'eventos_proximos' => 0,
                        'eventos_pasados' => 0
                    ]
                ],
                'debug_sql' => [
                    'motivo' => 'Usuario sin mapeo en tabla invitados',
                    'id_usuario' => $id_usuario,
                ]
            ];
        }

        try {
            // (opcional) debug
            $debugData = $this->debugUsuarioEventos($id_invitado);  // asegúrate de que este use id_invitado

            $eventos = $this->profileModel->getEventosInscritos($id_invitado);
            $estadisticas = $this->profileModel->getEstadisticasEventos($id_invitado);

            $eventosFormateados = array_map(function ($evento) {
                return [
                    'id_evento' => (int) $evento['id_evento'],
                    'titulo' => htmlspecialchars($evento['titulo_evento'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'tema' => htmlspecialchars($evento['tema'] ?? 'Sin tema', ENT_QUOTES, 'UTF-8'),
                    'descripcion' => $this->truncateText($evento['descripcion'] ?? '', 150),
                    'fecha' => $evento['fecha'],
                    'fecha_formateada' => $this->formatearFecha($evento['fecha']),
                    'hora_inicio' => $this->formatearHora($evento['hora_inicio']),
                    'hora_fin' => $this->formatearHora($evento['hora_fin']),
                    'ubicacion' => $this->formatearUbicacion($evento),
                    'cupo_maximo' => (int) $evento['cupo_maximo'],
                    'total_inscritos' => (int) $evento['total_inscritos'],
                    'estado_asistencia' => (int) $evento['estado_asistencia'],
                    'fecha_inscripcion' => $evento['fecha_inscripcion'],
                    'certificado_disponible' => (bool) $evento['certificado_generado'],
                    'token' => $evento['token'],
                    'es_proximo' => strtotime($evento['fecha']) >= strtotime(date('Y-m-d')),
                    'dias_restantes' => $this->calcularDiasRestantes($evento['fecha'])
                ];
            }, $eventos);

            $eventosProximos = array_filter($eventosFormateados, fn($e) => $e['es_proximo']);
            $eventosPasados = array_filter($eventosFormateados, fn($e) => !$e['es_proximo']);

            return [
                'status' => 'success',
                'data' => [
                    'eventos_proximos' => array_values($eventosProximos),
                    'eventos_pasados' => array_values($eventosPasados),
                    'estadisticas' => $estadisticas
                ],
                'debug_sql' => array_merge($debugData ?? [], [
                    'id_usuario' => $id_usuario,
                    'id_invitado' => $id_invitado,
                ]),
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al cargar los eventos',
                'debug_error' => $e->getMessage()
            ];
        }
    }

    // Métodos helper
    private function truncateText(string $text, int $length): string
    {
        return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
    }

    private function formatearFecha(string $fecha): string
    {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        $timestamp = strtotime($fecha);
        $dia = date('j', $timestamp);
        $mes = $meses[(int) date('n', $timestamp)];
        $año = date('Y', $timestamp);

        return "{$dia} de {$mes} de {$año}";
    }

    private function formatearHora(?string $hora): string
    {
        if (!$hora)
            return 'No definida';
        return date('g:i A', strtotime($hora));
    }

    private function formatearUbicacion(array $evento): string
    {
        $partes = array_filter([
            $evento['lugar_detallado'] ?? '',
            $evento['institucion_evento'] ?? '',
            $evento['municipio_evento'] ?? '',
            $evento['departamento_evento'] ?? ''
        ]);

        return implode(', ', $partes) ?: 'Ubicación por definir';
    }

    private function calcularDiasRestantes(string $fecha): int
    {
        $hoy = strtotime(date('Y-m-d'));
        $fechaEvento = strtotime($fecha);
        return max(0, (int) (($fechaEvento - $hoy) / (60 * 60 * 24)));
    }

    public function debugUsuarioEventos(int $id_usuario): array
    {
        // Consultar todos los invitados para ver la estructura
        $allInvitados = 'SELECT id_invitado_evento, id_invitado, id_evento FROM invitados_evento LIMIT 10';
        $stmt1 = $this->profileModel->query($allInvitados);
        $todosInvitados = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        // Contar registros para este usuario
        $countSql = 'SELECT COUNT(*) as total FROM invitados_evento WHERE id_invitado = :id';
        $stmt2 = $this->profileModel->query($countSql, [':id' => $id_usuario]);
        $count = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Intentar encontrar eventos para este usuario
        $userEventsSql = 'SELECT * FROM invitados_evento WHERE id_invitado = :id';
        $stmt3 = $this->profileModel->query($userEventsSql, [':id' => $id_usuario]);
        $userEvents = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        return [
            'muestra_invitados' => $todosInvitados,
            'count_para_usuario' => $count['total'],
            'eventos_usuario' => $userEvents
        ];
    }
}
