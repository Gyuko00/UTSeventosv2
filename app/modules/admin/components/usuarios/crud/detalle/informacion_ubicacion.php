<div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
  <div class="bg-gradient-to-r from-lime-600 to-lime-700 text-white px-6 py-4 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 640 640" fill="currentColor">
      <path d="M128 252.6C128 148.4 214 64 320 64C426 64 512 148.4 512 252.6C512 371.9 391.8 514.9 341.6 569.4C329.8 582.2 310.1 582.2 298.3 569.4C248.1 514.9 127.9 371.9 127.9 252.6zM320 320C355.3 320 384 291.3 384 256C384 220.7 355.3 192 320 192C284.7 192 256 220.7 256 256C256 291.3 284.7 320 320 320z"/>
    </svg>
    <h2 class="text-xl font-semibold">Información de Ubicación</h2>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <tbody class="divide-y divide-gray-200 text-base">
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50 w-48">Departamento</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['departamento'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Municipio</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['municipio'] ?? ''); ?></td>
        </tr>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-lime-700 bg-lime-50">Dirección</td>
          <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($usuario['direccion'] ?? ''); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
