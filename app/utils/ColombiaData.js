document.addEventListener("DOMContentLoaded", () => {
  let colombiaData = [];

  const departamentoSelect = document.getElementById("departamento");
  const municipioSelect = document.getElementById("municipio");

  const valorActualDepartamento = departamentoSelect.getAttribute("data-valor");
  const valorActualMunicipio = municipioSelect.getAttribute("data-valor");

  // Cargar departamentos y municipios desde el JSON externo
  fetch(
    "https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json"
  )
    .then((response) => response.json())
    .then((data) => {
      colombiaData = data;

      // Llenar departamentos
      data.forEach((depto) => {
        const option = document.createElement("option");
        option.value = depto.departamento;
        option.textContent = depto.departamento;
        if (depto.departamento === valorActualDepartamento) {
          option.selected = true;
        }
        departamentoSelect.appendChild(option);
      });

      // Disparar manualmente el evento para que cargue los municipios
      departamentoSelect.dispatchEvent(new Event("change"));

      // Esperar un poco para que los municipios se carguen y seleccionar el correcto
      setTimeout(() => {
        if (valorActualMunicipio) {
          municipioSelect.value = valorActualMunicipio;
        }
      }, 100);
    })
    .catch((error) =>
      console.error("Error cargando datos de Colombia:", error)
    );

  // Escuchar cambios en el select de departamento
  departamentoSelect.addEventListener("change", function () {
    municipioSelect.innerHTML = '<option value="">Seleccione...</option>';

    const seleccionado = this.value;
    const departamento = colombiaData.find(
      (d) => d.departamento === seleccionado
    );

    if (departamento) {
      departamento.ciudades.forEach((ciudad) => {
        const option = document.createElement("option");
        option.value = ciudad;
        option.textContent = ciudad;
        municipioSelect.appendChild(option);
      });
    }
  });
});

console.log("ColombiaData.js cargado");
