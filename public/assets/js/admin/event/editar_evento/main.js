// main.js (editar evento)
import { configurarValidaciones } from './campos_dinamicos.js';
import { manejarSubmitEvento } from './api.js';

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("editarEventoForm");
  if (!form) return;

  configurarValidaciones();

  form.addEventListener("submit", manejarSubmitEvento);
});