<div id="camposInvitado" class="bg-white p-6 rounded-lg shadow-sm hidden">
  <h3 class="text-lg font-medium text-gray-800 mb-6 flex items-center">
    <i class="fas fa-user-friends mr-2 text-green-600"></i>
    Información del Invitado
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Tipo de Invitado *</label
      >
      <select
        name="roleSpecific[tipo_invitado]"
        id="tipoInvitado"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar tipo</option>
        <option value="estudiante">Estudiante</option>
        <option value="docente">Docente</option>
        <option value="administrativo">Administrativo</option>
      </select>
      <span class="text-red-500 text-xs hidden" id="error-tipoInvitado"></span>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Correo Institucional</label
      >
      <input
        type="email"
        name="roleSpecific[correo_institucional]"
        id="correoInstitucional"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
      <span
        class="text-red-500 text-xs hidden"
        id="error-correoInstitucional"
      ></span>
    </div>

    <!-- Campos que aparecen según el tipo de invitado -->
    <div id="camposProgramaAcademico" class="hidden">
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Programa Académico</label
      >
      <select
        name="roleSpecific[programa_academico]"
        id="programaAcademico"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar programa</option>
        <option value="tecnologia">Tecnología</option>
        <option value="ingenieria">Ingeniería</option>
      </select>
    </div>

    <div id="camposNombreCarrera" class="hidden">
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Nombre de la Carrera</label
      >
      <select
        name="roleSpecific[nombre_carrera]"
        id="nombreCarrera"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar carrera</option>
        <!-- Las opciones se llenarán dinámicamente según el programa académico -->
      </select>
    </div>

    <div id="camposJornada" class="hidden">
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Jornada</label
      >
      <select
        name="roleSpecific[jornada]"
        id="jornada"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="">Seleccionar jornada</option>
        <option value="diurna">Diurna</option>
        <option value="nocturna">Nocturna</option>
        <option value="sabatina">Sabatina</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Facultad</label
      >
      <input
        type="text"
        name="roleSpecific[facultad]"
        id="facultad"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
    </div>

    <div id="camposCargo" class="hidden">
      <label class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
      <input
        type="text"
        name="roleSpecific[cargo]"
        id="cargo"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"
        >Sede Institución</label
      >
      <input
        type="text"
        name="roleSpecific[sede_institucion]"
        id="sedeInstitucion"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
    </div>
  </div>
</div>
