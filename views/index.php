<?php
  include_once('template/header.php');
?>

<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h3 class="mb-0">
        <i class="fas fa-users me-2"></i> Usuarios
      </h3>
    </div>
    <div class="card-body">
      <p class="text-muted">
        ¡Bienvenido(a) al módulo de <strong>Usuarios</strong> del 
        <span class="text-dark">Torneo de Básquetbol</span>!
      </p>
      <p class="text-muted mb-0">
        Desde aquí podrás gestionar la información de cada usuario: 
        entrenadores, jugadores y staff, todo dentro de la temática del baloncesto.
      </p>
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
