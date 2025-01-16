<?php
// ===========================
// jugadores.php (SUBMÓDULO JUGADORES)
// ===========================
include_once('template/header.php');

// Validar que exista el id_torneo en la sesión
if (!isset($_SESSION['id_torneo'])) {
    echo '<p class="alert alert-warning">No se ha seleccionado ningún torneo. Por favor selecciona uno primero.</p>';
    exit;
}

// Obtener el ID del torneo desde la sesión
$id_torneo = $_SESSION['id_torneo'];

// Obtener los grupos y equipos asociados al torneo
$urlGrupos = "http://localhost/api/grupos/$id_torneo";
$responseGrupos = file_get_contents($urlGrupos);
$grupos = json_decode($responseGrupos, true) ?? [];

// Obtener jugadores separados por equipos y grupos
$equiposPorGrupo = [];
$jugadoresPorGrupo = [];
foreach ($grupos as $grupo) {
    $idGrupo = $grupo['id_grupo'];
    $urlEquipos = "http://localhost/api/equipos/$idGrupo";
    $responseEquipos = file_get_contents($urlEquipos);
    $equipos = json_decode($responseEquipos, true) ?? [];

    if (empty($equipos)) {
        $equiposPorGrupo[$grupo['nombre_grupo']] = [];
        continue;
    }

    foreach ($equipos as $equipo) {
        $equiposPorGrupo[$grupo['nombre_grupo']][] = $equipo;

        $idEquipo = $equipo['id_equipo'];
        $urlJugadores = "http://localhost/api/jugadores/$idEquipo";
        $responseJugadores = file_get_contents($urlJugadores);
        $jugadores = json_decode($responseJugadores, true) ?? [];

        if (empty($jugadores)) {
            $jugadoresPorGrupo[$grupo['nombre_grupo']][$equipo['nombre_equipo']] = [];
        } else {
            $jugadoresPorGrupo[$grupo['nombre_grupo']][$equipo['nombre_equipo']] = $jugadores;
        }
    }
}
?>

