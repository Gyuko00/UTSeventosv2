export function configurarActivarUsuario() {
  const btnActivar = document.getElementById("activarUsuarioBtn");
  if (!btnActivar) return;

  btnActivar.addEventListener("click", manejarActivarUsuario);
}

async function manejarActivarUsuario(e) {
  const btn = e.currentTarget;
  const usuarioId = btn.getAttribute("data-usuario-id");
  const usuarioNombre = btn.getAttribute("data-usuario-nombre");

  if (!usuarioId) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No se pudo identificar el usuario",
    });
    return;
  }

  const resultado = await Swal.fire({
    title: "¿Activar usuario?",
    text: `¿Estás seguro de que deseas activar a ${usuarioNombre}?`,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#059669",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, activar",
    cancelButtonText: "Cancelar",
  });

  if (!resultado.isConfirmed) return;

  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Activando...';

  try {
    const response = await fetch(
      `${window.URL_PATH}/admin/activarUsuario/${usuarioId}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
      }
    );

    const raw = await response.text(); 

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

    let result;
    try {
      result = JSON.parse(raw); 
    } catch (e) {
      throw new Error("La respuesta no es un JSON válido");
    }

    if (result.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "Usuario activado",
        text: result.message || "El usuario ha sido activado exitosamente",
      });

      actualizarInterfazUsuarioActivado();
    } else {
      throw new Error(result.message || "Error desconocido");
    }
  } catch (error) {

    Swal.fire({
      icon: "error",
      title: "Error",
      text: `No se pudo activar el usuario: ${error.message}`,
    });

    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-check"></i> Activar Usuario';
  }
}

function actualizarInterfazUsuarioActivado() {
  const estadoTexto = document.getElementById("estadoTexto");
  if (estadoTexto) {
    estadoTexto.textContent = "Activo";
    estadoTexto.className = "text-sm font-medium text-green-600";
  }

  const btnActivar = document.getElementById("activarUsuarioBtn");
  if (btnActivar) {
    btnActivar.remove();
  }
}
