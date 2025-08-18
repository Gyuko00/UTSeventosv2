function limpiarFiltrosPonentes() {
  document.getElementById("buscarPonenteEvento").value = "";
  document.getElementById("filtroEvento").value = "";
  document.getElementById("filtroEstado").value = "";
  document.getElementById("filtroCertificado").value = "";
  document.getElementById("filtroInstitucion").value = "";
  document.getElementById("filtroFecha").value = "";

  aplicarFiltrosPonentes();
}

function aplicarFiltrosPonentes() {
  const busqueda = document
    .getElementById("buscarPonenteEvento")
    .value.toLowerCase();
  const eventoFiltro = document.getElementById("filtroEvento").value || "";
  const estadoFiltro = document.getElementById("filtroEstado").value || "";
  const certificadoFiltro =
    document.getElementById("filtroCertificado").value || "";
  const institucionFiltro =
    document.getElementById("filtroInstitucion").value || "";
  const fechaFiltro = document.getElementById("filtroFecha").value || "";

  const filas = document.querySelectorAll("#tablaPonentesEvento tr");
  let contadorVisible = 0;

  function parseFechaDMY(txt) {
    const m = String(txt).match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
    if (!m) return null;
    const d = parseInt(m[1], 10),
      mo = parseInt(m[2], 10) - 1,
      y = parseInt(m[3], 10);
    const dt = new Date(y, mo, d);
    dt.setHours(0, 0, 0, 0);
    return dt;
  }

  const hoy = new Date();
  hoy.setHours(0, 0, 0, 0);
  const manana = new Date(hoy);
  manana.setDate(hoy.getDate() + 1);
  const finSemana = new Date(hoy);
  finSemana.setDate(hoy.getDate() + 7);

  filas.forEach((fila) => {
    if (!fila.querySelector("td")) return;

    let mostrar = true;
    const celdas = fila.querySelectorAll("td");

    if (busqueda && mostrar) {
      const textoFila = (fila.textContent || "").toLowerCase();
      if (!textoFila.includes(busqueda)) mostrar = false;
    }

    if (eventoFiltro && mostrar) {
      const filaEventoId = (fila.dataset.eventoId || "").trim();
      if (String(filaEventoId) !== String(eventoFiltro)) mostrar = false;
    }

    if (estadoFiltro && mostrar) {
      const estadoTexto = (celdas[3]?.textContent || "").toLowerCase();
      if (!estadoTexto.includes(estadoFiltro.toLowerCase())) mostrar = false;
    }

    if (certificadoFiltro && mostrar) {
      const certificadoTexto = (celdas[3]?.textContent || "").toLowerCase();
      const tieneCertificado = certificadoTexto.includes(
        "certificado generado"
      );
      if (
        (certificadoFiltro === "1" && !tieneCertificado) ||
        (certificadoFiltro === "0" && tieneCertificado)
      ) {
        mostrar = false;
      }
    }

    if (institucionFiltro && mostrar) {
      const institucionTexto = (celdas[0]?.textContent || "").toLowerCase();
      if (!institucionTexto.includes(institucionFiltro.toLowerCase())) {
        mostrar = false;
      }
    }

    if (fechaFiltro && mostrar) {
      const fechaTxt = celdas[1]?.textContent || "";
      const f = parseFechaDMY(fechaTxt);
      if (f) {
        switch (fechaFiltro) {
          case "hoy":
            if (f.getTime() !== hoy.getTime()) mostrar = false;
            break;
          case "manana":
            if (f.getTime() !== manana.getTime()) mostrar = false;
            break;
          case "semana":
            if (f < hoy || f > finSemana) mostrar = false;
            break;
          case "mes":
            if (
              f.getMonth() !== hoy.getMonth() ||
              f.getFullYear() !== hoy.getFullYear()
            ) {
              mostrar = false;
            }
            break;
          case "proximos":
            if (f < hoy) mostrar = false;
            break;
          case "pasados":
            if (f >= hoy) mostrar = false;
            break;
          default:
            break;
        }
      }
    }

    fila.style.display = mostrar ? "" : "none";
    if (mostrar) contadorVisible++;
  });

  document.getElementById(
    "contadorResultados"
  ).textContent = `Mostrando ${contadorVisible} resultado${
    contadorVisible !== 1 ? "s" : ""
  }`;
}

document.addEventListener("DOMContentLoaded", function () {
  const filtros = [
    "buscarPonenteEvento",
    "filtroEvento",
    "filtroEstado",
    "filtroCertificado",
    "filtroInstitucion",
    "filtroFecha",
  ];

  filtros.forEach((filtroId) => {
    const elemento = document.getElementById(filtroId);
    if (elemento) {
      elemento.addEventListener("input", aplicarFiltrosPonentes);
      elemento.addEventListener("change", aplicarFiltrosPonentes);
    }
  });

  document
    .getElementById("exportarPonentes")
    ?.addEventListener("click", function () {
      console.log("Exportando ponentes...");
    });
});
