<?php
// seleccionar_torneo.php
include_once('template/header.php');

// Obtener el rol del usuario desde la sesión
$rol = $_SESSION['rol'];
$usuario = $_SESSION['usuario'];

// Determinar la URL de la API según el rol del usuario
$url = $rol === 'Administrador' 
    ? 'http://localhost/api/torneos' 
    : "http://localhost/api/torneos/{$usuario}";

// Llamar a la API para obtener los torneos disponibles
$response = file_get_contents($url);
$torneos = json_decode($response, true);

// Manejar el caso en el que no haya torneos disponibles
if (empty($torneos)) {
    $error = "No hay torneos disponibles para tu usuario.";
}

// Procesar selección de torneo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_torneo = intval($_POST['id_torneo']);

    // Buscar el nombre del torneo seleccionado
    $nombre_torneo = $_POST['nombre_torneo'];

    // Guardar en la sesión
    $_SESSION['id_torneo'] = $id_torneo;
    $_SESSION['nombre_torneo'] = $nombre_torneo;

    // Redirigir al inicio o a otra página
    echo '<script>window.location.href = "index.php";</script>';
    exit;
}
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h3 class="mb-0">
        <i class="fas fa-trophy me-2"></i> Seleccionar Torneo
      </h3>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php else: ?>
        <form method="POST">
          <div class="mb-3">
            <label for="id_torneo" class="form-label">Torneos Disponibles</label>
            <select class="form-select" id="id_torneo" name="id_torneo" required>
              <?php foreach ($torneos as $torneo): ?>
                <option value="<?= $torneo['id_torneo'] ?>" 
                  data-nombre="<?= htmlspecialchars($torneo['nombre_torneo']) ?>"
                  <?= (isset($_SESSION['id_torneo']) && $_SESSION['id_torneo'] == $torneo['id_torneo']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($torneo['nombre_torneo']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <input type="hidden" id="nombre_torneo" name="nombre_torneo" value="">
          <button type="submit" class="btn btn-dark">
            <i class="fas fa-check"></i> Seleccionar Torneo
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  document.getElementById('id_torneo').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('nombre_torneo').value = selectedOption.getAttribute('data-nombre');
  });

  // Preseleccionar el nombre al cargar la página
  document.getElementById('id_torneo').dispatchEvent(new Event('change'));
</script>


<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<?php
include_once('template/footer.php');
?>
