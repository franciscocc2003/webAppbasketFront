<?php
// listar_torneos.php
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
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h3 class="mb-0">
        <i class="fas fa-trophy me-2"></i> Lista de Torneos
      </h3>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php else: ?>
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Nombre del Torneo</th>
              <th>Logotipo</th>
              <th>Sede</th>
              <th>Patrocinadores</th>
              <th>Premios</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($torneos as $torneo): ?>
              <tr>
                <td><?= htmlspecialchars($torneo['id_torneo']) ?></td>
                <td><?= htmlspecialchars($torneo['nombre_torneo']) ?></td>
                <td>
                  <?php if (!empty($torneo['logotipo'])): ?>
                    <img src="data:image/png;base64,<?= htmlspecialchars($torneo['logotipo']) ?>" alt="Logotipo" class="img-thumbnail" style="max-height: 50px;">
                  <?php else: ?>
                    No disponible
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($torneo['sede']) ?></td>
                <td><?= htmlspecialchars($torneo['patrocinadores']) ?></td>
                <td>
                  <ul>
                    <li><strong>1er Lugar:</strong> <?= htmlspecialchars($torneo['premio_1er_lugar']) ?></li>
                    <li><strong>2do Lugar:</strong> <?= htmlspecialchars($torneo['premio_2do_lugar']) ?></li>
                    <li><strong>3er Lugar:</strong> <?= htmlspecialchars($torneo['premio_3er_lugar']) ?></li>
                    <li><strong>Otro:</strong> <?= htmlspecialchars($torneo['otro_premio']) ?></li>
                  </ul>
                </td>
                <td>
                  <a href="crearTorneo.php?id=<?= htmlspecialchars($torneo['id_torneo']) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include_once('template/footer.php');
?>
