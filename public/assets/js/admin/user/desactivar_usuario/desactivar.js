export async function eliminarUsuario(idUsuario) {
  Swal.fire({
    title: "Desactivando usuario...",
    text: "Por favor espera",
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading(),
  });

  try {
    const response = await fetch(
      `${window.location.origin}/utseventos/public/admin/eliminarUsuario`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({ id_usuario: parseInt(idUsuario) }),
      }
    );

    const resultado = await response.json().catch(() => ({}));
    Swal.close();

    if (resultado.status === "success") {
      await Swal.fire({
        icon: "success",
        title: "Usuario desactivado",
        text: resultado.message,
        confirmButtonColor: "#3085d6",
        timer: 2500,
        timerProgressBar: true,
      });
      window.location.reload();
    } else {
      await Swal.fire({
        icon: "error",
        title: "Error",
        text: resultado.message || "Error al desactivar el usuario",
        confirmButtonColor: "#d33",
      });
    }
  } catch (error) {
    Swal.close();
    Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor.",
      confirmButtonColor: "#d33",
    });
  }
}