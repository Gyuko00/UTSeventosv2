<div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-500" viewBox="0 0 640 640" fill="currentColor">
      <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM288 224C288 206.3 302.3 192 320 192C337.7 192 352 206.3 352 224C352 241.7 337.7 256 320 256C302.3 256 288 241.7 288 224zM280 288L328 288C341.3 288 352 298.7 352 312L352 400L360 400C373.3 400 384 410.7 384 424C384 437.3 373.3 448 360 448L280 448C266.7 448 256 437.3 256 424C256 410.7 266.7 400 280 400L304 400L304 336L280 336C266.7 336 256 325.3 256 312C256 298.7 266.7 288 280 288z"/>
    </svg>
    Información Personal
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Nombres *</label>
      <input
        type="text"
        name="person[nombres]"
        id="nombres"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-nombres"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Apellidos *</label>
      <input
        type="text"
        name="person[apellidos]"
        id="apellidos"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-apellidos"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Tipo Documento *</label>
      <select
        name="person[tipo_documento]"
        id="tipoDocumento"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      >
        <option value="">Seleccionar tipo</option>
        <option value="CC">Cédula de Ciudadanía</option>
        <option value="TI">Tarjeta de Identidad</option>
        <option value="CE">Cédula de Extranjería</option>
        <option value="PP">Pasaporte</option>
      </select>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Número Documento *</label>
      <input
        type="text"
        name="person[numero_documento]"
        id="numeroDocumento"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-numeroDocumento"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Correo Personal</label>
      <input
        type="email"
        name="person[correo_personal]"
        id="correoPersonal"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-correoPersonal"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Teléfono</label>
      <input
        type="tel"
        name="person[telefono]"
        id="telefono"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-telefono"></span>
    </div>

    <div>
      <label for="departamento" class="block text-base font-medium text-gray-700 mb-2">Departamento</label>
      <select
        id="departamento"
        name="person[departamento]"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#c9d230] focus:border-[#c9d230] text-base"
      >
        <option value="">Seleccione...</option>
      </select>
    </div>

    <div>
      <label for="municipio" class="block text-base font-medium text-gray-700 mb-2">Municipio</label>
      <select
        id="municipio"
        name="person[municipio]"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#c9d230] focus:border-[#c9d230] text-base"
      >
        <option value="">Seleccione un departamento primero...</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <label class="block text-base font-medium text-gray-700 mb-2">Dirección</label>
      <input
        type="text"
        name="person[direccion]"
        id="direccion"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-base"
      />
    </div>
  </div>
</div>     