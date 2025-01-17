<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Baloncesto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #fff7e6;
            font-family: 'Bebas Neue', cursive;
        }
        .card {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .btn {
            border-radius: 30px;
            font-size: 1.2rem;
        }
        .btn-orange {
            background-color: #f57c00;
            color: white;
        }
        .btn-orange:hover {
            background-color: #ef6c00;
        }
        .basketball-image {
            width: 120px;
            height: 120px;
            display: block;
            margin: 0 auto 20px;
        }
        h1 {
            font-size: 2.5rem;
            color: #f57c00;
        }
        p {
            font-size: 1rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card">
            <img src="../balon.png" alt="Baloncesto" class="basketball-image">
            <h1>Sistema de Baloncesto</h1>
            <p>Selecciona tu acceso para continuar:</p>
            <div class="d-grid gap-3 mt-4">
                <a href="login_admin.php" class="btn btn-orange">Administrador</a>
                <a href="login_organizer.php" class="btn btn-outline-warning">Organizador</a>
                <a href="usuarioJugador.php" class="btn btn-light">Usuario</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
