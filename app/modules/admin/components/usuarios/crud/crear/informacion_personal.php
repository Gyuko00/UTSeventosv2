<div class="bg-white p-6 rounded-lg shadow-sm">
  <h3 class="text-lg font-medium text-gray-800 mb-6 flex items-center">
    <i class="fas fa-user mr-2 text-blue-600"></i>
    Información Personal
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Nombres *</label
      >
      <input
        type="text"
        name="person[nombres]"
        id="nombres"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-nombres"></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Apellidos *</label
      >
      <input
        type="text"
        name="person[apellidos]"
        id="apellidos"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-apellidos"></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Tipo Documento *</label
      >
      <select
        name="person[tipo_documento]"
        id="tipoDocumento"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar tipo</option>
        <option value="CC">Cédula de Ciudadanía</option>
        <option value="TI">Tarjeta de Identidad</option>
        <option value="CE">Cédula de Extranjería</option>
        <option value="PP">Pasaporte</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Número Documento *</label
      >
      <input
        type="text"
        name="person[numero_documento]"
        id="numeroDocumento"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span
        class="text-red-500 text-xs hidden"
        id="error-numeroDocumento"
      ></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Correo Personal</label
      >
      <input
        type="email"
        name="person[correo_personal]"
        id="correoPersonal"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span
        class="text-red-500 text-xs hidden"
        id="error-correoPersonal"
      ></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Teléfono</label
      >
      <input
        type="tel"
        name="person[telefono]"
        id="telefono"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span class="text-red-500 text-xs hidden" id="error-telefono"></span>
    </div>

    <div>
      <label for="departamento" class="block text-sm font-medium text-gray-700"
        >Departamento</label
      >
      <select
        id="departamento"
        name="person[departamento]"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]"
      >
        <option value="">Seleccione...</option>
      </select>
    </div>

    <div>
      <label for="municipio" class="block text-sm font-medium text-gray-700"
        >Municipio</label
      >
      <select
        id="municipio"
        name="person[municipio]"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-[#c9d230] focus:border-[#c9d230]"
      >
        <option value="">Seleccione un departamento primero...</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Dirección</label
      >
      <input
        type="text"
        name="person[direccion]"
        id="direccion"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
    </div>
  </div>
</div>
