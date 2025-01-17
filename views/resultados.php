<?php
// ===========================
// resultados.php (SUBMÓDULO RESULTADOS)
// ===========================
include_once('template/header.php');
?>

<!-- CONTENIDO SUBMÓDULO RESULTADOS -->
<div class="container mt-4">
  <h2><i class="fas fa-clipboard-check"></i> Submódulo Resultados</h2>
  <p class="text-muted">
    Captura los resultados de los juegos, asignando el marcador y 
    sumando estadísticas individuales de los jugadores.
  </p>

  <div class="card mb-4">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <strong>Capturar Resultado</strong>
    </div>
    <div class="card-body">
      <form id="formResultado">
        <div class="mb-3">
          <label for="partido" class="form-label">Partido</label>
          <select class="form-select" id="partido" name="partido" required>
            <option selected disabled>-- Selecciona el Partido --</option>
          </select>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label" for="puntosLocal">Puntos Local</label>
            <input 
              type="number" 
              class="form-control" 
              id="puntosLocal" 
              name="puntosLocal" 
              required
            >
          </div>
          <div class="col-md-6">
            <label class="form-label" for="puntosVisitante">Puntos Visitante</label>
            <input 
              type="number" 
              class="form-control" 
              id="puntosVisitante" 
              name="puntosVisitante" 
              required
            >
          </div>
        </div>
        <div class="mb-3">
          <label for="default" class="form-label">Ganador por Default</label>
          <select class="form-select" id="default" name="default">
            <option value="">-- No Aplica --</option>
            <option value="local">Local</option>
            <option value="visitante">Visitante</option>
          </select>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <strong>Captura de Estadísticas</strong>
    </div>
    <div class="card-body">
      <!-- Equipo Local -->
      <h5>Equipo Local</h5>
      <table class="table table-bordered mb-3" id="tablaLocal">
        <thead class="table-dark">
          <tr>
            <th>Jugador</th>
            <th>Puntos</th>
            <th>Tiros de 3</th>
            <th>Faltas</th>
          </tr>
        </thead>
        <tbody>
          <!-- Jugadores del equipo local -->
        </tbody>
      </table>

      <!-- Equipo Visitante -->
      <h5>Equipo Visitante</h5>
      <table class="table table-bordered" id="tablaVisitante">
        <thead class="table-dark">
          <tr>
            <th>Jugador</th>
            <th>Puntos</th>
            <th>Tiros de 3</th>
            <th>Faltas</th>
          </tr>
        </thead>
        <tbody>
          <!-- Jugadores del equipo visitante -->
        </tbody>
      </table>

      <button type="button" id="guardarTodo" class="btn text-white" style="background-color:rgb(233, 115, 4);">
        <i class="fas fa-save"></i> Guardar Todo
      </button>
    </div>
  </div>
</div>
<!-- FIN SUBMÓDULO RESULTADOS -->

<!-- FOOTER SCRIPTS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
<script>
  const baseUrl = "http://localhost/api/";

  // Cargar partidos
  fetch(`${baseUrl}calendario/<?=$rol = $_SESSION['id_torneo']?>`)
    .then(response => response.json())
    .then(data => {
      const selectPartido = document.getElementById("partido");
      data.forEach(partido => {
        const option = document.createElement("option");
        option.value = JSON.stringify(partido);
        option.textContent = `${partido.equipo_local} vs ${partido.equipo_visitante} - ${partido.fecha}`;
        selectPartido.appendChild(option);
      });
    });

  // Cargar jugadores al seleccionar un partido
  document.getElementById("partido").addEventListener("change", function() {
    const partido = JSON.parse(this.value);
    cargarJugadores(partido.id_equipo_local, "tablaLocal");
    cargarJugadores(partido.id_equipo_visitante, "tablaVisitante");
  });

  // Función para cargar jugadores en las tablas
  function cargarJugadores(idEquipo, tablaId) {
    fetch(`${baseUrl}jugadores/${idEquipo}`)
      .then(response => response.json())
      .then(jugadores => {
        const tbody = document.getElementById(tablaId).querySelector("tbody");
        tbody.innerHTML = ""; // Limpiar tabla
        jugadores.forEach(jugador => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${jugador.nombre} ${jugador.apellidos}</td>
            <td><input type="number" class="form-control puntos" data-id="${jugador.id_jugador}" value="0"></td>
            <td><input type="number" class="form-control tiros" data-id="${jugador.id_jugador}" value="0"></td>
            <td><input type="number" class="form-control faltas" data-id="${jugador.id_jugador}" value="0"></td>
          `;
          tbody.appendChild(tr);
        });
      });
  }

  // Guardar todo: resultados y estadísticas
  document.getElementById("guardarTodo").addEventListener("click", function() {
    const partido = JSON.parse(document.getElementById("partido").value);

    // Obtener datos de resultados
    const dataResultado = {
      id_juego: partido.id_juego,
      marcador_local: document.getElementById("puntosLocal").value,
      marcador_visitante: document.getElementById("puntosVisitante").value,
      ganador_default: document.getElementById("default").value === "local" ? 1 : document.getElementById("default").value === "visitante" ? 2 : 0,
      estadisticas: []
    };

    // Obtener estadísticas de los jugadores
    ["tablaLocal", "tablaVisitante"].forEach(tablaId => {
      const rows = document.getElementById(tablaId).querySelectorAll("tbody tr");
      rows.forEach(row => {
        dataResultado.estadisticas.push({
          id_jugador: row.querySelector(".puntos").dataset.id,
          puntos: row.querySelector(".puntos").value,
          tiros_3: row.querySelector(".tiros").value,
          faltas: row.querySelector(".faltas").value
        });
      });
    });

    // Enviar los datos al servidor
    fetch(`${baseUrl}resultados/completos/${partido.id_juego}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(dataResultado)
    })
    .then(response => response.json())
    .then(result => {
      alert(result.message || "Datos guardados con éxito");
      // Recargar la página después de guardar los datos
      window.location.reload();
    })
    .catch(error => alert("Ocurrió un error: " + error.message));
    });
</script>
</body>
</html>

<?php
include_once('template/footer.php');
?>