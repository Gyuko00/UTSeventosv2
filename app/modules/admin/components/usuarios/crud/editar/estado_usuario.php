<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <div class="bg-gradient-to-r from-lime-600 to-lime-700 rounded-xl shadow-lg p-6 mb-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 640 640" fill="currentColor">
                <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
            </svg>
            <h3 class="text-lg font-semibold text-white">Estado del Usuario</h3>
        </div>
        <span class="text-sm opacity-80 text-white">Gestiona la activación o inactivación del usuario</span>
    </div>

    <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-gray-800">
            <span class="text-lg font-semibold">
                <?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>
            </span>
            <span class="text-sm text-gray-500">
                (<?= ucfirst(htmlspecialchars($usuario['nombre_rol'])) ?>)
            </span>
        </div>

        <div class="flex items-center gap-4">
            <span
                id="estadoTexto"
                class="text-base font-semibold <?= $usuario['activo'] ? 'text-green-600' : 'text-red-600' ?>"
            >
                <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
            </span>

            <?php if (!$usuario['activo']): ?>
                <button
                    type="button"
                    id="activarUsuarioBtn"
                    data-usuario-id="<?= $usuario['id_usuario'] ?>"
                    data-usuario-nombre="<?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg transition duration-200 flex items-center gap-2 shadow-sm hover:shadow-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 640 640" fill="currentColor">
                        <path d="M173 313l97 97L467 213c12-12 31-12 43 0s12 31 0 43L293 473c-12 12-31 12-43 0l-118-118c-12-12-12-31 0-43s31-12 43 0z"/>
                    </svg>
                    Activar Usuario
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
