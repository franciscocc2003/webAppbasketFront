<?php
// estadisticas_de_jugadores.php
include_once('template/header.php');
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <h3 class="mb-0">
        <i class="fas fa-chart-bar me-2"></i> Estadísticas de Jugadores
      </h3>
    </div>
    <div class="card-body">
      <p class="text-muted">
        Este módulo muestra el <strong>histórico de estadísticas</strong> de cada jugador: 
        puntos totales, tiros de 3 anotados y faltas acumuladas durante todo el torneo.
      </p>
      
      <!-- Tabla con estadísticas de jugadores -->
      <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>Foto</th>
              <th>Jugador</th>
              <th>Puntos Totales</th>
              <th>Tiros de 3</th>
              <th>Faltas Cometidas</th>
            </tr>
          </thead>
          <tbody id="estadisticas-jugadores-body">
            <tr>
              <td colspan="5" class="text-center">Cargando datos...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Botón para volver al inicio (o a otro módulo) -->
      <div class="mt-3">
        <a href="home.php" class="btn text-white" style="background-color:rgb(233, 115, 4);">
          <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS (incluye Popper) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = "http://localhost/api/"; // Cambia la URL si es necesario
    const idTorneo = <?= $_SESSION['id_torneo']; ?>; // ID del torneo de la sesión

    fetch(`${baseUrl}estadisticas/jugadores/${idTorneo}`)
      .then(response => response.json())
      .then(data => {
        const tbody = document.getElementById("estadisticas-jugadores-body");
        tbody.innerHTML = ""; // Limpiar la tabla

        if (data.length > 0) {
          data.forEach(jugador => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
            <td class="text-center">
                            ${
                                jugador.foto
                                    ? `<img src="data:image/jpeg;base64,${jugador.foto}" alt="Foto de ${jugador.nombre_jugador}" style="width: 50px; height: 50px; object-fit: cover;">`
                                    : '<i class="fas fa-user fa-2x text-secondary"></i>'
                            }
                        </td>
              <td>${jugador.nombre_jugador}</td>
              <td>${jugador.total_puntos}</td>
              <td>${jugador.total_triples}</td>
              <td>${jugador.total_faltas}</td>
            `;
            tbody.appendChild(tr);
          });
        } else {
          const tr = document.createElement("tr");
          tr.innerHTML = `<td colspan="5" class="text-center">No hay registros de estadísticas para mostrar.</td>`;
          tbody.appendChild(tr);
        }
      })
      .catch(error => {
        console.error("Error al obtener estadísticas:", error);
      });
  });
</script>

<?php
include_once('template/footer.php');
?>
