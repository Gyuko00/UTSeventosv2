// filtros.core.js
// Lógica de filtrado y limpieza
import { SELECTORS, CAP_RANGOS } from './filtros.config.js';

const el = (id) => document.getElementById(id);
const val = (id) => (el(id)?.value ?? '').trim();
const low = (s) => String(s || '').toLowerCase();

function parseHoraDesdeTexto(txt) {
  const m = String(txt).match(/(\d{1,2}):(\d{2})/);
  return m ? parseInt(m[1], 10) : null;
}

function parseFechaDMYDesdeTexto(txt) {
  const m = String(txt).match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
  if (!m) return null;
  return new Date(parseInt(m[3], 10), parseInt(m[2], 10) - 1, parseInt(m[1], 10));
}

function coincideBusquedaFila(fila, busqueda) {
  if (!busqueda) return true;
  return low(fila.textContent).includes(low(busqueda));
}

function coincideTema(celdaTema, temaFiltro) {
  if (!temaFiltro) return true;
  return low(celdaTema?.textContent).includes(low(temaFiltro));
}

function coincideInstitucion(celdaInst, instFiltro) {
  if (!instFiltro) return true;
  return String(celdaInst?.textContent || '').includes(instFiltro);
}

function coincideCapacidad(celdaCap, capFiltro) {
  if (!capFiltro) return true;
  const cap = parseInt(String(celdaCap?.textContent || '').trim(), 10) || 0;
  const r = CAP_RANGOS[capFiltro];
  if (!r) return true;
  return cap >= r.min && cap <= r.max;
}

function coincideHorario(celdaFechaHora, horarioFiltro) {
  if (!horarioFiltro) return true;
  const h = parseHoraDesdeTexto(celdaFechaHora?.textContent || '');
  if (h == null) return true;
  if (horarioFiltro === 'manana') return h >= 6 && h < 12;
  if (horarioFiltro === 'tarde') return h >= 12 && h < 18;
  if (horarioFiltro === 'noche') return h >= 18 && h < 24;
  return true;
}

function coincideFecha(celdaFechaHora, fechaFiltro) {
  if (!fechaFiltro) return true;
  const f = parseFechaDMYDesdeTexto(celdaFechaHora?.textContent || '');
  if (!f) return true;

  const hoy = new Date(); hoy.setHours(0, 0, 0, 0);
  const cmp = new Date(f); cmp.setHours(0, 0, 0, 0);

  if (fechaFiltro === 'hoy') return cmp.getTime() === hoy.getTime();

  if (fechaFiltro === 'manana') {
    const man = new Date(hoy); man.setDate(hoy.getDate() + 1);
    return cmp.getTime() === man.getTime();
  }

  if (fechaFiltro === 'semana') {
    const fin = new Date(hoy); fin.setDate(hoy.getDate() + 7);
    return cmp >= hoy && cmp <= fin;
  }

  if (fechaFiltro === 'mes') {
    return cmp.getMonth() === hoy.getMonth() && cmp.getFullYear() === hoy.getFullYear();
  }

  if (fechaFiltro === 'proximos') return cmp >= hoy;
  if (fechaFiltro === 'pasados') return cmp < hoy;

  return true;
}

// --- NUEVO: filtros por departamento y municipio (match sobre el texto de la fila) ---
function coincideDepartamento(fila, departamentoFiltro) {
  if (!departamentoFiltro) return true;
  return low(fila.textContent).includes(low(departamentoFiltro));
}

function coincideMunicipio(fila, municipioFiltro) {
  if (!municipioFiltro) return true;
  return low(fila.textContent).includes(low(municipioFiltro));
}

export function aplicarFiltrosEventos() {
  const busqueda = val(SELECTORS.buscar).toLowerCase();
  const fechaFiltro = val(SELECTORS.fecha);
  const instFiltro = val(SELECTORS.institucion);
  const depFiltro = val(SELECTORS.departamento);   // <- aplicado
  const munFiltro = val(SELECTORS.municipio);      // <- aplicado
  const temaFiltro = val(SELECTORS.tema).toLowerCase();
  const capFiltro = val(SELECTORS.capacidad);
  const horarioFiltro = val(SELECTORS.horario);

  const filas = document.querySelectorAll(`#${SELECTORS.tabla} tr`);
  let visibles = 0;

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll('td');
    if (!celdas.length) return;

    let ok = true;
    ok = ok && coincideBusquedaFila(fila, busqueda);
    ok = ok && coincideTema(celdas[0], temaFiltro);
    ok = ok && coincideInstitucion(celdas[1], instFiltro);
    ok = ok && coincideDepartamento(fila, depFiltro);
    ok = ok && coincideMunicipio(fila, munFiltro);
    ok = ok && coincideCapacidad(celdas[4], capFiltro);
    ok = ok && coincideHorario(celdas[3], horarioFiltro);
    ok = ok && coincideFecha(celdas[3], fechaFiltro);

    fila.style.display = ok ? '' : 'none';
    if (ok) visibles++;
  });

  const contador = el(SELECTORS.contador);
  if (contador) {
    contador.textContent = `Mostrando ${visibles} evento${visibles !== 1 ? 's' : ''}`;
  }
}

export function limpiarFiltrosEventos() {
  [
    SELECTORS.buscar,
    SELECTORS.fecha,
    SELECTORS.institucion,
    SELECTORS.departamento,
    SELECTORS.municipio,
    SELECTORS.tema,
    SELECTORS.capacidad,
    SELECTORS.horario
  ].forEach((id) => { const n = el(id); if (n) n.value = ''; });

  aplicarFiltrosEventos();
}
