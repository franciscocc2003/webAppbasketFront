<?php
// views/estadisticas_del_equipo.php
include_once('template/header.php');
?>

<div class="container mt-4">
  <h3 class="mb-4">
    <i class="fas fa-users-cog me-2"></i> Estadísticas del Equipo
  </h3>

  <!-- Formulario para filtrar por categoría o grupo -->
  <form method="GET" id="filtroEstadisticas" class="row mb-3">
    <input type="hidden" id="torneo_id" value="1"> <!-- Ajusta el ID real del torneo -->

    <div class="col-md-4 mb-2">
      <label for="categoria" class="form-label">Categoría:</label>
      <select class="form-select" id="categoria">
        <option value="">-- Todas --</option>
        <option value="1era Fuerza">1era Fuerza</option>
        <option value="2da Fuerza">2da Fuerza</option>
        <option value="Femenil">Femenil</option>
        <!-- Agrega más categorías según sea necesario -->
      </select>
    </div>
    <div class="col-md-4 mb-2">
      <label for="grupo" class="form-label">Grupo:</label>
      <select class="form-select" id="grupo">
        <option value="">-- Todos --</option>
        <option value="Grupo A">Grupo A</option>
        <option value="Grupo B">Grupo B</option>
        <!-- Agrega más grupos según sea necesario -->
      </select>
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="button" id="filtrar" class="btn btn-dark">
        <i class="fas fa-filter"></i> Filtrar
      </button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered align-middle" id="tablaEstadisticas">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Equipo</th>
          <th>Categoría</th>
          <th>Grupo</th>
          <th>G</th>
          <th>P</th>
          <th>PD</th>
          <th>PF</th>
          <th>PC</th>
          <th>DIF</th>
          <th>PTS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="11" class="text-center">Cargando estadísticas...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    <a href="index.php" class="btn btn-dark">
      <i class="fas fa-arrow-left"></i> Regresar al Inicio
    </a>
  </div>
</div>

<script>
  const baseUrl = "http://localhost/api"; // Ajusta la URL base de tu API

  document.addEventListener("DOMContentLoaded", function () {
    cargarEstadisticas();

    document.getElementById("filtrar").addEventListener("click", function () {
      cargarEstadisticas();
    });
  });

  function cargarEstadisticas() {
    const torneoId = document.getElementById("torneo_id").value;
    const categoria = document.getElementById("categoria").value;
    const grupo = document.getElementById("grupo").value;

    fetch(`${baseUrl}/equipos/estadisticas/${torneoId}?categoria=${categoria}&grupo=${grupo}`)
      .then((response) => response.json())
      .then((data) => {
        const tbody = document.querySelector("#tablaEstadisticas tbody");
        tbody.innerHTML = "";

        if (data.length > 0) {
          let posicion = 1;
          data.forEach((equipo) => {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${posicion++}</td>
              <td>
                ${equipo.logo
                  ? `<img src="data:image/png;base64,${equipo.logo}" alt="Logo ${equipo.nombre_equipo}" style="width: 30px; height: 30px; object-fit: cover; margin-right:5px;">`
                  : ""}
                ${equipo.nombre_equipo}
              </td>
              <td>${equipo.categoria || "-"}</td>
              <td>${equipo.grupo || "-"}</td>
              <td>${equipo.G}</td>
              <td>${equipo.P}</td>
              <td>${equipo.PD}</td>
              <td>${equipo.PF}</td>
              <td>${equipo.PC}</td>
              <td>
                <span style="color: ${equipo.DIF >= 0 ? "green" : "red"};">
                  ${equipo.DIF}
                </span>
              </td>
              <td><strong>${equipo.PTS}</strong></td>
            `;
            tbody.appendChild(row);
          });
        } else {
          tbody.innerHTML = `
            <tr>
              <td colspan="11" class="text-center">No hay registros de equipos para mostrar.</td>
            </tr>
          `;
        }
      })
      .catch((error) => {
        console.error("Error al cargar estadísticas:", error);
        const tbody = document.querySelector("#tablaEstadisticas tbody");
        tbody.innerHTML = `
          <tr>
            <td colspan="11" class="text-center text-danger">Error al cargar los datos</td>
          </tr>
        `;
      });
  }
</script>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include_once('template/footer.php');
?>
