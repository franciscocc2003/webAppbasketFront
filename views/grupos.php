<?php
// ===========================
// grupos.php (SUBMÓDULO GRUPOS)
// ===========================
include_once('template/header.php');

// Asegurarse de que el ID del torneo está en la sesión
if (!isset($_SESSION['id_torneo'])) {
    echo '<p class="alert alert-warning">No se ha seleccionado ningún torneo. Por favor selecciona uno primero.</p>';
    exit;
}

// Obtener el ID del torneo desde la sesión
$id_torneo = $_SESSION['id_torneo'];

// Llamar al endpoint para obtener los grupos
$url = "http://localhost/api/grupos/$id_torneo";
$response = file_get_contents($url);
$grupos = json_decode($response, true);

// Manejar errores de la API
if (empty($grupos)) {
    $error = "No hay grupos disponibles para este torneo.";
}
?>

<div class="container mt-4">
  <h2><i class="fas fa-layer-group"></i> Submódulo Grupos</h2>
  <p class="text-muted">
    Aquí el Organizador crea grupos para el torneo, asignándoles categoría.
  </p>

  <!-- Formulario: Crear Grupo -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Crear un Nuevo Grupo</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST">
        <div class="mb-3">
          <label for="nombreGrupo" class="form-label">Nombre del Grupo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreGrupo" 
            name="nombreGrupo" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="categoria" class="form-label">Categoría</label>
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
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Grupo
        </button>
      </form>
    </div>
  </div>

  <!-- Listado de Grupos -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Listado de Grupos</strong>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php else: ?>
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grupos as $grupo): ?>
              <tr>
                <td><?= htmlspecialchars($grupo['id_grupo']) ?></td>
                <td><?= htmlspecialchars($grupo['nombre_grupo']) ?></td>
                <td><?= htmlspecialchars($grupo['categoria']) ?></td>
                <td>
                  <a href="editarGrupo.php?id=<?= $grupo['id_grupo'] ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- FOOTER (Scripts Bootstrap) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
