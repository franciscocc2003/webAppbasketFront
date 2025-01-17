<?php
// editar_usuario.php
include_once('template/header.php');

// Obtener el usuario de la URL
if (!isset($_GET['usuario'])) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Usuario no especificado.</div></div>";
    include_once('template/footer.php');
    exit;
}
$usuario = $_GET['usuario'];

// Obtener datos del usuario desde la API
$apiUrl = "http://localhost/api/usuarios/$usuario";
$response = file_get_contents($apiUrl);
if ($response === false) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Error al obtener los datos del usuario.</div></div>";
    include_once('template/footer.php');
    exit;
}
$datosUsuario = json_decode($response, true);
if (!$datosUsuario) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Usuario no encontrado.</div></div>";
    include_once('template/footer.php');
    exit;
}
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <h3 class="mb-0">
        <i class="fas fa-edit me-2"></i> Editar Usuario: <?php echo htmlspecialchars($datosUsuario['nombre_completo']); ?>
      </h3>
    </div>
    <div class="card-body">
      <!-- Formulario para editar usuario -->
      <form id="formEditarUsuario">
        <!-- Nombre completo -->
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre Completo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombre" 
            name="nombre" 
            value="<?php echo htmlspecialchars($datosUsuario['nombre_completo']); ?>" 
            required
          >
        </div>

        <!-- Correo -->
        <div class="mb-3">
          <label for="correo" class="form-label">Correo Electrónico</label>
          <input 
            type="email" 
            class="form-control" 
            id="correo" 
            name="correo" 
            value="<?php echo htmlspecialchars($datosUsuario['correo']); ?>" 
            required
          >
        </div>

        <!-- Usuario -->
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <input 
            type="text" 
            class="form-control" 
            id="usuario" 
            name="usuario" 
            value="<?php echo htmlspecialchars($datosUsuario['usuario']); ?>" 
            readonly
          >
        </div>

        <!-- Rol -->
        <div class="mb-3">
        <input 
            type="hidden" 
            class="form-control" 
            id="rol" 
            name="rol" 
            value="<?php echo htmlspecialchars($datosUsuario['rol']); ?>" 
            readonly
          >
        </div>

        <!-- Botón para Guardar Cambios -->
        <button type="submit" class="btn text-white" style="background-color:rgb(233, 115, 4);">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </form>
    </div>
  </div>
</div>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<script>
  document.getElementById('formEditarUsuario').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener los valores del formulario
    const nombre = document.getElementById('nombre').value;
    const correo = document.getElementById('correo').value;
    const usuario = document.getElementById('usuario').value;
    const rol = document.getElementById('rol').value;

    // Preparar los datos para la API
    const data = {
      nombre_completo: nombre,
      correo: correo,
      usuario: usuario,
      rol: rol
    };

    // Llamar a la API para actualizar
    fetch(`http://localhost/api/usuarios/${usuario}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => {
        if (response.ok) {
          return response.json();
        }
        throw new Error('Error al actualizar el usuario');
      })
      .then(result => {
        alert('Usuario actualizado con éxito');
        window.location.href = 'usuarios.php'; // Redirigir a la lista de usuarios
      })
      .catch(error => {
        alert('Error: ' + error.message);
      });
  });
</script>

<?php
include_once('template/footer.php');
?>
