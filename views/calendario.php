<?php
// ===========================
// calendario.php (SUBMÓDULO CALENDARIO)
// ===========================
  include_once('template/header.php');
?>
<!-- FIN NAVBAR -->

<!-- CONTENIDO SUBMÓDULO CALENDARIO -->
<div class="container mt-4">
  <h2><i class="fas fa-calendar-alt"></i> Submódulo Calendario</h2>
  <p class="text-muted">
    Programa los juegos con fecha, hora, sede y tipo de juego.
  </p>

  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Programar un Nuevo Juego</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label" for="equipoLocal">Equipo Local</label>
            <select class="form-select" id="equipoLocal" name="equipoLocal" required>
              <option selected disabled>-- Selecciona Local --</option>
              <!-- Llenar con tus equipos -->
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="equipoVisitante">Equipo Visitante</label>
            <select class="form-select" id="equipoVisitante" name="equipoVisitante" required>
              <option selected disabled>-- Selecciona Visitante --</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label" for="fechaJuego">Fecha</label>
            <input type="date" class="form-control" id="fechaJuego" name="fechaJuego" required>
          </div>
          <div class="col-md-4">
            <label class="form-label" for="horaJuego">Hora</label>
            <input type="time" class="form-control" id="horaJuego" name="horaJuego" required>
          </div>
          <div class="col-md-4">
            <label class="form-label" for="sede">Sede</label>
            <input type="text" class="form-control" id="sede" name="sede" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label" for="categoria">Categoría</label>
            <select class="form-select" id="categoria" name="categoria" required>
              <option value="1era Fuerza">1era Fuerza</option>
              <option value="2da Fuerza">2da Fuerza</option>
              <!-- ... -->
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="tipoJuego">Tipo de Juego</label>
            <select class="form-select" id="tipoJuego" name="tipoJuego" required>
              <option value="Rol Regular">Rol Regular</option>
              <option value="Exhibición">Exhibición</option>
              <option value="Play-off">Play-off</option>
              <option value="Semifinal">Semifinal</option>
              <option value="Final">Final</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Agregar
        </button>
      </form>
    </div>
  </div>

  <!-- Listado de Juegos -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Juegos Programados</strong>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Local</th>
            <th>Visitante</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Sede</th>
            <th>Categoría</th>
            <th>Tipo</th>
          </tr>
        </thead>
        <tbody>
          <!-- Llenar con BD -->
        </tbody>
      </table>
      <a href="#" class="btn btn-dark mt-2">
        <i class="fas fa-file-pdf"></i> Imprimir Calendario
      </a>
    </div>
  </div>
</div>
<!-- FIN SUBMÓDULO CALENDARIO -->

<!-- FOOTER SCRIPTS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
