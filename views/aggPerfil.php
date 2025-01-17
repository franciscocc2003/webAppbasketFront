<?php
// usuarios_nuevo_perfil.php
include_once('template/header.php');

// Manejo del envío del formulario
$alerta = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    // Validar los campos
    if (empty($nombre) || empty($correo) || empty($usuario) || empty($password) || empty($tipo)) {
        $alerta = '<div class="alert alert-danger">Por favor, completa todos los campos.</div>';
    } else {
        // Preparar los datos para la API
        $data = [
            'nombre_completo' => $nombre,
            'correo' => $correo,
            'usuario' => $usuario,
            'password' => $password,
            'rol' => $tipo
        ];

        // Llamar a la API
        $url = 'http://localhost/api/usuarios';
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === FALSE) {
            $alerta = '<div class="alert alert-danger">Hubo un error al crear el perfil. Intenta nuevamente.</div>';
        } else {
            $result = json_decode($response, true);
            if (isset($result['message']) && $result['message'] === 'Usuario creado con éxito') {
                $alerta = '<div class="alert alert-success">Perfil creado con éxito.</div>';
            } else {
                $error = $result['message'] ?? 'Hubo un error desconocido.';
                $alerta = '<div class="alert alert-danger">Error: ' . htmlspecialchars($error) . '</div>';
            }
        }
    }
}
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header text-white"style="background-color:rgb(233, 115, 4);">
      <h3 class="mb-0">
        <i class="fas fa-user-plus me-2"></i> Agregar Organizador
      </h3>
    </div>
    <div class="card-body">
      <!-- Alertas -->
      <?php if (!empty($alerta)) echo $alerta; ?>

      <!-- Formulario para agregar nuevo perfil -->
      <form method="POST" action="">
        <!-- Nombre completo -->
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre Completo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombre" 
            name="nombre" 
            placeholder="Ingresa el nombre completo" 
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
            placeholder="Ingresa el correo electrónico" 
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
            placeholder="Ingresa el nombre de usuario" 
            required
          >
        </div>
        
        <!-- Contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input 
            type="password" 
            class="form-control" 
            id="password" 
            name="password" 
            placeholder="Ingresa una contraseña segura" 
            required
          >
        </div>

        <!-- Tipo (Administrador u Organizador) -->
        <div class="mb-3">
          <input 
            type="hidden" 
            class="form-control" 
            id="tipo" 
            name="tipo" 
            value="Organizador"   
          >
        </div>
        </div>

        <!-- Botón para Enviar -->
        <button type="submit" class="btn text-white" style="background-color:rgb(233, 115, 4);">
          <i class="fas fa-save"></i> Guardar Perfil
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS (incluye Popper) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<?php
include_once('template/footer.php');
?>
