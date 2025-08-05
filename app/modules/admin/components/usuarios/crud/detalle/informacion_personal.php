<div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
  <div class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-6 py-4 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 640 640" fill="currentColor">
      <path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/>
    </svg>
    <h2 class="text-xl font-semibold">Información Personal</h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <tbody class="divide-y divide-gray-200 text-base">
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50 w-48">Nombres</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['nombres'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Apellidos</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['apellidos'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Tipo de Documento</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['tipo_documento'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Número de Documento</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['numero_documento'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Teléfono</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['telefono'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Correo Personal</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['correo_personal'] ?? ''); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
