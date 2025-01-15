<?php
// ===========================
// jugadores.php (SUBMÓDULO JUGADORES)
// ===========================
include_once('template/header.php');
?>

<!-- CONTENIDO SUBMÓDULO JUGADORES -->
<div class="container mt-4">
  <h2><i class="fas fa-user-friends"></i> Submódulo Jugadores</h2>
  <p class="text-muted">
    Captura los datos de los jugadores, asociándolos a un equipo.
  </p>

  <!-- Formulario: Registrar Jugador -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Registrar Nuevo Jugador</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="equipo" class="form-label">Equipo</label>
          <select class="form-select" id="equipo" name="equipo" required>
            <option selected disabled>-- Selecciona Equipo --</option>
            <!-- Equipos de tu BD -->
          </select>
        </div>
        <div class="mb-3">
          <label for="nombreJugador" class="form-label">Nombre</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreJugador" 
            name="nombreJugador" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="apellidosJugador" class="form-label">Apellidos</label>
          <input 
            type="text" 
            class="form-control" 
            id="apellidosJugador" 
            name="apellidosJugador" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
          <input 
            type="date" 
            class="form-control" 
            id="fechaNacimiento" 
            name="fechaNacimiento" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="correoJugador" class="form-label">Correo</label>
          <input 
            type="email" 
            class="form-control" 
            id="correoJugador" 
            name="correoJugador"
          >
        </div>
        <div class="mb-3">
          <label for="celularJugador" class="form-label">Celular</label>
          <input 
            type="tel" 
            class="form-control" 
            id="celularJugador" 
            name="celularJugador" 
            pattern="[0-9]{10}"
          >
        </div>
        <div class="mb-3">
          <label for="tipoSangre" class="form-label">Tipo de Sangre</label>
          <input 
            type="text" 
            class="form-control" 
            id="tipoSangre" 
            name="tipoSangre"
          >
        </div>
        <div class="mb-3">
          <label for="contactoEmergencia" class="form-label">Contacto de Emergencia</label>
          <input 
            type="text" 
            class="form-control" 
            id="contactoEmergencia" 
            name="contactoEmergencia"
          >
        </div>
        <div class="mb-3">
          <label for="fotoJugador" class="form-label">Fotografía</label>
          <input 
            type="file" 
            class="form-control" 
            id="fotoJugador" 
            name="fotoJugador" 
            accept="image/*"
          >
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Jugador
        </button>
      </form>
    </div>
  </div>

  <!-- Lista Jugadores -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Jugadores Registrados</strong>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Equipo</th>
            <th>Foto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- BD -->
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- FIN SUBMÓDULO JUGADORES -->

<!-- FOOTER SCRIPTS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
