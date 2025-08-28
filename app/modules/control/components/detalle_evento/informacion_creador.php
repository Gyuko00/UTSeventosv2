<?php
// app/modules/admin/eventos/components/eventos/crud/detalle/informacion_creador.php
?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Información del Creador</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php if (isset($evento['creador'])): ?>
                    <?= htmlspecialchars(($evento['creador']['nombres'] ?? '') . ' ' . ($evento['creador']['apellidos'] ?? '')) ?>
                <?php else: ?>
                    <?= htmlspecialchars(($evento['creador_nombres'] ?? '') . ' ' . ($evento['creador_apellidos'] ?? '')) ?>
                <?php endif; ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Usuario</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php if (isset($evento['creador'])): ?>
                    <?= htmlspecialchars($evento['creador']['usuario'] ?? 'No disponible') ?>
                <?php else: ?>
                    ID: <?= $evento['id_usuario_creador'] ?>
                <?php endif; ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php 
                $email = '';
                if (isset($evento['creador']['correo_personal'])) {
                    $email = $evento['creador']['correo_personal'];
                } elseif (isset($evento['creador_email'])) {
                    $email = $evento['creador_email'];
                }
                ?>
                <?php if (!empty($email)): ?>
                    <a href="mailto:<?= htmlspecialchars($email) ?>" 
                       class="text-blue-600 hover:text-blue-500">
                        <?= htmlspecialchars($email) ?>
                    </a>
                <?php else: ?>
                    No disponible
                <?php endif; ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?php 
                $telefono = '';
                if (isset($evento['creador']['telefono'])) {
                    $telefono = $evento['creador']['telefono'];
                } elseif (isset($evento['creador_telefono'])) {
                    $telefono = $evento['creador_telefono'];
                }
                ?>
                <?= !empty($telefono) ? htmlspecialchars($telefono) : 'No disponible' ?>
            </dd>
        </div>
        
        <?php if (isset($evento['creador'])): ?>
        <div>
            <dt class="text-sm font-medium text-gray-500">Tipo de Documento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['creador']['tipo_documento'] ?? 'No disponible') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Número de Documento</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['creador']['numero_documento'] ?? 'No disponible') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Rol</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($evento['creador']['nombre_rol'] ?? 'Usuario') ?>
            </dd>
        </div>
        
        <div>
            <dt class="text-sm font-medium text-gray-500">Estado</dt>
            <dd class="mt-1">
                <?php if (($evento['creador']['activo'] ?? 1) == 1): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Activo
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Inactivo
                    </span>
                <?php endif; ?>
            </dd>
        </div>
        <?php endif; ?>
    </div>
</div>