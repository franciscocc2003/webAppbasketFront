<?php
// crear_o_editar_torneo.php
include_once('template/header.php');

// Obtener el ID del torneo desde la URL (si existe)
$id_torneo = isset($_GET['id']) ? intval($_GET['id']) : null;

// Verificar si es edición o creación
$is_editing = $id_torneo !== null;

// Variables para precargar datos en caso de edición
$nombre_torneo = $logotipo = $sede = $premio_1er_lugar = $premio_2do_lugar = $premio_3er_lugar = $otro_premio = $organizador_id = $patrocinadores = '';

if ($is_editing) {
    // Llamar a la API para obtener los datos del torneo por ID
    $url = "http://localhost/api/torneos/$id_torneo";
    $response = file_get_contents($url);
    $torneo = json_decode($response, true);

    if ($torneo) {
        // Precargar los datos en las variables
        $nombre_torneo = $torneo['nombre_torneo'];
        $logotipo = $torneo['logotipo']; // Base64 del logotipo
        $sede = $torneo['sede'];
        $premio_1er_lugar = $torneo['premio_1er_lugar'];
        $premio_2do_lugar = $torneo['premio_2do_lugar'];
        $premio_3er_lugar = $torneo['premio_3er_lugar'];
        $otro_premio = $torneo['otro_premio'];
        $patrocinadores = $torneo['patrocinadores'];
        $organizador_id = $torneo['id_organizador'];
    }
}
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <h3 class="mb-0">
        <i class="fas fa-trophy me-2"></i>
        <?= $is_editing ? 'Editar Torneo' : 'Crear Nuevo Torneo' ?>
      </h3>
    </div>
    <div class="card-body">
      <!-- Formulario para crear o editar torneo -->
      <form id="formTorneo">
        <!-- Nombre del torneo -->
        <div class="mb-3">
          <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombre_torneo" 
            name="nombre_torneo" 
            value="<?= htmlspecialchars($nombre_torneo) ?>" 
            placeholder="Nombre del Torneo" 
            required
          >
        </div>

        <!-- Logotipo actual -->
        <?php if ($logotipo): ?>
          <div class="mb-3">
            <label class="form-label">Logotipo Actual</label>
            <div>
              <img src="data:image/png;base64,<?= $logotipo ?>" alt="Logotipo Actual" class="img-thumbnail" style="max-height: 200px;">
            </div>
          </div>
        <?php endif; ?>

        <!-- Cargar nuevo logotipo -->
        <div class="mb-3">
          <label for="logotipo" class="form-label">Cargar Nuevo Logotipo</label>
          <input 
            type="file" 
            class="form-control" 
            id="logotipo" 
            name="logotipo" 
            accept="image/*"
          >
        </div>

        <!-- Sede -->
        <div class="mb-3">
          <label for="sede" class="form-label">Sede</label>
          <input 
            type="text" 
            class="form-control" 
            id="sede" 
            name="sede" 
            value="<?= htmlspecialchars($sede) ?>" 
            placeholder="Lugar de la Sede" 
            required
          >
        </div>

        <!-- Patrocinadores -->
        <div class="mb-3">
          <label for="patrocinadores" class="form-label">Patrocinadores</label>
          <textarea 
            class="form-control" 
            id="patrocinadores" 
            name="patrocinadores" 
            placeholder="Lista de patrocinadores separados por comas"><?= htmlspecialchars($patrocinadores) ?></textarea>
        </div>

        <!-- Premios -->
        <div class="mb-3">
          <label for="premio_1er_lugar" class="form-label">Premio 1er Lugar</label>
          <input 
            type="text" 
            class="form-control" 
            id="premio_1er_lugar" 
            name="premio_1er_lugar" 
            value="<?= htmlspecialchars($premio_1er_lugar) ?>" 
            placeholder="Premio para el 1er lugar" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="premio_2do_lugar" class="form-label">Premio 2do Lugar</label>
          <input 
            type="text" 
            class="form-control" 
            id="premio_2do_lugar" 
            name="premio_2do_lugar" 
            value="<?= htmlspecialchars($premio_2do_lugar) ?>" 
            placeholder="Premio para el 2do lugar"
          >
        </div>
        <div class="mb-3">
          <label for="premio_3er_lugar" class="form-label">Premio 3er Lugar</label>
          <input 
            type="text" 
            class="form-control" 
            id="premio_3er_lugar" 
            name="premio_3er_lugar" 
            value="<?= htmlspecialchars($premio_3er_lugar) ?>" 
            placeholder="Premio para el 3er lugar"
          >
        </div>
        <div class="mb-3">
          <label for="otro_premio" class="form-label">Otro Premio</label>
          <input 
            type="text" 
            class="form-control" 
            id="otro_premio" 
            name="otro_premio" 
            value="<?= htmlspecialchars($otro_premio) ?>" 
            placeholder="Otro Premio"
          >
        </div>

        <!-- Selección del organizador -->
        <div class="mb-3">
          <label for="organizador_id" class="form-label">Organizador</label>
          <select class="form-select" id="organizador_id" name="organizador_id" required>
            <option value="" disabled <?= $organizador_id === '' ? 'selected' : '' ?>>Selecciona un organizador</option>
            <?php
            // Llamar a la API para obtener los organizadores
            $response = file_get_contents('http://localhost/api/usuarios');
            $usuarios = json_decode($response, true);

            foreach ($usuarios as $usuario) {
                if ($usuario['rol'] === 'Organizador') {
                    $selected = $organizador_id == $usuario['id_usuario'] ? 'selected' : '';
                    echo "<option value=\"{$usuario['usuario']}\" $selected>{$usuario['nombre_completo']}</option>";
                }
            }
            ?>
          </select>
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn text-white" style="background-color:rgb(233, 115, 4);">
          <?= $is_editing ? 'Actualizar Torneo' : 'Crear Torneo' ?>
        </button>
      </form>
    </div>
  </div>
