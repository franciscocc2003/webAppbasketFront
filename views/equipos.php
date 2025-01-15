<?php
// ===========================
// equipos.php (SUBMÓDULO EQUIPOS)
// ===========================
include_once('template/header.php');
?>


<!-- CONTENIDO SUBMÓDULO EQUIPOS -->
<div class="container mt-4">
  <h2><i class="fas fa-users"></i> Submódulo Equipos</h2>
  <p class="text-muted">
    Registra, edita o consulta los equipos participantes.  
  </p>

  <!-- Formulario: Registrar Equipo -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Registrar Nuevo Equipo</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombreEquipo" class="form-label">Nombre del Equipo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreEquipo" 
            name="nombreEquipo" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="logoEquipo" class="form-label">Logo del Equipo (opcional)</label>
          <input 
            type="file" 
            class="form-control" 
            id="logoEquipo" 
            name="logoEquipo" 
            accept="image/*"
          >
        </div>
        <div class="mb-3">
          <label for="responsable" class="form-label">Responsable (Capitán)</label>
          <input 
            type="text" 
            class="form-control" 
            id="responsable" 
            name="responsable" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="correoCapitan" class="form-label">Correo del Capitán</label>
          <input 
            type="email" 
            class="form-control" 
            id="correoCapitan" 
            name="correoCapitan" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="celularCapitan" class="form-label">Celular del Capitán</label>
          <input 
            type="tel" 
            class="form-control" 
            id="celularCapitan" 
            name="celularCapitan" 
            pattern="[0-9]{10}" 
            required
          >
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Equipo
        </button>
      </form>
    </div>
  </div>

  <!-- Lista de Equipos Registrados -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Equipos Registrados</strong>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Equipo</th>
            <th>Logo</th>
            <th>Responsable</th>
            <th>Contacto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- BD -->
          <tr>
            <td>1</td>
            <td>Tigres</td>
            <td><img src="img/logo_tigres.png" width="50"></td>
            <td>Juan Pérez</td>
            <td>correo@ejemplo.com / 6621234567</td>
            <td>
              <button class="btn btn-sm btn-success">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- FIN SUBMÓDULO EQUIPOS -->

<!-- FOOTER SCRIPTS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
