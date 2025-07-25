import { mostrarMensajeSinResultados } from './tabla.js';

export function configurarEventListeners() {
    const buscarInput = document.getElementById("buscarUsuario");
    const filtroRol = document.getElementById("filtroRol");
    const filtroEstado = document.getElementById("filtroEstado");

    if (buscarInput) buscarInput.addEventListener("input", filtrarUsuarios);
    if (filtroRol) filtroRol.addEventListener("change", filtrarUsuarios);
    if (filtroEstado) filtroEstado.addEventListener("change", filtrarUsuarios);
}

export function filtrarUsuarios() {
    const busqueda = document.getElementById("buscarUsuario").value.toLowerCase();
    const rolFiltro = document.getElementById("filtroRol").value;
    const estadoFiltro = document.getElementById("filtroEstado").value;

    const filas = document.querySelectorAll(".usuario-row");
    let usuariosVisibles = 0;

    filas.forEach(fila => {
        const nombre = fila.dataset.nombre || "";
        const usuario = fila.dataset.usuario || "";
        const documento = fila.dataset.documento || "";
        const rol = fila.dataset.rol || "";
        const activo = fila.dataset.activo || "";

        const coincideBusqueda = !busqueda ||
            nombre.includes(busqueda) ||
            usuario.includes(busqueda) ||
            documento.includes(busqueda);

        const coincidenRol = !rolFiltro || rol === rolFiltro;
        const coincidenEstado = !estadoFiltro || activo === estadoFiltro;

        if (coincideBusqueda && coincidenRol && coincidenEstado) {
            fila.style.display = "";
            usuariosVisibles++;
        } else {
            fila.style.display = "none";
        }
    });

    mostrarMensajeSinResultados(usuariosVisibles === 0);
}

export function limpiarFiltros() {
    document.getElementById("buscarUsuario").value = "";
    document.getElementById("filtroRol").value = "";
    document.getElementById("filtroEstado").value = "";

    const filas = document.querySelectorAll(".usuario-row");
    filas.forEach(fila => fila.style.display = "");

    mostrarMensajeSinResultados(false);
}