</div>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<script>
  document.getElementById('formTorneo').addEventListener('submit', function (e) {
    e.preventDefault();

    const logotipoInput = document.getElementById("logotipo");
    const logotipoFile = logotipoInput.files[0];
    const reader = new FileReader();

    reader.onload = function () {
      const logotipoBase64 = logotipoFile ? reader.result.split(",")[1] : "<?= $logotipo ?>";

      const data = {
        nombre_torneo: document.getElementById("nombre_torneo").value.trim(),
        logotipo: logotipoBase64, // Enviar en Base64
        sede: document.getElementById("sede").value.trim(),
        patrocinadores: document.getElementById("patrocinadores").value.trim(),
        premio_1er_lugar: document.getElementById("premio_1er_lugar").value.trim(),
        premio_2do_lugar: document.getElementById("premio_2do_lugar").value.trim(),
        premio_3er_lugar: document.getElementById("premio_3er_lugar").value.trim(),
        otro_premio: document.getElementById("otro_premio").value.trim(),
        usuario: document.getElementById("organizador_id").value.trim()
      };

      // Construcción de la URL y método
      const baseUrl = 'http://localhost/api/torneos';
      const isEditing = <?= json_encode($is_editing) ?>;
      const url = isEditing ? `${baseUrl}/<?= $id_torneo ?>` : baseUrl;
      const method = isEditing ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error en la solicitud. Código de estado: ' + response.status);
          }
          return response.json();
        })
        .then(result => {
          alert(`Torneo ${isEditing ? 'actualizado' : 'creado'} con éxito`);
          window.location.href = 'crearTorneo.php';
        })
        .catch(error => alert('Error: ' + error.message));
    };

    if (logotipoFile) {
      reader.readAsDataURL(logotipoFile);
    } else {
      reader.onload(); // Llamar directamente si no hay archivo nuevo
    }
  });
</script>


<?php
include_once('template/footer.php');
?>
