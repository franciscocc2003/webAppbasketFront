<?php
// session.php
session_start();

// Sesión estática: Usuario Administrador
$_SESSION['id_usuario'] = 1; // ID del usuario
$_SESSION['rol'] = 'Administrador'; // Rol del usuario
$_SESSION['usuario'] = 'pedrito';
?>
