<?php
include_once('template/header.php');

// Comprobar si hay una sesión activa
if (!isset($_SESSION['id_usuario'])) {
    $torneo = null;
    $logotipo = '';
    $mensaje = "Eres un jugador, esta opción deberia estar disponible pronto.";
} else {
    // Comprobar si el id_torneo está en la sesión
    if (!isset($_SESSION['id_torneo'])) {
        $torneo = null;
        $logotipo = '';
        $mensaje = "No se encontró un torneo seleccionado. Por favor, selecciona un torneo para ver los detalles.";
    } else {
        $id_torneo = $_SESSION['id_torneo'];
        $api_url = "http://localhost/api/torneos/$id_torneo";

        // Intentar obtener los datos del torneo desde la API
        $torneo_data = @file_get_contents($api_url);
        if ($torneo_data === false) {
            $torneo = null;
            $logotipo = '';
            $mensaje = "No se encontró un torneo seleccionado. Por favor, selecciona un torneo para ver los detalles.";
        } else {
            $torneo = json_decode($torneo_data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $torneo = null;
                $logotipo = '';
                $mensaje = "No se encontró un torneo seleccionado. Por favor, selecciona un torneo para ver los detalles.";
            } else {
                // Convertir el logotipo de base64 a una imagen accesible
                $logotipo = $torneo['logotipo'] ? 'data:image/png;base64,' . $torneo['logotipo'] : '';
            }
        }
    }
}
?>

<div class="container mt-4 d-flex justify-content-center">
    <?php if ($torneo): ?>
        <!-- Mostrar detalles del torneo si existe -->
        <div class="card shadow-sm" style="max-width: fit-content; min-width: 300px;">
            <div class="card-header text-center text-white" style="background-color:rgb(233, 115, 4);">
                <h3 class="mb-0">
                    <i class="fas fa-trophy me-2"></i> Torneo: <?php echo htmlspecialchars($torneo['nombre_torneo']); ?>
                </h3>
            </div>
            <div class="card-body">
                <!-- Logotipo centrado -->
                <div class="text-center mb-4">
                    <?php if ($logotipo): ?>
                        <img src="<?php echo $logotipo; ?>" alt="Logotipo del Torneo" class="img-fluid rounded-circle" style="max-width: 150px;">
                    <?php else: ?>
                        <p class="text-muted">Sin logotipo disponible</p>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <!-- Columna izquierda: Detalles del torneo -->
                    <div class="col-md-6 text-center">
                        <h4 class="text-muted">Detalles del Torneo</h4>
                        <p><strong>Sede:</strong> <?php echo htmlspecialchars($torneo['sede']); ?></p>
                        <p><strong>Organizador:</strong> <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?></p>
                        <p><strong>Patrocinadores:</strong> <?php echo htmlspecialchars($torneo['patrocinadores']); ?></p>
                    </div>
                    <!-- Columna derecha: Premios -->
                    <div class="col-md-6 text-center">
                        <h4 class="text-muted">Premios</h4>
                        <p><strong>1er lugar:</strong> <?php echo htmlspecialchars($torneo['premio_1er_lugar']); ?></p>
                        <p><strong>2do lugar:</strong> <?php echo htmlspecialchars($torneo['premio_2do_lugar']); ?></p>
                        <p><strong>3er lugar:</strong> <?php echo htmlspecialchars($torneo['premio_3er_lugar']); ?></p>
                        <p><strong>Otro:</strong> <?php echo htmlspecialchars($torneo['otro_premio']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Mostrar mensaje de advertencia si no hay torneo -->
        <div class="alert alert-warning text-center" role="alert">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (incluye Popper) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<?php
include_once('template/footer.php');
?>
