import { limpiarCamposEspecificos, establecerRequeridosCamposPonente, establecerRequeridosCamposInvitado } from './helpers.js';

export function configurarEventListeners() {
    const toggleBtn = document.getElementById("togglePassword");
    const rolSelect = document.getElementById("rol");
    const tipoInvitadoSelect = document.getElementById("tipoInvitado");
    const programaSelect = document.getElementById("programaAcademico");

    if (toggleBtn) toggleBtn.addEventListener("click", togglePasswordVisibility);
    if (rolSelect) rolSelect.addEventListener("change", manejarCambioRol);
    if (tipoInvitadoSelect) tipoInvitadoSelect.addEventListener("change", manejarCambioTipoInvitado);
    if (programaSelect) programaSelect.addEventListener("change", manejarCambioProgramaAcademico);
}

export function configurarCamposDinamicos() {
    const rolValue = document.getElementById("rol").value;
    if (rolValue) manejarCambioRol();

    const tipoInvitadoValue = document.getElementById("tipoInvitado").value;
    if (tipoInvitadoValue) manejarCambioTipoInvitado();

    const programaValue = document.getElementById("programaAcademico").value;
    if (programaValue) manejarCambioProgramaAcademico();
}

function togglePasswordVisibility() {
    const passwordInput = document.getElementById("contrasenia");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    if (!passwordInput || !eyeOpen || !eyeClosed) return;

    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    eyeOpen.classList.toggle("hidden", !isPassword);
    eyeClosed.classList.toggle("hidden", isPassword);
}

function manejarCambioRol() {
    const rolValue = document.getElementById("rol").value;
    const camposPonente = document.getElementById("camposPonente");
    const camposInvitado = document.getElementById("camposInvitado");

    if (camposPonente) camposPonente.classList.add("hidden");
    if (camposInvitado) camposInvitado.classList.add("hidden");

    limpiarCamposEspecificos();

    switch (rolValue) {
        case "2":
            if (camposPonente) {
                camposPonente.classList.remove("hidden");
                establecerRequeridosCamposPonente(false);
            }
            break;
        case "3":
            if (camposInvitado) {
                camposInvitado.classList.remove("hidden");
                establecerRequeridosCamposInvitado(false);
            }
            break;
    }
}

function manejarCambioTipoInvitado() {
    const tipoValue = document.getElementById("tipoInvitado").value;
    const camposProgramaAcademico = document.getElementById("camposProgramaAcademico");
    const camposNombreCarrera = document.getElementById("camposNombreCarrera");
    const camposJornada = document.getElementById("camposJornada");
    const camposCargo = document.getElementById("camposCargo");

    if (camposProgramaAcademico) camposProgramaAcademico.classList.add("hidden");
    if (camposNombreCarrera) camposNombreCarrera.classList.add("hidden");
    if (camposJornada) camposJornada.classList.add("hidden");
    if (camposCargo) camposCargo.classList.add("hidden");

    switch (tipoValue) {
        case "estudiante":
            if (camposProgramaAcademico) camposProgramaAcademico.classList.remove("hidden");
            if (camposNombreCarrera) camposNombreCarrera.classList.remove("hidden");
            if (camposJornada) camposJornada.classList.remove("hidden");
            break;
        case "docente":
            if (camposCargo) camposCargo.classList.remove("hidden");
            if (camposProgramaAcademico) camposProgramaAcademico.classList.remove("hidden");
            if (camposNombreCarrera) camposNombreCarrera.classList.remove("hidden");
            break;
        case "administrativo":
            if (camposCargo) camposCargo.classList.remove("hidden");
            break;
    }
}

function manejarCambioProgramaAcademico() {
    const programaValue = document.getElementById("programaAcademico").value;
    const nombreCarreraSelect = document.getElementById("nombreCarrera");

    if (!nombreCarreraSelect) return;
    nombreCarreraSelect.innerHTML = '<option value="">Seleccionar carrera</option>';

    const carreras = {
        "tecnologia": [
            { value: "tecnologia_sistemas", text: "Tecnología en Sistemas Informáticos" },
            { value: "tecnologia_electronica", text: "Tecnología en Electrónica" },
            { value: "tecnologia_mecanica", text: "Tecnología en Mecánica" },
            { value: "tecnologia_industrial", text: "Tecnología Industrial" },
            { value: "tecnologia_construcciones", text: "Tecnología en Construcciones Civiles" }
        ],
        "ingenieria": [
            { value: "ingenieria_sistemas", text: "Ingeniería de Sistemas" },
            { value: "ingenieria_electromecanica", text: "Ingeniería Electromecánica" },
            { value: "ingenieria_industrial", text: "Ingeniería Industrial" },
            { value: "ingenieria_civil", text: "Ingeniería Civil" }
        ]
    };

    if (carreras[programaValue]) {
        carreras[programaValue].forEach(carrera => {
            const option = document.createElement("option");
            option.value = carrera.value;
            option.textContent = carrera.text;
            nombreCarreraSelect.appendChild(option);
        });
    }
}