<!-- CONTENIDO SUBMÓDULO JUGADORES -->
<div class="container mt-4">
  <h2><i class="fas fa-user-friends"></i> Submódulo Jugadores</h2>
  <p class="text-muted">
    Captura los datos de los jugadores, asociándolos a un equipo.
  </p>

  <!-- Formulario: Registrar Jugador -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark text-center">
        <h4>Registrar Nuevo Jugador</h4>
    </div>
    <div class="card-body p-4">
        <form id="formJugador">
            <div class="row g-4">
                <!-- Equipo -->
                <div class="col-md-12">
                    <label for="equipo" class="form-label">Equipo</label>
                    <select class="form-select" id="equipo" name="equipo" required>
                        <option selected disabled>-- Selecciona Equipo --</option>
                        <?php foreach ($equiposPorGrupo as $grupo => $equipos): ?>
                            <?php if (empty($equipos)): ?>
                                <optgroup label="<?= htmlspecialchars($grupo) ?>">No hay equipos disponibles</optgroup>
                            <?php else: ?>
                                <optgroup label="<?= htmlspecialchars($grupo) ?>">
                                    <?php foreach ($equipos as $equipo): ?>
                                        <option value="<?= $equipo['id_equipo'] ?>">
                                            <?= htmlspecialchars($equipo['nombre_equipo']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nombre y Apellidos -->
                <div class="col-md-6">
                    <label for="nombreJugador" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreJugador" name="nombreJugador" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidosJugador" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidosJugador" name="apellidosJugador" required>
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="col-md-6">
                    <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>
                <div class="col-md-6">
                    <label for="correoJugador" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correoJugador" name="correoJugador">
                </div>

                <!-- Celular y Tipo de Sangre -->
                <div class="col-md-4">
                    <label for="celularJugador" class="form-label">Celular</label>
                    <input type="tel" class="form-control" id="celularJugador" name="celularJugador" pattern="[0-9]{10}">
                </div>
                <div class="col-md-4">
                    <label for="contactoEmergencia" class="form-label">Contacto de Emergencia</label>
                    <input type="text" class="form-control" id="contactoEmergencia" name="contactoEmergencia">
                </div>
                <div class="col-md-4">
                    <label for="tipoSangre" class="form-label">Tipo de Sangre</label>
                    <select class="form-select" id="tipoSangre" name="tipoSangre">
                        <option selected disabled>-- Selecciona Tipo de Sangre --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                
                <!-- Fotografía -->
                <div class="col-md-12">
                    <label for="fotoJugador" class="form-label">Fotografía</label>
                    <input type="file" class="form-control" id="fotoJugador" name="fotoJugador" accept="image/*">
                </div>
            </div>

            <!-- Botón de Guardar -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar Jugador
                </button>
            </div>
        </form>
    </div>
  </div>

  <!-- Lista Jugadores -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Jugadores Registrados</strong>
    </div>
    <div class="card-body">
      <?php if (empty($grupos)): ?>
        <p class="alert alert-warning">No hay grupos disponibles para este torneo.</p>
      <?php else: ?>
        <?php foreach ($jugadoresPorGrupo as $grupo => $equipos): ?>
          <h4><?= htmlspecialchars($grupo) ?></h4>
          <?php if (empty($equipos)): ?>
            <p class="alert alert-warning">No hay equipos en este grupo.</p>
          <?php else: ?>
            <?php foreach ($equipos as $equipo => $jugadores): ?>
              <h5><?= htmlspecialchars($equipo) ?></h5>
              <?php if (empty($jugadores)): ?>
                <p class="alert alert-warning">No hay jugadores en este equipo.</p>
              <?php else: ?>
                <table class="table table-bordered">
                  <thead class="table-dark">
                    <tr>
                      <th>#</th>
                      <th>Nombre Completo</th>
                      <th>Fecha de Nacimiento</th>
                      <th>Correo</th>
                      <th>Celular</th>
                      <th>Tipo de Sangre</th>
                      <th>Contacto de Emergencia</th>
                      <th>Foto</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($jugadores as $index => $jugador): ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($jugador['nombre'] . ' ' . $jugador['apellidos']) ?></td>
                        <td><?= htmlspecialchars($jugador['fecha_nacimiento']) ?></td>
                        <td><?= htmlspecialchars($jugador['correo']) ?></td>
                        <td><?= htmlspecialchars($jugador['celular']) ?></td>
                        <td><?= htmlspecialchars($jugador['tipo_sangre']) ?></td>
                        <td><?= htmlspecialchars($jugador['contacto_emergencia']) ?></td>
                        <td>
                          <?php if (!empty($jugador['fotografia'])): ?>
                            <img src="data:image/jpeg;base64,<?= htmlspecialchars($jugador['fotografia']) ?>" width="50">
                          <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- SCRIPT: Enviar formulario -->
<script>
  document.getElementById('formJugador').addEventListener('submit', function (e) {
    e.preventDefault();

    const idEquipo = document.getElementById('equipo').value;
    const fotoInput = document.getElementById('fotoJugador').files[0];
    const reader = new FileReader();

    reader.onload = function () {
      const data = {
        nombre: document.getElementById('nombreJugador').value,
        apellidos: document.getElementById('apellidosJugador').value,
        fecha_nacimiento: document.getElementById('fechaNacimiento').value,
        correo: document.getElementById('correoJugador').value,
        celular: document.getElementById('celularJugador').value,
        tipo_sangre: document.getElementById('tipoSangre').value,
        contacto_emergencia: document.getElementById('contactoEmergencia').value,
        fotografia: fotoInput ? reader.result.split(',')[1] : null
      };

      fetch(`http://localhost/api/jugadores/${idEquipo}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
        .then(response => {
          if (response.ok) {
            alert('Jugador registrado con éxito');
            window.location.reload();
          } else {
            response.json().then(err => alert(`Error: ${err.message}`));
          }
        })
        .catch(error => console.error('Error al registrar jugador:', error));
    };

    if (fotoInput) {
      reader.readAsDataURL(fotoInput);
    } else {
      reader.onload();
    }
  });
</script>

<!-- FOOTER SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
