<?php
// usuarios.php
include_once('template/header.php');

// URL de la API
$apiUrl = 'http://localhost/api/usuarios';

// Inicializar cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($curl);
curl_close($curl);

// Decodificar la respuesta de la API
$usuarios = json_decode($response, true);

?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h3 class="mb-0">
        <i class="fas fa-users me-2"></i> Lista de Usuarios
      </h3>
    </div>
    <div class="card-body">
      <!-- Alerta en caso de error -->
      <?php if (isset($usuarios['message'])): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($usuarios['message']) ?>
        </div>
      <?php endif; ?>

      <!-- Tabla de usuarios -->
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Correo Electrónico</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!isset($usuarios['message']) && !empty($usuarios)): ?>
            <?php 
            $index = 1;
            foreach ($usuarios as $usuario): 
              if ($usuario['rol'] !== 'Administrador'): // Filtrar por rol
            ?>
              <tr>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($usuario['nombre_completo']) ?></td>
                <td><?= htmlspecialchars($usuario['correo']) ?></td>
                <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                <td><?= htmlspecialchars($usuario['rol']) ?></td>
                <td>
                  <a href="editar_usuario.php?usuario=<?= urlencode($usuario['usuario']) ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                  <form method="POST" action="eliminar_usuario.php" style="display:inline-block;">
                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                      <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            <?php 
              endif;
            endforeach; 
            ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No hay usuarios registrados</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<?php
include_once('template/footer.php');
?>
