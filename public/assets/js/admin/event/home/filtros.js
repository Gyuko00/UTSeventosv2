import { mostrarMensajeSinResultados } from "./tabla.js";

export function configurarEventListeners() {
  const buscarInput = document.getElementById("buscarEvento");
  const filtroFecha = document.getElementById("filtroFecha");
  const filtroInstitucion = document.getElementById("filtroInstitucion");

  if (buscarInput) buscarInput.addEventListener("input", filtrarEventos);
  if (filtroFecha) filtroFecha.addEventListener("change", filtrarEventos);
  if (filtroInstitucion)
    filtroInstitucion.addEventListener("change", filtrarEventos);
}

export function filtrarEventos() {
  const busqueda = document.getElementById("buscarEvento").value.toLowerCase();
  const fechaFiltro = document.getElementById("filtroFecha").value;
  const institucionFiltro = document.getElementById("filtroInstitucion").value;

  const filas = document.querySelectorAll(".evento-row");
  let eventosVisibles = 0;

  filas.forEach((fila) => {
    const titulo = fila.dataset.titulo || "";
    const tema = fila.dataset.tema || "";
    const institucion = fila.dataset.institucion || "";
    const fecha = fila.dataset.fecha || "";
    const institucionId = fila.dataset.institucionId || "";

    const coincideBusqueda =
      !busqueda ||
      titulo.includes(busqueda) ||
      tema.includes(busqueda) ||
      institucion.includes(busqueda);

    const coincideFecha =
      !fechaFiltro || validarFiltroFecha(fecha, fechaFiltro);
    const coincidenInstitucion =
      !institucionFiltro || institucionId === institucionFiltro;

    if (coincideBusqueda && coincideFecha && coincidenInstitucion) {
      fila.style.display = "";
      eventosVisibles++;
    } else {
      fila.style.display = "none";
    }
  });

  mostrarMensajeSinResultados(eventosVisibles === 0);
}

function validarFiltroFecha(fechaEvento, filtro) {
  if (!fechaEvento || !filtro) return true;

  const hoy = new Date();
  const fechaEventoObj = new Date(fechaEvento);

  hoy.setHours(0, 0, 0, 0);
  fechaEventoObj.setHours(0, 0, 0, 0);

  switch (filtro) {
    case "hoy":
      return fechaEventoObj.getTime() === hoy.getTime();

    case "semana":
      const inicioSemana = new Date(hoy);
      inicioSemana.setDate(hoy.getDate() - hoy.getDay());
      const finSemana = new Date(inicioSemana);
      finSemana.setDate(inicioSemana.getDate() + 6);
      return fechaEventoObj >= inicioSemana && fechaEventoObj <= finSemana;

    case "mes":
      return (
        fechaEventoObj.getMonth() === hoy.getMonth() &&
        fechaEventoObj.getFullYear() === hoy.getFullYear()
      );

    case "proximos":
      return fechaEventoObj >= hoy;

    case "pasados":
      return fechaEventoObj < hoy;

    default:
      return true;
  }
}

export function limpiarFiltros() {
  document.getElementById("buscarEvento").value = "";
  document.getElementById("filtroFecha").value = "";
  document.getElementById("filtroInstitucion").value = "";

  const filas = document.querySelectorAll(".evento-row");
  filas.forEach((fila) => (fila.style.display = ""));

  mostrarMensajeSinResultados(false);
}
