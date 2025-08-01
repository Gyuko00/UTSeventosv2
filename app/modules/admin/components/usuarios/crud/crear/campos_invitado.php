<div id="camposInvitado" class="bg-white p-8 rounded-xl shadow-md border border-gray-200 hidden">
  <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-400" viewBox="0 0 640 640" fill="currentColor">
      <path d="M320 80C377.4 80 424 126.6 424 184C424 241.4 377.4 288 320 288C262.6 288 216 241.4 216 184C216 126.6 262.6 80 320 80zM96 152C135.8 152 168 184.2 168 224C168 263.8 135.8 296 96 296C56.2 296 24 263.8 24 224C24 184.2 56.2 152 96 152zM0 480C0 409.3 57.3 352 128 352C140.8 352 153.2 353.9 164.9 357.4C132 394.2 112 442.8 112 496L112 512C112 523.4 114.4 534.2 118.7 544L32 544C14.3 544 0 529.7 0 512L0 480zM521.3 544C525.6 534.2 528 523.4 528 512L528 496C528 442.8 508 394.2 475.1 357.4C486.8 353.9 499.2 352 512 352C582.7 352 640 409.3 640 480L640 512C640 529.7 625.7 544 608 544L521.3 544zM472 224C472 184.2 504.2 152 544 152C583.8 152 616 184.2 616 224C616 263.8 583.8 296 544 296C504.2 296 472 263.8 472 224zM160 496C160 407.6 231.6 336 320 336C408.4 336 480 407.6 480 496L480 512C480 529.7 465.7 544 448 544L192 544C174.3 544 160 529.7 160 512L160 496z"/>
    </svg>
    Información del Invitado
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Tipo de Invitado *</label>
      <select
        name="roleSpecific[tipo_invitado]"
        id="tipoInvitado"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      >
        <option value="">Seleccionar tipo</option>
        <option value="estudiante">Estudiante</option>
        <option value="docente">Docente</option>
        <option value="administrativo">Administrativo</option>
      </select>
      <span class="text-red-500 text-sm hidden mt-1" id="error-tipoInvitado"></span>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Correo Institucional</label>
      <input
        type="email"
        name="roleSpecific[correo_institucional]"
        id="correoInstitucional"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      />
      <span class="text-red-500 text-sm hidden mt-1" id="error-correoInstitucional"></span>
    </div>

    <div id="camposProgramaAcademico" class="hidden">
      <label class="block text-base font-medium text-gray-700 mb-2">Programa Académico</label>
      <select
        name="roleSpecific[programa_academico]"
        id="programaAcademico"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      >
        <option value="">Seleccionar programa</option>
        <option value="tecnologia">Tecnología</option>
        <option value="ingenieria">Ingeniería</option>
      </select>
    </div>

    <div id="camposNombreCarrera" class="hidden">
      <label class="block text-base font-medium text-gray-700 mb-2">Nombre de la Carrera</label>
      <select
        name="roleSpecific[nombre_carrera]"
        id="nombreCarrera"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      >
        <option value="">Seleccionar carrera</option>
      </select>
    </div>

    <div id="camposJornada" class="hidden">
      <label class="block text-base font-medium text-gray-700 mb-2">Jornada</label>
      <select
        name="roleSpecific[jornada]"
        id="jornada"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      >
        <option value="">Seleccionar jornada</option>
        <option value="diurna">Diurna</option>
        <option value="nocturna">Nocturna</option>
        <option value="sabatina">Sabatina</option>
      </select>
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Facultad</label>
      <input
        type="text"
        name="roleSpecific[facultad]"
        id="facultad"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      />
    </div>

    <div id="camposCargo" class="hidden">
      <label class="block text-base font-medium text-gray-700 mb-2">Cargo</label>
      <input
        type="text"
        name="roleSpecific[cargo]"
        id="cargo"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      />
    </div>

    <div>
      <label class="block text-base font-medium text-gray-700 mb-2">Sede Institución</label>
      <input
        type="text"
        name="roleSpecific[sede_institucion]"
        id="sedeInstitucion"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-600 focus:border-lime-600 text-base"
      />
    </div>
  </div>
</div>
