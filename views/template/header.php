<?php
session_start();

// HOLA COMENTARIO
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet">
 <link 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" 
    rel="stylesheet"
  >
  <title>Usuarios - Básquetbol</title>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-warning">
  <div class="container-fluid">
    <a class="navbar-brand text-dark" href="index.php">
      <i class="fas fa-basketball-ball me-2"></i>
      Torneo de Básquetbol
    </a>
    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#navbarNav" 
      aria-controls="navbarNav" 
      aria-expanded="false" 
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <!-- Opción Inicio -->
        <li class="nav-item">
          <a class="nav-link text-dark" href="index.php">
            <i class="fas fa-home"></i> Inicio
          </a>
        </li>
        
        <!-- Submenú Usuarios -->
        <li class="nav-item dropdown">
          <a 
            class="nav-link dropdown-toggle text-dark" 
            href="#" 
            id="navbarDropdownUsuarios" 
            role="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            <i class="fas fa-users"></i> Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownUsuarios">
            <li>
              <a class="dropdown-item" href="usuarios.php">
                <i class="fas fa-user-cog"></i> Organizadores 
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="aggPerfil.php">
                <i class="fas fa-user-plus"></i> Agregar Organizador
              </a>
            </li>
          </ul>
        </li>

        <!-- Submenú Torneos -->
        <li class="nav-item dropdown">
          <a 
            class="nav-link dropdown-toggle text-dark" 
            href="#" 
            id="navbarDropdownTorneo" 
            role="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            <i class="fas fa-trophy"></i> Torneo
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownTorneo">
            <li>
              <a class="dropdown-item" href="crearTorneo.php">
                <i class="fa fa-plus-square"></i> Crear Torneo
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="grupos.php">
                <i class="fas fa-layer-group"></i> Submódulo Grupos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="equipos.php">
                <i class="fas fa-users"></i> Submódulo Equipos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="jugadores.php">
                <i class="fas fa-user-friends"></i> Submódulo Jugadores
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="calendario.php">
                <i class="fas fa-calendar-alt"></i> Submódulo Calendario
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="resultados.php">
                <i class="fas fa-clipboard-check"></i> Submódulo Captura de Resultados
              </a>
            </li>
          </ul>
        </li>

        <!-- Estadísticas -->
        <li class="nav-item">
          <a class="nav-link text-dark" href="estadisticasJugadores.php">
            <i class="fas fa-chart-bar"></i> Estadísticas de Jugadores
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="estadisticasEquipo.php">
            <i class="fas fa-users-cog"></i> Estadísticas del Equipo
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="usuarioJugador.php">
            <i class="fas fa-user"></i> Usuario Jugador
          </a>
        </li>

        <!-- Selección de Torneo -->
        <li class="nav-item ms-auto">
          <a class="nav-link text-dark" href="seleccionarTorneo.php">
            <i class="fas fa-list"></i> Torneo Actual: 
            <strong>
              <?= isset($_SESSION['nombre_torneo']) ? htmlspecialchars($_SESSION['nombre_torneo']) : 'Ninguno' ?>
            </strong>
          </a>
        </li>

        
      </ul>
    </div>
  </div>
</nav>
