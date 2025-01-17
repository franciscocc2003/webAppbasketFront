<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Organizador</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            width: 100%;
            max-width: 400px;
            margin: auto;
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
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card">
            <img src="../balon.png" alt="Baloncesto" class="basketball-image">
            <h1>Organizador</h1>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Usuario o contraseña incorrectos</div>
            <?php endif; ?>
            <form action="rutas.php?route=login" method="POST">
                <input type="hidden" name="role" value="organizer">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="text" name="email" class="form-control" placeholder="Ingrese su correo" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="btn btn-orange w-100">Ingresar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>