document.addEventListener("DOMContentLoaded", () => {
  // INSCRIPCIÓN A EVENTO
  document.querySelectorAll(".form-inscribirse").forEach((form) => {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const aceptar = await Swal.fire({
        title: "Términos y condiciones",
        icon: "info",
        html: `
            <p>Para inscribirte a este evento debes aceptar nuestras <strong>políticas de privacidad</strong> y <strong>términos de uso</strong>.</p>
            <p>Tu información se usará exclusivamente para fines académicos y de certificación.</p>
          `,
        showCancelButton: true,
        confirmButtonText: "Aceptar y continuar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#43A047", // verde manzana
        cancelButtonColor: "#D32F2F", // rojo suave
      });

      if (!aceptar.isConfirmed) {
        return Swal.fire({
          icon: "warning",
          title: "Inscripción cancelada",
          text: "Debes aceptar los términos y condiciones para inscribirte.",
          confirmButtonColor: "#43A047",
        });
      }

      try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
          method: "POST",
          body: formData,
        });
        const result = await response.json();

        if (result.status === "success") {
          Swal.fire({
            icon: "success",
            title: "¡Inscripción exitosa!",
            text: result.message,
            confirmButtonColor: "#43A047",
          }).then(() => location.reload());
        } else {
          Swal.fire({
            icon: "error",
            title: "Error al inscribirse",
            text: result.message || "No se pudo realizar la inscripción.",
            confirmButtonColor: "#D32F2F",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error de red",
          text: "No se pudo conectar con el servidor.",
          confirmButtonColor: "#D32F2F",
        });
      }
    });
  });

  // CANCELAR INSCRIPCIÓN
  document.querySelectorAll(".form-cancelar").forEach((form) => {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const confirmacion = await Swal.fire({
        title: "¿Cancelar inscripción?",
        text: "Si cancelas, perderás tu cupo en este evento.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, cancelar",
        cancelButtonText: "No, conservar inscripción",
        confirmButtonColor: "#D32F2F",
        cancelButtonColor: "#43A047",
      });

      if (!confirmacion.isConfirmed) return;

      try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
          method: "POST",
          body: formData,
        });
        const result = await response.json();

        if (result.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Inscripción cancelada",
            text: result.message,
            confirmButtonColor: "#43A047",
          }).then(() => location.reload());
        } else {
          Swal.fire({
            icon: "error",
            title: "Error al cancelar",
            text: result.message || "No se pudo cancelar la inscripción.",
            confirmButtonColor: "#D32F2F",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error de red",
          text: "No se pudo conectar con el servidor.",
          confirmButtonColor: "#D32F2F",
        });
      }
    });
  });
});
