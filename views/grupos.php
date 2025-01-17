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
  <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
    <strong>Crear un Nuevo Grupo</strong>
  </div>
  <div class="card-body">
    <form id="formGrupo" class="d-flex flex-column align-items-center">
      <div class="d-flex justify-content-center gap-3 flex-wrap" style="max-width: 500px;">
        <!-- Campo Nombre del Grupo -->
        <div class="form-group flex-grow-1">
          <label for="nombreGrupo" class="form-label text-center">Nombre del Grupo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreGrupo" 
            name="nombreGrupo" 
            required
            placeholder="Ingrese nombre"
          >
        </div>
        <!-- Campo Categoría -->
        <div class="form-group flex-grow-1">
          <label for="categoria" class="form-label text-center">Categoría</label>
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
      </div>
      <!-- Botón Guardar Grupo -->
      <div class="mt-4">
        <button type="submit" class="btn text-white" style="background-color:rgb(233, 115, 4);">
          <i class="fas fa-save"></i> Guardar Grupo
        </button>
      </div>
    </form>
  </div>
</div>

  <!-- Listado de Grupos -->
  <div class="card">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <strong>Listado de Grupos</strong>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php else: ?>
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr class="text-center">
              <th >Nombre</th>
              <th>Categoría</th>   
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grupos as $grupo): ?>
              <tr>         
                <td><?= htmlspecialchars($grupo['nombre_grupo']) ?></td>
                <td><?= htmlspecialchars($grupo['categoria']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- SCRIPT: Enviar formulario a la API -->
<script>
  document.getElementById('formGrupo').addEventListener('submit', function (e) {
    e.preventDefault();

    const idTorneo = <?= json_encode($id_torneo) ?>;
    const nombreGrupo = document.getElementById('nombreGrupo').value;
    const categoria = document.getElementById('categoria').value;

    const data = {
      nombre_grupo: nombreGrupo,
      categoria: categoria
    };

    fetch(`http://localhost/api/grupos/asignacion/${idTorneo}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      if (response.ok) {
        alert('Grupo creado con éxito');
        window.location.reload();
      } else {
        response.json().then(err => {
          alert(`Error: ${err.message}`);
        });
      }
    })
    .catch(error => {
      console.error('Error al crear grupo:', error);
      alert('Error al crear el grupo.');
    });
  });
</script>

<!-- FOOTER (Scripts Bootstrap) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
<?php
include_once('template/footer.php');
?>
