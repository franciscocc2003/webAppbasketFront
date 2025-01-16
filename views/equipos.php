<?php
// ===========================
// equipos.php (SUBMÓDULO EQUIPOS)
// ===========================
include_once('template/header.php');

// Obtener el ID del torneo desde la sesión
if (!isset($_SESSION['id_torneo'])) {
    echo '<p class="alert alert-warning">No se ha seleccionado ningún torneo. Por favor selecciona uno primero.</p>';
    exit;
}
$id_torneo = $_SESSION['id_torneo'];

// Llamar al endpoint para obtener los grupos del torneo
$urlGrupos = "http://localhost/api/grupos/$id_torneo";
$responseGrupos = file_get_contents($urlGrupos);
$grupos = json_decode($responseGrupos, true);

// Manejar error si no hay grupos disponibles
if (empty($grupos)) {
    $error = "No hay grupos disponibles para este torneo.";
}

// Obtener equipos para cada grupo
$equiposPorGrupo = [];
if (!isset($error)) {
    foreach ($grupos as $grupo) {
        $urlEquipos = "http://localhost/api/equipos/{$grupo['id_grupo']}";
        $responseEquipos = file_get_contents($urlEquipos);
        $equiposPorGrupo[$grupo['id_grupo']] = json_decode($responseEquipos, true);
    }
}
?>

<div class="container mt-4">
  <h2><i class="fas fa-users"></i> Submódulo Equipos</h2>
  <p class="text-muted">Registra, edita o consulta los equipos participantes.</p>

  <!-- Formulario: Registrar Equipo -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Registrar Nuevo Equipo</strong>
    </div>
    <div class="card-body">
      <form id="formEquipo">
        <div class="mb-3">
          <label for="nombreEquipo" class="form-label">Nombre del Equipo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreEquipo" 
            name="nombreEquipo" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="grupo" class="form-label">Grupo</label>
          <select class="form-select" id="grupo" name="grupo" required>
            <option selected disabled>-- Selecciona un grupo --</option>
            <?php foreach ($grupos as $grupo): ?>
              <option value="<?= $grupo['id_grupo'] ?>">
                <?= htmlspecialchars($grupo['nombre_grupo']) ?> (<?= htmlspecialchars($grupo['categoria']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="logoEquipo" class="form-label">Logo del Equipo (opcional)</label>
          <input 
            type="file" 
            class="form-control" 
            id="logoEquipo" 
            name="logoEquipo" 
            accept="image/*"
          >
        </div>
        <div class="mb-3">
          <label for="nombreCapitan" class="form-label">Nombre del Capitán</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreCapitan" 
            name="nombreCapitan" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="correoCapitan" class="form-label">Correo del Capitán</label>
          <input 
            type="email" 
            class="form-control" 
            id="correoCapitan" 
            name="correoCapitan" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="celularCapitan" class="form-label">Celular del Capitán</label>
          <input 
            type="tel" 
            class="form-control" 
            id="celularCapitan" 
            name="celularCapitan" 
            pattern="[0-9]{10}" 
            required
          >
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Equipo
        </button>
      </form>
    </div>
  </div>

  <!-- Lista de Equipos Registrados -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Equipos Registrados</strong>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php else: ?>
        <?php foreach ($grupos as $grupo): ?>
          <h5><?= htmlspecialchars($grupo['nombre_grupo']) ?> (<?= htmlspecialchars($grupo['categoria']) ?>)</h5>
          <table class="table table-bordered mb-4">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Equipo</th>
                <th>Logo</th>
                <th>Capitán</th>
                <th>Contacto</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($equiposPorGrupo[$grupo['id_grupo']])): ?>
                <?php foreach ($equiposPorGrupo[$grupo['id_grupo']] as $equipo): ?>
                  <tr>
                    <td><?= htmlspecialchars($equipo['id_equipo']) ?></td>
                    <td><?= htmlspecialchars($equipo['nombre_equipo']) ?></td>
                    <td>
                      <?php if (!empty($equipo['logotipo'])): ?>
                        <img src="data:image/png;base64,<?= $equipo['logotipo'] ?>" width="50">
                      <?php else: ?>
                        Sin logo
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($equipo['nombre_capitan']) ?></td>
                    <td><?= htmlspecialchars($equipo['correo_capitan']) ?> / <?= htmlspecialchars($equipo['celular_capitan']) ?></td>
                    <td>
                      <button class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">No hay equipos en este grupo</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  document.getElementById('formEquipo').addEventListener('submit', function (e) {
    e.preventDefault();

    const grupo = document.getElementById('grupo').value;
    const nombreEquipo = document.getElementById('nombreEquipo').value;
    const nombreCapitan = document.getElementById('nombreCapitan').value;
    const correoCapitan = document.getElementById('correoCapitan').value;
    const celularCapitan = document.getElementById('celularCapitan').value;

    const logoInput = document.getElementById('logoEquipo');
    const logoFile = logoInput.files[0];

    const reader = new FileReader();
    reader.onload = function () {
      const logoBase64 = logoFile ? reader.result.split(',')[1] : null;

      const data = {
        nombre_equipo: nombreEquipo,
        logotipo: logoBase64,
        id_grupo: grupo,
        nombre_capitan: nombreCapitan,
        correo_capitan: correoCapitan,
        celular_capitan: celularCapitan
      };

      fetch(`http://localhost/api/equipos/${grupo}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(result => {
          alert('Equipo registrado con éxito');
          location.reload();
        })
        .catch(error => console.error('Error:', error));
    };

    if (logoFile) {
      reader.readAsDataURL(logoFile);
    } else {
      reader.onload();
    }
  });
</script>

<?php include_once('template/footer.php'); ?>
