<?php
// usuario_jugador.php
include_once('template/header.php'); 
// Aquí podrías cargar controladores o modelos para obtener
// la lista de torneos, standings, equipos, etc.
?>



<div class="container mt-4">

  <!-- SECCIÓN 1: Seleccionar Torneo -->
  <div class="card shadow-sm mb-4">
    <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
      <h4 class="mb-0">
        <i class="fas fa-basketball-ball me-2"></i> Selecciona tu Torneo
      </h4>
    </div>
    <div class="card-body">
      <form method="GET" action="usuario_jugador.php">
        <!-- 
          Supongamos que $torneos es un array con los torneos disponibles.
          Por ejemplo:
          $torneos = [
            ["id"=>1, "nombre"=>"Torneo Primavera 2025"],
            ["id"=>2, "nombre"=>"Torneo Verano 2025"]
          ];
        -->
        <div class="mb-3">
          <label for="torneo" class="form-label">Torneo:</label>
          <select 
            class="form-select" 
            id="torneo" 
            name="torneo_id" 
            required
            onchange="this.form.submit()"
          >
            <option value="" disabled selected>-- Elige un Torneo --</option>
            <?php
            // Ejemplo de llenado del select con datos
            // foreach ($torneos as $torneo) {
            //   echo '<option value="'.$torneo['id'].'">'.$torneo['nombre'].'</option>';
            // }
            ?>
            <!-- Valor estático de ejemplo: -->
            <option value="1">Torneo Primavera 2025</option>
            <option value="2">Torneo Verano 2025</option>
          </select>
          
        </div>
        <a href="home.php" class="btn text-white" style="background-color:rgb(233, 115, 4);">
       <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </a>
      </form>
    </div>
  </div>

  <!-- SECCIÓN 2: Standing General del Torneo -->
  <?php if (isset($_GET['torneo_id'])): ?>
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">
          <i class="fas fa-list-ol me-2"></i> Standing General
        </h4>
      </div>
      <div class="card-body">
        <!-- 
          Aquí mostrarias la tabla con la posición de cada equipo.
          Asumamos que $equipos es un array con los datos:
          [
            ["id"=>10, "nombre"=>"Tigres", "logo"=>"logo_tigres.png",
             "ganados"=>5, "perdidos"=>2, "pf"=>420, "pc"=>380, "puntos"=>12],
            ...
          ]
        -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">Posición</th>
                <th scope="col">Equipo</th>
                <th scope="col">G</th>
                <th scope="col">P</th>
                <th scope="col">Puntos a Favor</th>
                <th scope="col">Puntos en Contra</th>
                <th scope="col">Dif. de Puntos</th>
                <th scope="col">Puntaje</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Ejemplo estático:
              // for ($i=1; $i<=5; $i++) {
              //   echo "
              //     <tr onclick='mostrarEquipo($i)' style='cursor: pointer;'>
              //       <td>$i</td>
              //       <td>Equipo $i</td>
              //       <td>".rand(1,10)."</td>
              //       <td>".rand(1,10)."</td>
              //       <td>".rand(100,500)."</td>
              //       <td>".rand(100,500)."</td>
              //       <td>".rand(-50,50)."</td>
              //       <td>".rand(2,14)."</td>
              //     </tr>
              //   ";
              // }
              ?>
              <tr onclick="mostrarEquipo(10)" style="cursor: pointer;">
                <td>1</td>
                <td>Tigres</td>
                <td>5</td>
                <td>2</td>
                <td>420</td>
                <td>380</td>
                <td>+40</td>
                <td>12</td>
              </tr>
              <tr onclick="mostrarEquipo(11)" style="cursor: pointer;">
                <td>2</td>
                <td>Águilas</td>
                <td>4</td>
                <td>3</td>
                <td>410</td>
                <td>400</td>
                <td>+10</td>
                <td>11</td>
              </tr>
              <!-- ... -->
            </tbody>
          </table>
        </div>
        <small class="text-muted">
          *Haz clic en un equipo para ver más detalles.
        </small>
      </div>
    </div>

    <!-- SECCIÓN 3: Información del Equipo Seleccionado -->
    <!-- 
      La idea es que, al hacer clic en un equipo dentro de la tabla anterior,
      dispares alguna función (AJAX, redirección, etc.) que cargue los datos
      del equipo en la siguiente sección.
    -->
    <div id="infoEquipo" class="card shadow-sm mb-4" style="display: none;">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">
          <i class="fas fa-users me-2"></i> Información del Equipo
        </h4>
      </div>
      <div class="card-body">
        <!-- 
          Ejemplo de estructura. Después, rellenas con datos reales.
          Aquí se mostrarían los datos del equipo seleccionado:
          - Nombre, logo, ganados, perdidos, PF, PC, DIF y Puntaje
        -->
        <div class="row mb-3">
          <div class="col-md-2 d-flex align-items-center">
            <img 
              id="logoEquipo" 
              src="ruta_logo.png" 
              alt="Logo del Equipo" 
              class="img-fluid rounded"
            >
          </div>
          <div class="col-md-10">
            <h5 id="nombreEquipo">Nombre del Equipo</h5>
            <p id="estadisticasEquipo" class="mb-1">
              G: <span id="equipoGanados">-</span> | 
              P: <span id="equipoPerdidos">-</span> |
              PF: <span id="equipoPF">-</span> |
              PC: <span id="equipoPC">-</span> |
              DIF: <span id="equipoDif">-</span> |
              Puntos: <span id="equipoPuntos">-</span>
            </p>
          </div>
        </div>
        
        <!-- Tabla de jugadores del equipo -->
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th>Foto</th>
                <th>Nombre Completo</th>
                <th>Puntos Anotados</th>
                <th>Tiros de 3</th>
                <th>Faltas</th>
              </tr>
            </thead>
            <tbody id="tablaJugadores">
              <!-- Rellenar con datos de cada jugador -->
              <!-- 
                Ejemplo:
                <tr>
                  <td><img src="foto_jugador.jpg" width="50" height="50"></td>
                  <td>Juan Pérez</td>
                  <td>120</td>
                  <td>25</td>
                  <td>10</td>
                </tr>
              -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- SECCIÓN 4: Rol de Juegos (Actual e Histórico) -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">
          <i class="fas fa-calendar-alt me-2"></i> Rol de Juegos
        </h4>
      </div>
      <div class="card-body">
        <!-- Navegación para ver semana actual / histórico -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button 
              class="nav-link active" 
              id="pills-actual-tab" 
              data-bs-toggle="pill" 
              data-bs-target="#pills-actual" 
              type="button" 
              role="tab" 
              aria-controls="pills-actual" 
              aria-selected="true"
            >
              Semana Actual
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button 
              class="nav-link" 
              id="pills-historico-tab" 
              data-bs-toggle="pill" 
              data-bs-target="#pills-historico" 
              type="button" 
              role="tab" 
              aria-controls="pills-historico" 
              aria-selected="false"
            >
              Histórico
            </button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <!-- Semana Actual -->
          <div 
            class="tab-pane fade show active" 
            id="pills-actual" 
            role="tabpanel" 
            aria-labelledby="pills-actual-tab"
          >
            <!-- Aquí muestras la tabla de partidos para la semana actual -->
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead class="table-dark">
                  <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Lugar</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Rellenar dinámicamente -->
                  <tr>
                    <td>08/01/2025</td>
                    <td>19:00</td>
                    <td>Tigres</td>
                    <td>Águilas</td>
                    <td>Gimnasio A</td>
                  </tr>
                  <!-- ... -->
                </tbody>
              </table>
            </div>
          </div>
          <!-- Histórico -->
          <div 
            class="tab-pane fade" 
            id="pills-historico" 
            role="tabpanel" 
            aria-labelledby="pills-historico-tab"
          >
            <!-- Tabla para semanas anteriores -->
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead class="table-dark">
                  <tr>
                    <th>Semana</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Local</th>
                    <th>Visitante</th>
                    <th>Lugar</th>
                    <th>Resultado</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Ejemplo de datos de semanas anteriores -->
                  <tr>
                    <td>Semana 1</td>
                    <td>01/01/2025</td>
                    <td>18:00</td>
                    <td>Tigres</td>
                    <td>Águilas</td>
                    <td>Gimnasio B</td>
                    <td>80 - 75</td>
                  </tr>
                  <!-- ... -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Botón para Imprimir en PDF -->
        <a 
          href="generar_pdf_rol.php?torneo_id=<?php echo $_GET['torneo_id']; ?>" 
          class="btn btn-dark" 
          target="_blank"
        >
          <i class="fas fa-file-pdf"></i> Imprimir Rol en PDF
        </a>
      </div>
    </div>

  <?php else: ?>
    <!-- Si no se ha seleccionado torneo, mostrar un aviso -->
    <div class="alert alert-info">
      <i class="fas fa-info-circle"></i> Selecciona un torneo para ver la información.
    </div>
  <?php endif; ?>

</div> <!-- /container -->

<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<script>
  // Ejemplo simple para mostrar/ocultar la info de un equipo
  // En la práctica, podrías usar AJAX para cargar datos dinámicamente.
  function mostrarEquipo(equipoId) {
    // Aquí harías una solicitud (AJAX o window.location) para cargar los datos del equipoId
    // Como demo, solo lo hacemos visible:
    document.getElementById('infoEquipo').style.display = 'block';
  }
</script>

<?php
include_once('template/footer.php');
?>
