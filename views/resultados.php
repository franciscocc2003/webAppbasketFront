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
    <div class="card-header bg-warning text-dark">
      <strong>Capturar Resultado</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST">
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
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Resultado
        </button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Captura de Estadísticas</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST">
        <!-- Equipo Local -->
        <h5>Equipo Local</h5>
        <table class="table table-bordered mb-3">
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
        <table class="table table-bordered">
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

        <button type="submit" class="btn btn-secondary">
          <i class="fas fa-clipboard-check"></i> Guardar Estadísticas
        </button>
      </form>
    </div>
  </div>
</div>
<!-- FIN SUBMÓDULO RESULTADOS -->

<!-- FOOTER SCRIPTS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
