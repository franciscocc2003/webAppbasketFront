<?php
// views/estadisticas_del_equipo.php
include_once('template/header.php');
?>



<div class="container mt-4">
  <h3 class="mb-4">
    <i class="fas fa-users-cog me-2"></i> Estadísticas del Equipo
  </h3>

  <!-- Ejemplo: formulario para filtrar por categoría o grupo -->
  <form method="GET" class="row mb-3">
    <!-- ID del Torneo (oculto o en un select si se requieren varios torneos) -->
    <input type="hidden" name="action" value="estadisticasEquipo"> 
    <input type="hidden" name="torneo_id" value="1"> <!-- Ajusta el ID real -->

    <div class="col-md-4 mb-2">
      <label for="categoria" class="form-label">Categoría:</label>
      <select class="form-select" name="categoria" id="categoria">
        <option value="">-- Todas --</option>
        <option value="Varonil">Varonil</option>
        <option value="Femenil">Femenil</option>
      </select>
    </div>
    <div class="col-md-4 mb-2">
      <label for="grupo" class="form-label">Grupo:</label>
      <select class="form-select" name="grupo" id="grupo">
        <option value="">-- Todos --</option>
        <option value="Grupo A">Grupo A</option>
        <option value="Grupo B">Grupo B</option>
      </select>
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" class="btn btn-dark">
        <i class="fas fa-filter"></i> Filtrar
      </button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Equipo</th>
          <th>Categoría</th>
          <th>Grupo</th>
          <th>G</th>
          <th>P</th>
          <th>PD</th>
          <th>PF</th>
          <th>PC</th>
          <th>DIF</th>
          <th>PTS</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($estadisticas)): ?>
          <?php 
          $posicion = 1;
          foreach ($estadisticas as $equipo):
          ?>
            <tr>
              <td><?php echo $posicion++; ?></td>
              <td>
                <?php if(!empty($equipo['logo'])): ?>
                  <img 
                    src="logos/<?php echo $equipo['logo']; ?>" 
                    alt="Logo <?php echo $equipo['nombre_equipo']; ?>" 
                    style="width: 30px; height: 30px; object-fit: cover; margin-right:5px;"
                  >
                <?php endif; ?>
                <?php echo $equipo['nombre_equipo']; ?>
              </td>
              <td><?php echo $equipo['categoria'] ?: '-'; ?></td>
              <td><?php echo $equipo['grupo'] ?: '-'; ?></td>
              <td><?php echo $equipo['G']; ?></td>
              <td><?php echo $equipo['P']; ?></td>
              <td><?php echo $equipo['PD']; ?></td>
              <td><?php echo $equipo['PF']; ?></td>
              <td><?php echo $equipo['PC']; ?></td>
              <td>
                <?php 
                  $dif = $equipo['DIF']; 
                  $color = ($dif >= 0) ? 'green' : 'red';
                  echo "<span style='color: $color;'>$dif</span>";
                ?>
              </td>
              <td><strong><?php echo $equipo['PTS']; ?></strong></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="11" class="text-center">No hay registros de equipos para mostrar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    <a href="index.php" class="btn btn-dark">
      <i class="fas fa-arrow-left"></i> Regresar al Inicio
    </a>
  </div>
</div>

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<?php
include_once('template/footer.php');
?>
