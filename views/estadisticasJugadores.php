<?php
// estadisticas_de_jugadores.php
include_once('template/header.php');



?>



<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h3 class="mb-0">
        <i class="fas fa-chart-bar me-2"></i> Estadísticas de Jugadores
      </h3>
    </div>
    <div class="card-body">
      <p class="text-muted">
        Este módulo muestra el <strong>histórico de estadísticas</strong> de cada jugador: 
        puntos totales, tiros de 3 anotados y faltas acumuladas durante todo el torneo.
      </p>
      
      <!-- Tabla con estadísticas de jugadores -->
      <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>Foto</th>
              <th>Jugador</th>
              <th>Puntos Totales</th>
              <th>Tiros de 3</th>
              <th>Faltas Cometidas</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($estadisticas)): ?>
              <?php foreach ($estadisticas as $jugador): ?>
                <tr>
                  <!-- Foto del jugador (si existe) -->
                  <td class="text-center">
                    <?php if (!empty($jugador['foto'])): ?>
                      <img 
                        src="imagenes_jugadores/<?php echo $jugador['foto']; ?>" 
                        alt="Foto de <?php echo $jugador['nombre_jugador']; ?>" 
                        style="width: 50px; height: 50px; object-fit: cover;"
                      >
                    <?php else: ?>
                      <i class="fas fa-user fa-2x text-secondary"></i>
                    <?php endif; ?>
                  </td>
                  <td><?php echo $jugador['nombre_jugador']; ?></td>
                  <td><?php echo $jugador['total_puntos']; ?></td>
                  <td><?php echo $jugador['total_triples']; ?></td>
                  <td><?php echo $jugador['total_faltas']; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">
                  No hay registros de estadísticas para mostrar.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Botón para volver al inicio (o a otro módulo) -->
      <div class="mt-3">
        <a href="index.php" class="btn btn-dark">
          <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </a>
      </div>
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
