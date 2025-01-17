<?php
require_once '../config/dataBase.php';
require_once '../controller/authController.php';

// Crear instancia de conexión a la base de datos
$db = (new Database())->connect();
$authController = new AuthController($db);

// Rutas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['route']) && $_GET['route'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authController->login($email, $password);
} else {
    // Cargar las vistas según el rol
    if (isset($_GET['role']) && $_GET['role'] === 'admin') {
        require 'views/login_admin.php';
    } elseif (isset($_GET['role']) && $_GET['role'] === 'organizer') {
        require 'views/login_organizer.php';
    } else {
        echo "Ruta no encontrada.";
    }
}
?>
