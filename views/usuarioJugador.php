<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet">
  <link 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" 
    rel="stylesheet"
  >
  <title>Usuarios - Básquetbol</title>
</head>

<body class="bg-light">

<div class="container mt-4">

  <!-- SECCIÓN 1: Seleccionar Torneo -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0">
        <i class="fas fa-basketball-ball me-2"></i> Selecciona tu Torneo
      </h4>
    </div>
    <div class="card-body">
      <select class="form-select" id="selectTorneo">
        <option value="" disabled selected>-- Elige un Torneo --</option>
      </select>
    </div>
  </div>

  <!-- SECCIÓN 2: Información del Torneo -->
  <div id="infoTorneo" style="display: none;">
    <!-- Información General del Torneo -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
          <i class="fas fa-info-circle me-2"></i> Información del Torneo
        </h5>
      </div>
      <div class="card-body">
        <p><strong>Nombre del Torneo:</strong> <span id="nombreTorneo"></span></p>
        <p><strong>Sede:</strong> <span id="sedeTorneo"></span></p>
        <p><strong>Organizador:</strong> <span id="organizadorTorneo"></span></p>
      </div>
    </div>

    <!-- Grupos y Equipos -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">
          <i class="fas fa-users me-2"></i> Grupos y Equipos
        </h5>
      </div>
      <div class="card-body" id="gruposEquipos"></div>
    </div>

    <!-- Calendario de Juegos -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
          <i class="fas fa-calendar-alt me-2"></i> Calendario de Juegos
        </h5>
      </div>
      <div class="card-body" id="calendario"></div>
    </div>
  </div>

</div>

<script>
  const baseUrl = "http://localhost/api"; // Cambia esto según tu configuración

  document.addEventListener("DOMContentLoaded", () => {
    cargarTorneos();
    document.getElementById("selectTorneo").addEventListener("change", (event) => {
      cargarInformacionTorneo(event.target.value);
    });
  });

  function cargarTorneos() {
    fetch(`${baseUrl}/torneos`)
      .then((response) => response.json())
      .then((data) => {
        const selectTorneo = document.getElementById("selectTorneo");
        data.forEach((torneo) => {
          const option = document.createElement("option");
          option.value = torneo.id_torneo;
          option.textContent = torneo.nombre_torneo;
          selectTorneo.appendChild(option);
        });
      });
  }

  function cargarInformacionTorneo(torneoId) {
    fetch(`${baseUrl}/torneos/${torneoId}/informacion`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("infoTorneo").style.display = "block";

        // Información General del Torneo
        document.getElementById("nombreTorneo").textContent = data.nombre_torneo;
        document.getElementById("sedeTorneo").textContent = data.sede || "No especificada";
        document.getElementById("organizadorTorneo").textContent = data.organizador || "No especificado";

        // Grupos y Equipos
        mostrarGruposEquipos(data.grupos);

        // Calendario de Juegos
        mostrarCalendario(data.calendario);
      });
  }

  function mostrarGruposEquipos(grupos) {
    const container = document.getElementById("gruposEquipos");
    container.innerHTML = "";

    grupos.forEach((grupo) => {
      const grupoDiv = document.createElement("div");
      grupoDiv.classList.add("mb-3");
      grupoDiv.innerHTML = `
        <h6 class="text-success">${grupo.nombre_grupo}</h6>
        <ul class="list-group">
          ${grupo.equipos
            .map(
              (equipo) => `
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                  ${equipo.nombre_equipo}
                </span>
                <span class="badge bg-primary rounded-pill">Jugadores: ${equipo.jugadores.length}</span>
              </li>`
            )
            .join("")}
        </ul>
      `;
      container.appendChild(grupoDiv);
    });
  }

  function mostrarCalendario(calendario) {
    const container = document.getElementById("calendario");
    container.innerHTML = "";

    if (calendario.length === 0) {
      container.innerHTML = `<p class="text-muted">No hay juegos programados</p>`;
      return;
    }

    const table = document.createElement("table");
    table.classList.add("table", "table-striped", "table-bordered");
    table.innerHTML = `
      <thead class="table-dark">
        <tr>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Equipo Local</th>
          <th>Equipo Visitante</th>
          <th>Sede</th>
        </tr>
      </thead>
      <tbody>
        ${calendario
          .map(
            (juego) => `
            <tr>
              <td>${juego.fecha}</td>
              <td>${juego.hora}</td>
              <td>${juego.equipo_local}</td>
              <td>${juego.equipo_visitante}</td>
              <td>${juego.sede || "No especificada"}</td>
            </tr>`
          )
          .join("")}
      </tbody>
    `;
    container.appendChild(table);
  }
</script>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include_once('template/footer.php');
?>
