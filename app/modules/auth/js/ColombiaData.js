document.addEventListener("DOMContentLoaded", () => {
  let colombiaData = [];

  // Cargar departamentos y municipios desde el JSON externo
  fetch(
    "https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json"
  )
    .then((response) => response.json())
    .then((data) => {
      colombiaData = data;
      const departamentoSelect = document.getElementById("departamento");

      data.forEach((depto) => {
        const option = document.createElement("option");
        option.value = depto.departamento;
        option.textContent = depto.departamento;
        departamentoSelect.appendChild(option);
      });
    })
    .catch((error) =>
      console.error("Error cargando datos de Colombia:", error)
    );

  // Escuchar cambios en el select de departamento
  const departamentoSelect = document.getElementById("departamento");
  const municipioSelect = document.getElementById("municipio");

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