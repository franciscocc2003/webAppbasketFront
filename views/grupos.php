<?php
// ===========================
// grupos.php (SUBMÓDULO GRUPOS)
// ===========================

include_once('template/header.php');
?>

<!-- CONTENIDO DE SUBMÓDULO GRUPOS -->
<div class="container mt-4">
  <h2><i class="fas fa-layer-group"></i> Submódulo Grupos</h2>
  <p class="text-muted">
    Aquí el Organizador crea grupos para el torneo, asignándoles categoría.
  </p>

  <!-- Formulario: Crear Grupo -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-dark">
      <strong>Crear un Nuevo Grupo</strong>
    </div>
    <div class="card-body">
      <form action="#" method="POST">
        <div class="mb-3">
          <label for="nombreGrupo" class="form-label">Nombre del Grupo</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombreGrupo" 
            name="nombreGrupo" 
            required
          >
        </div>
        <div class="mb-3">
          <label for="categoria" class="form-label">Categoría</label>
          <select class="form-select" id="categoria" name="categoria" required>
            <option selected disabled>-- Selecciona --</option>
            <option value="1era Fuerza">1era Fuerza</option>
            <option value="2da Fuerza">2da Fuerza</option>
            <option value="Libre">Libre</option>
            <option value="Veteranos">Veteranos</option>
            <option value="Empresarial">Empresarial</option>
            <option value="Infantil">Infantil</option>
            <option value="Juvenil">Juvenil</option>
            <option value="MiniBasket">MiniBasket</option>
            <option value="Femenil">Femenil</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Grupo
        </button>
      </form>
    </div>
  </div>

  <!-- Listado de Grupos -->
  <div class="card">
    <div class="card-header bg-warning text-dark">
      <strong>Listado de Grupos</strong>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Ejemplo de fila. Ajusta con tu BD. -->
          <tr>
            <td>1</td>
            <td>Grupo A</td>
            <td>1era Fuerza</td>
            <td>
              <button class="btn btn-sm btn-success">
                <i class="fas fa-edit"></i> Editar
              </button>
              <button class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i> Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- FIN CONTENIDO GRUPOS -->

<!-- FOOTER (Scripts Bootstrap) -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
</body>
</html>
