<!--
Header layout para autenticación (login y register)

Utiliza TailwindCSS y colores asociados a la identidad UTS.
Incluye navegación entre Login y Registro. Responsive y accesible.
-->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Sistema de gestión de eventos - UTSeventos" />
  <meta name="author" content="Unidades Tecnológicas de Santander" />
  <title>UTSeventos</title>
  <link rel="stylesheet" href="/src/output.css" />
</head>
<body class="bg-white text-gray-800">
  <header class="bg-[#c9d230] shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-[#2e7d32]">UTSeventos</h1>
      <nav class="space-x-4">
        <a href="/auth/login" class="text-[#2e7d32] font-medium hover:underline">Inicio de sesión</a>
        <a href="/auth/register" class="text-[#2e7d32] font-medium hover:underline">Registrarse</a>
      </nav>
    </div>
  </header>
