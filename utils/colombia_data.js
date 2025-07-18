/**
 * SCRIPT DE CARGA DE DATOS GEOGRÁFICOS DE COLOMBIA
 *
 * Carga dinámicamente departamentos y municipios de Colombia desde una
 * API externa. Maneja la selección cascada entre departamentos y sus
 * respectivos municipios, con soporte para valores predeterminados.
 *
 * Funcionalidades incluidas:
 * - Carga asíncrona de datos desde API de Colombia
 * - Llenado dinámico de select de departamentos
 * - Actualización automática de municipios según departamento
 * - Soporte para valores predeterminados via data attributes
 * - Manejo de errores de red y respuestas
 *
 * Elementos requeridos:
 * - Select con ID 'departamento' y atributo data-valor
 * - Select con ID 'municipio' y atributo data-valor
 * - Conexión a internet para la API externa
 *
 */

document.addEventListener("DOMContentLoaded", () => {
  const departamentoSelect = document.getElementById("departamento");
  const municipioSelect = document.getElementById("municipio");
  const valorActualDepartamento = departamentoSelect.getAttribute("data-valor");
  const valorActualMunicipio = municipioSelect.getAttribute("data-valor");

  let colombiaData = [];

  const cargarDatosColombia = async () => {
    try {
      const response = await fetch(
        "https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json"
      );

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      colombiaData = await response.json();
      llenarDepartamentos(colombiaData);

      departamentoSelect.dispatchEvent(new Event("change"));

      setTimeout(() => {
        if (valorActualMunicipio) {
          municipioSelect.value = valorActualMunicipio;
        }
      }, 100);
    } catch (error) {
      console.error("Error cargando datos de Colombia:", error);
    }
  };

  const llenarDepartamentos = (data) => {
    departamentoSelect.innerHTML =
      '<option value="">Seleccione un Departamento...</option>';
    data.forEach((depto) => {
      const option = document.createElement("option");
      option.value = depto.departamento;
      option.textContent = depto.departamento;
      if (depto.departamento === valorActualDepartamento) {
        option.selected = true;
      }
      departamentoSelect.appendChild(option);
    });
  };

  const llenarMunicipios = (departamentoSeleccionado) => {
    municipioSelect.innerHTML =
      '<option value="">Seleccione un Municipio...</option>';
    const departamento = colombiaData.find(
      (d) => d.departamento === departamentoSeleccionado
    );

    if (departamento && departamento.ciudades) {
      departamento.ciudades.forEach((ciudad) => {
        const option = document.createElement("option");
        option.value = ciudad;
        option.textContent = ciudad;
        municipioSelect.appendChild(option);
      });
    }
  };

  departamentoSelect.addEventListener("change", function () {
    const seleccionado = this.value;
    llenarMunicipios(seleccionado);
  });

  cargarDatosColombia();
});
