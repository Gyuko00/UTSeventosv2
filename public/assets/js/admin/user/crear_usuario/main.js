import { configurarEventListeners, configurarCamposDinamicos } from './campos_dinamicos.js';
import { manejarSubmitFormulario } from './validaciones.js';

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("crearUsuarioForm");
    if (!form) return;

    configurarEventListeners();
    configurarCamposDinamicos();

    form.addEventListener("submit", manejarSubmitFormulario);
});
