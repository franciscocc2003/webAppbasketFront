<?php
// ===========================
// calendario.php (SUBMÓDULO CALENDARIO)
// ===========================
include_once('template/header.php');

// Validar que exista el id_torneo en la sesión
if (!isset($_SESSION['id_torneo'])) {
    echo '<p class="alert alert-warning">No se ha seleccionado ningún torneo. Por favor selecciona uno primero.</p>';
    exit;
}

// Obtener el ID del torneo desde la sesión
$id_torneo = $_SESSION['id_torneo'];

// Obtener los equipos asociados al torneo
$urlGrupos = "http://localhost/api/grupos/$id_torneo";
$responseGrupos = file_get_contents($urlGrupos);
$grupos = json_decode($responseGrupos, true) ?? [];

$equipos = [];
foreach ($grupos as $grupo) {
    $idGrupo = $grupo['id_grupo'];
    $urlEquipos = "http://localhost/api/equipos/$idGrupo";
    $responseEquipos = file_get_contents($urlEquipos);
    $equiposGrupo = json_decode($responseEquipos, true) ?? [];
    $equipos = array_merge($equipos, $equiposGrupo);
}

// Obtener los juegos programados
$urlJuegos = "http://localhost/api/calendario/$id_torneo";
$responseJuegos = file_get_contents($urlJuegos);
$juegos = json_decode($responseJuegos, true) ?? [];
?>
<!-- CONTENIDO SUBMÓDULO CALENDARIO -->
<div class="container mt-4">
  <h2><i class="fas fa-calendar-alt"></i> Submódulo Calendario</h2>
  <p class="text-muted">
    Programa los juegos con fecha, hora, sede y tipo de juego.
  </p>

  <!-- Formulario: Programar un Nuevo Juego -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Programar un Nuevo Juego</strong>
    </div>
    <div class="card-body">
      <form id="formJuego">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label" for="equipoLocal">Equipo Local</label>
            <select class="form-select" id="equipoLocal" name="equipo_local" required>
              <option selected disabled>-- Selecciona Local --</option>
              <?php foreach ($equipos as $equipo): ?>
                <option value="<?= htmlspecialchars($equipo['id_equipo']) ?>">
                  <?= htmlspecialchars($equipo['nombre_equipo']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="equipoVisitante">Equipo Visitante</label>
            <select class="form-select" id="equipoVisitante" name="equipo_visitante" required>
              <option selected disabled>-- Selecciona Visitante --</option>
              <?php foreach ($equipos as $equipo): ?>
                <option value="<?= htmlspecialchars($equipo['id_equipo']) ?>">
                  <?= htmlspecialchars($equipo['nombre_equipo']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label" for="fechaJuego">Fecha</label>
            <input type="date" class="form-control" id="fechaJuego" name="fecha" required>
          </div>
          <div class="col-md-4">
            <label class="form-label" for="horaJuego">Hora</label>
            <input type="time" class="form-control" id="horaJuego" name="hora" required>
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
              <option selected disabled>-- Selecciona --</option>
              <option value="1era Fuerza">1era Fuerza</option>
              <option value="2da Fuerza">2da Fuerza</option>
              <option value="Libre">Libre</option>
              <option value="Veteranos">Veteranos</option>
              <option value="Empresarial">Empresarial</option>
              <option value="Infantil">Infantil</option>
              <option value="Juvenil">Juvenil</option>
              <option value="MiniBasket">MiniBasket</option>
              <option value="Femenil">Femenil</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="tipoJuego">Tipo de Juego</label>
            <select class="form-select" id="tipoJuego" name="tipo_juego" required>
              <option selected disabled>-- Selecciona --</option>
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
  <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
    <strong>Juegos Programados</strong>
    <a href="http://localhost/api/calendario/pdf/<?=$_SESSION['id_torneo']?>" 
      class="btn btn-dark" 
      target="_blank">
      <i class="fa-solid fa-file-pdf"></i> Imprimir en PDF
    </a>

  </div>

    <div class="card-body">
    <table class="table table-bordered text-center align-middle">
  <thead class="table-dark">
    <tr>
      <th>Local</th>
      <th>Visitante</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Sede</th>
      <th>Categoría</th>
      <th>Tipo</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($juegos)): ?>
      <tr>
        <td colspan="8" class="text-center">No hay juegos programados</td>
      </tr>
    <?php else: ?>
      <?php foreach ($juegos as $juego): ?>
        <tr>
          <td><?= htmlspecialchars($juego['equipo_local']) ?></td>
          <td><?= htmlspecialchars($juego['equipo_visitante']) ?></td>
          <td><?= htmlspecialchars($juego['fecha']) ?></td>
          <td><?= htmlspecialchars($juego['hora']) ?></td>
          <td><?= htmlspecialchars($juego['sede']) ?></td>
          <td><?= htmlspecialchars($juego['categoria']) ?></td>
          <td><?= htmlspecialchars($juego['tipo_juego']) ?></td>
          <td>
            <a href="http://localhost/interfaz/views/editarCalendario.php?idJuego=<?= htmlspecialchars($juego['id_juego']) ?>" 
               class="btn btn-dark mt-2">
               <i class="fa-solid fa-pen-to-square"></i> Editar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

    </div>
  </div>
</div>

<!-- SCRIPT: Enviar formulario por POST -->
<script>
  document.getElementById('formJuego').addEventListener('submit', function (e) {
    e.preventDefault();

    const data = {
      id_equipo_local: document.getElementById('equipoLocal').value,
      id_equipo_visitante: document.getElementById('equipoVisitante').value,
      fecha: document.getElementById('fechaJuego').value,
      hora: document.getElementById('horaJuego').value,
      sede: document.getElementById('sede').value,
      categoria: document.getElementById('categoria').value,
      tipo_juego: document.getElementById('tipoJuego').value
    };

    fetch(`http://localhost/api/calendario/${<?= json_encode($id_torneo) ?>}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(result => {
        if (result.message) {
          alert(result.message);
          window.location.reload();
        } else {
          alert('Error al programar el juego');
        }
      })
      .catch(error => console.error('Error:', error));
  });

  // Evitar selección de los mismos equipos
  const equipoLocal = document.getElementById('equipoLocal');
  const equipoVisitante = document.getElementById('equipoVisitante');

  function actualizarOpciones() {
    const seleccionadoLocal = equipoLocal.value;
    const seleccionadoVisitante = equipoVisitante.value;

    [...equipoVisitante.options].forEach(option => {
      option.disabled = option.value === seleccionadoLocal;
    });

    [...equipoLocal.options].forEach(option => {
      option.disabled = option.value === seleccionadoVisitante;
    });
  }

  equipoLocal.addEventListener('change', actualizarOpciones);
  equipoVisitante.addEventListener('change', actualizarOpciones);
</script>

<!-- FOOTER SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
