import {
  limpiarCamposEspecificos,
  limpiarCamposInvitado,
  limpiarCamposPonente,
  limpiarCamposInvitadoEspecificos,
} from "./helpers.js";

export function configurarEventListenersEditar() {
  const toggleBtn = document.getElementById("togglePassword");
  const rolSelect = document.getElementById("id_rol");
  const tipoInvitadoSelect = document.getElementById("tipoInvitado");
  const programaSelect = document.getElementById("programaAcademico");

  if (toggleBtn) toggleBtn.addEventListener("click", togglePasswordVisibility);
  if (rolSelect) rolSelect.addEventListener("change", manejarCambioRol);
  if (tipoInvitadoSelect)
    tipoInvitadoSelect.addEventListener("change", manejarCambioTipoInvitado);
  if (programaSelect)
    programaSelect.addEventListener("change", () => manejarCambioProgramaAcademico(false));
}

export function configurarCamposDinamicosEditar() {
  const rolSelect = document.getElementById("id_rol");
  if (rolSelect && rolSelect.value) {
    manejarCambioRol(true); 
  }

  const tipoInvitado = document.getElementById("tipoInvitado");
  if (tipoInvitado && tipoInvitado.value) {
    manejarCambioTipoInvitado(true); 
  }

  const programa = document.getElementById("programaAcademico");
  if (programa && programa.value) {
    setTimeout(() => {
      manejarCambioProgramaAcademico(true);
    }, 100);
  }
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

function manejarCambioRol(esCargaInicial = false) {
  const rolValue = document.getElementById("id_rol").value;
  const camposPonente = document.getElementById("camposPonente");
  const camposInvitado = document.getElementById("camposInvitado");

  if (camposPonente) camposPonente.classList.add("hidden");
  if (camposInvitado) camposInvitado.classList.add("hidden");

  if (!esCargaInicial) {
    limpiarCamposEspecificos();
    console.log("🧹 Limpiando campos porque cambió el rol");
  }

  switch (rolValue) {
    case "2": 
      if (camposPonente) {
        camposPonente.classList.remove("hidden");
      }
      console.log("👨‍🏫 Mostrando campos de ponente");
      break;
      
    case "3": 
      if (camposInvitado) {
        camposInvitado.classList.remove("hidden");

        if (esCargaInicial) {
          const tipoInvitado = document.getElementById("tipoInvitado");
          if (tipoInvitado && tipoInvitado.value) {
            manejarCambioTipoInvitado(true);

            const programa = document.getElementById("programaAcademico");
            if (programa && programa.value) {
              setTimeout(() => {
                manejarCambioProgramaAcademico(true);
              }, 100);
            }
          }
        }
      }
      console.log("👥 Mostrando campos de invitado");
      break;
      
    case "4": 
      console.log("⚙️ Rol de control seleccionado - sin campos específicos");
      break;
      
    default:
      console.log("❓ Rol desconocido o sin seleccionar");
      break;
  }
}

function manejarCambioTipoInvitado(esCargaInicial = false) {
  const tipoValue = document.getElementById("tipoInvitado").value;
  const camposProgramaAcademico = document.getElementById("camposProgramaAcademico");
  const camposNombreCarrera = document.getElementById("camposNombreCarrera");
  const camposJornada = document.getElementById("camposJornada");
  const camposCargo = document.getElementById("camposCargo");

  if (camposProgramaAcademico) camposProgramaAcademico.classList.add("hidden");
  if (camposNombreCarrera) camposNombreCarrera.classList.add("hidden");
  if (camposJornada) camposJornada.classList.add("hidden");
  if (camposCargo) camposCargo.classList.add("hidden");

  if (!esCargaInicial) {
    limpiarCamposInvitadoEspecificos();
  }

  switch (tipoValue) {
    case "estudiante":
      if (camposProgramaAcademico) camposProgramaAcademico.classList.remove("hidden");
      if (camposNombreCarrera) camposNombreCarrera.classList.remove("hidden");
      if (camposJornada) camposJornada.classList.remove("hidden");
      
      if (esCargaInicial) {
        const programa = document.getElementById("programaAcademico");
        if (programa && programa.value) {
          setTimeout(() => {
            manejarCambioProgramaAcademico(true);
          }, 50);
        }
      }
      break;
      
    case "docente":
      if (camposCargo) camposCargo.classList.remove("hidden");
      if (camposProgramaAcademico) camposProgramaAcademico.classList.remove("hidden");
      if (camposNombreCarrera) camposNombreCarrera.classList.remove("hidden");
      
      if (esCargaInicial) {
        const programaDocente = document.getElementById("programaAcademico");
        if (programaDocente && programaDocente.value) {
          setTimeout(() => {
            manejarCambioProgramaAcademico(true);
          }, 50);
        }
      }
      break;
      
    case "administrativo":
      if (camposCargo) camposCargo.classList.remove("hidden");
      break;
  }
}

function manejarCambioProgramaAcademico(isEditar = false) {
  const programaValue = document.getElementById("programaAcademico").value;
  const nombreCarreraSelect = document.getElementById("nombreCarrera");

  if (!nombreCarreraSelect) return;
  
  const valorActual = nombreCarreraSelect.value;
  const valorDataset = nombreCarreraSelect.dataset.valorSeleccionado;
  
  nombreCarreraSelect.innerHTML = '<option value="">Seleccionar carrera</option>';

  const carreras = {
    tecnologia: [
      {
        value: "tecnologia_sistemas",
        text: "Tecnología en Sistemas Informáticos",
      },
      { value: "tecnologia_electronica", text: "Tecnología en Electrónica" },
      { value: "tecnologia_mecanica", text: "Tecnología en Mecánica" },
      { value: "tecnologia_industrial", text: "Tecnología Industrial" },
      {
        value: "tecnologia_construcciones",
        text: "Tecnología en Construcciones Civiles",
      },
    ],
    ingenieria: [
      { value: "ingenieria_sistemas", text: "Ingeniería de Sistemas" },
      {
        value: "ingenieria_electromecanica",
        text: "Ingeniería Electromecánica",
      },
      { value: "ingenieria_industrial", text: "Ingeniería Industrial" },
      { value: "ingenieria_civil", text: "Ingeniería Civil" },
    ],
  };

  if (carreras[programaValue]) {
    carreras[programaValue].forEach((carrera) => {
      const option = document.createElement("option");
      option.value = carrera.value;
      option.textContent = carrera.text;
      nombreCarreraSelect.appendChild(option);
    });

    if (isEditar) {
      const valorAEstablecer = valorDataset || valorActual;
      if (valorAEstablecer) {
        nombreCarreraSelect.value = valorAEstablecer;
        console.log(`✅ Establecido nombre_carrera: ${valorAEstablecer}`);
      }
    }
  }
}