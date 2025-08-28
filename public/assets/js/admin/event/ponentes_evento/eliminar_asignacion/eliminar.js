// public/assets/js/admin/event/ponentes_evento/eliminar_asignacion/eliminar.js
(function () {
  const BASE =
    (typeof window.URL_PATH === "string" && window.URL_PATH) 
      ? window.URL_PATH 
      : `${window.location.origin}/utseventos/public`;

  window.eliminarPonenteEvento = async function (idPonenteEvento, tema, evento) {
    const id = parseInt(idPonenteEvento, 10);

    const confirm = await Swal.fire({
      title: "Eliminando asignación...",
      html: `Se eliminará la asignación:<br><strong>Tema:</strong> ${tema}<br><strong>Evento:</strong> ${evento}`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc2626",
      cancelButtonColor: "#6b7280",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    });

    if (!confirm.isConfirmed) return;

    Swal.fire({
      title: "Procesando...",
      text: "Por favor espera",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    try {
      const url = `${BASE}/admin/eliminarAsignacionPonente/${id}`;
      const payload = { id_ponente_evento: id };

      const resp = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify(payload),
      });

      const text = await resp.text();
      Swal.close();

      let data;
      try {
        data = JSON.parse(text);
      } catch {
        await Swal.fire({
          icon: "error",
          title: "Error de respuesta",
          text: "El servidor no devolvió una respuesta JSON válida.",
          confirmButtonColor: "#d33",
          footer: `<small>Debug (primeros 120 chars): ${text.slice(0, 120)}...</small>`,
        });
        return;
      }

      if (data.status === "success") {
        await Swal.fire({
          icon: "success",
          title: "Asignación eliminada",
          text: data.message || "La asignación fue eliminada correctamente.",
          confirmButtonColor: "#3085d6",
          timer: 2200,
          timerProgressBar: true,
        });
        window.location.reload();
      } else {
        await Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message || "No se pudo eliminar la asignación.",
          confirmButtonColor: "#d33",
        });
      }
    } catch (err) {
      Swal.close();
      Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: `No se pudo conectar con el servidor: ${err.message}`,
        confirmButtonColor: "#d33",
        footer: `<small>Tipo de error: ${err.name}</small>`,
      });
    }
  };
})();
