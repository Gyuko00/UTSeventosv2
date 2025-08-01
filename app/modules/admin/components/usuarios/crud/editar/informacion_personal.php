<div class="bg-white p-6 rounded-lg shadow-sm">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-500" viewBox="0 0 640 640" fill="currentColor">
      <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM288 224C288 206.3 302.3 192 320 192C337.7 192 352 206.3 352 224C352 241.7 337.7 256 320 256C302.3 256 288 241.7 288 224zM280 288L328 288C341.3 288 352 298.7 352 312L352 400L360 400C373.3 400 384 410.7 384 424C384 437.3 373.3 448 360 448L280 448C266.7 448 256 437.3 256 424C256 410.7 266.7 400 280 400L304 400L304 336L280 336C266.7 336 256 325.3 256 312C256 298.7 266.7 288 280 288z"/>
    </svg>
    Información Personal
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label for="nombres" class="block text-base font-semibold text-gray-700 mb-2">Nombres *</label>
      <input
        type="text"
        name="person[nombres]"
        id="nombres"
        value="<?= htmlspecialchars($usuarioData['nombres'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-nombres"></span>
    </div>

    <div>
      <label for="apellidos" class="block text-base font-semibold text-gray-700 mb-2">Apellidos *</label>
      <input
        type="text"
        name="person[apellidos]"
        id="apellidos"
        value="<?= htmlspecialchars($usuarioData['apellidos'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-apellidos"></span>
    </div>

    <div>
      <label for="tipoDocumento" class="block text-base font-semibold text-gray-700 mb-2">Tipo Documento *</label>
      <select
        name="person[tipo_documento]"
        id="tipoDocumento"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar tipo</option>
        <option value="CC" <?= ($usuarioData['tipo_documento'] ?? '') === 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
        <option value="TI" <?= ($usuarioData['tipo_documento'] ?? '') === 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
        <option value="CE" <?= ($usuarioData['tipo_documento'] ?? '') === 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
        <option value="PP" <?= ($usuarioData['tipo_documento'] ?? '') === 'PP' ? 'selected' : '' ?>>Pasaporte</option>
      </select>
    </div>

    <div>
      <label for="numeroDocumento" class="block text-base font-semibold text-gray-700 mb-2">Número Documento *</label>
      <input
        type="text"
        name="person[numero_documento]"
        id="numeroDocumento"
        value="<?= htmlspecialchars($usuarioData['numero_documento'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-numeroDocumento"></span>
    </div>

    <div>
      <label for="correoPersonal" class="block text-base font-semibold text-gray-700 mb-2">Correo Personal</label>
      <input
        type="email"
        name="person[correo_personal]"
        id="correoPersonal"
        value="<?= htmlspecialchars($usuarioData['correo_personal'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-correoPersonal"></span>
    </div>

    <div>
      <label for="telefono" class="block text-base font-semibold text-gray-700 mb-2">Teléfono</label>
      <input
        type="tel"
        name="person[telefono]"
        id="telefono"
        value="<?= htmlspecialchars($usuarioData['telefono'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-telefono"></span>
    </div>

    <div>
      <label for="departamento" class="block text-base font-semibold text-gray-700 mb-2">Departamento</label>
      <select
        id="departamento"
        name="person[departamento]"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#c9d230] focus:border-[#c9d230]"
      >
        <option value="">Seleccione...</option>
      </select>
    </div>

    <div>
      <label for="municipio" class="block text-base font-semibold text-gray-700 mb-2">Municipio</label>
      <select
        id="municipio"
        name="person[municipio]"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#c9d230] focus:border-[#c9d230]"
      >
        <option value="">Seleccione un departamento primero...</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <label for="direccion" class="block text-base font-semibold text-gray-700 mb-2">Dirección</label>
      <input
        type="text"
        name="person[direccion]"
        id="direccion"
        value="<?= htmlspecialchars($usuarioData['direccion'] ?? '') ?>"
        class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
    </div>
  </div>
</div>

<?php if (!empty($usuarioData['departamento'])): ?>
  <script>
    window.DEPARTAMENTO_SELECCIONADO = "<?= htmlspecialchars($usuarioData['departamento']) ?>";
    window.MUNICIPIO_SELECCIONADO = "<?= htmlspecialchars($usuarioData['municipio'] ?? '') ?>";
  </script>
<?php endif; ?>
