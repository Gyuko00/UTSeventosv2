// assets/js/admin/event/home/filtros/filtros.colombia.js
let _inicializado = false;
let colombiaData = [];

const ID_DEP = 'filtroDepartamento';
const ID_MUN = 'filtroMunicipio';

const el = (id) => document.getElementById(id);

async function cargarDatosColombia() {
  const url = 'https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json';
  const resp = await fetch(url, { cache: 'force-cache' });
  if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
  return resp.json();
}

function llenarDepartamentos() {
  const depSel = el(ID_DEP);
  if (!depSel) return;

  const cur = (depSel.value || '').trim();
  depSel.innerHTML = '<option value="">Todos los departamentos</option>';

  colombiaData.forEach(d => {
    const opt = document.createElement('option');
    opt.value = d.departamento;
    opt.textContent = d.departamento;
    if (cur && d.departamento === cur) opt.selected = true;
    depSel.appendChild(opt);
  });

  if (depSel.value) llenarMunicipios(depSel.value);
}

function llenarMunicipios(departamento) {
  const munSel = el(ID_MUN);
  if (!munSel) return;

  const cur = (munSel.value || '').trim();
  munSel.innerHTML = '<option value="">Todos los municipios</option>';

  const dep = colombiaData.find(d => d.departamento === departamento);
  if (dep && Array.isArray(dep.ciudades)) {
    dep.ciudades.forEach(ciudad => {
      const opt = document.createElement('option');
      opt.value = ciudad;
      opt.textContent = ciudad;
      munSel.appendChild(opt);
    });
  }
  if (cur && Array.from(munSel.options).some(o => o.value === cur)) {
    munSel.value = cur;
  }
}

function setupDependencias() {
  const depSel = el(ID_DEP);
  const munSel = el(ID_MUN);
  if (!depSel || !munSel) return;

  depSel.addEventListener('change', () => {
    llenarMunicipios(depSel.value);
    munSel.dispatchEvent(new Event('change')); 
  });
}

async function run() {
  setupDependencias();
  colombiaData = await cargarDatosColombia();
  llenarDepartamentos();
  el(ID_DEP)?.dispatchEvent(new Event('change'));
}

export function initColombiaFilters() {
  if (_inicializado) return;
  _inicializado = true;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }
}
