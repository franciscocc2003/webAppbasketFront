<?php
session_start();
require_once '../model/userModel.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function login($email, $password) {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Crear sesión con los datos del usuario
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre_completo'] = $user['nombre_completo'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['usuario'] = $user['usuario'];

            // Redirigir según el rol
            if ($user['rol'] === 'Administrador') {
                header('Location: home.php');
            } elseif ($user['rol'] === 'Organizador') {
                header('Location: home.php');
            }
            exit;
        } else {
            // Usuario o contraseña incorrectos
            header('Location: login.php?error=invalid_credentials');
            exit;
        }
    }
}
