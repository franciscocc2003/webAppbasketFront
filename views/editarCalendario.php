<?php
// ===========================
// editarCalendario.php
// ===========================
include_once('template/header.php');

// Validar que exista el id del juego en la URL
if (!isset($_GET['idJuego'])) {
    echo '<p class="alert alert-warning">No se ha especificado un juego para editar.</p>';
    exit;
}

$id_juego = $_GET['idJuego'];

// Obtener los datos del juego desde la API
$urlJuego = "http://localhost/api/calendario/detalle/$id_juego";
$responseJuego = file_get_contents($urlJuego);
$juego = json_decode($responseJuego, true);

if (!$juego) {
    echo '<p class="alert alert-danger">No se encontró el juego especificado.</p>';
    exit;
}

// Obtener los equipos asociados al torneo del juego
$id_torneo = $_SESSION['id_torneo'];
$urlGrupos = "http://localhost/api/grupos/$id_torneo";
$responseGrupos = file_get_contents($urlGrupos);
$grupos = json_decode($responseGrupos, true) ?? [];

$equipos = [];
foreach ($grupos as $grupo) {
    $idGrupo = $grupo['id_grupo'];
    $urlEquipos = "http://localhost/api/equipos/$idGrupo";
    $responseEquipos = file_get_contents($urlEquipos);
    $equiposGrupo = json_decode($responseEquipos, true) ?? [];
    $equipos = array_merge($equipos, $equiposGrupo);
}
?>
<!-- CONTENIDO -->
<div class="container mt-4">
    <h2><i class="fas fa-calendar-alt"></i> Editar Juego del Calendario</h2>
    <p class="text-muted">
        Modifica los datos del juego y guarda los cambios.
    </p>

    <div class="card mb-4">
        <div class="card-header text-white" style="background-color:rgb(233, 115, 4);">
            <strong>Editar Juego</strong>
        </div>
        <div class="card-body">
            <form id="formEditarJuego">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="equipoLocal">Equipo Local</label>
                        <select class="form-select" id="equipoLocal" name="equipoLocal" required>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?= htmlspecialchars($equipo['id_equipo']) ?>" 
                                    <?= $juego['id_equipo_local'] == $equipo['id_equipo'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($equipo['nombre_equipo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="equipoVisitante">Equipo Visitante</label>
                        <select class="form-select" id="equipoVisitante" name="equipoVisitante" required>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?= htmlspecialchars($equipo['id_equipo']) ?>" 
                                    <?= $juego['id_equipo_visitante'] == $equipo['id_equipo'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($equipo['nombre_equipo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label" for="fechaJuego">Fecha</label>
                        <input type="date" class="form-control" id="fechaJuego" name="fechaJuego" 
                            value="<?= htmlspecialchars($juego['fecha']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="horaJuego">Hora</label>
                        <input type="time" class="form-control" id="horaJuego" name="horaJuego" 
                            value="<?= htmlspecialchars($juego['hora']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="sede">Sede</label>
                        <input type="text" class="form-control" id="sede" name="sede" 
                            value="<?= htmlspecialchars($juego['sede']) ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="categoria">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="1era Fuerza" <?= $juego['categoria'] == '1era Fuerza' ? 'selected' : '' ?>>1era Fuerza</option>
                            <option value="2da Fuerza" <?= $juego['categoria'] == '2da Fuerza' ? 'selected' : '' ?>>2da Fuerza</option>
                            <option value="Libre" <?= $juego['categoria'] == 'Libre' ? 'selected' : '' ?>>Libre</option>
                            <option value="Veteranos" <?= $juego['categoria'] == 'Veteranos' ? 'selected' : '' ?>>Veteranos</option>
                            <option value="Empresarial" <?= $juego['categoria'] == 'Empresarial' ? 'selected' : '' ?>>Empresarial</option>
                            <option value="Infantil" <?= $juego['categoria'] == 'Infantil' ? 'selected' : '' ?>>Infantil</option>
                            <option value="Juvenil" <?= $juego['categoria'] == 'Juvenil' ? 'selected' : '' ?>>Juvenil</option>
                            <option value="MiniBasket" <?= $juego['categoria'] == 'MiniBasket' ? 'selected' : '' ?>>MiniBasket</option>
                            <option value="Femenil" <?= $juego['categoria'] == 'Femenil' ? 'selected' : '' ?>>Femenil</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="tipoJuego">Tipo de Juego</label>
                        <select class="form-select" id="tipoJuego" name="tipoJuego" required>
                            <option value="Rol Regular" <?= $juego['tipo_juego'] == 'Rol Regular' ? 'selected' : '' ?>>Rol Regular</option>
                            <option value="Exhibición" <?= $juego['tipo_juego'] == 'Exhibición' ? 'selected' : '' ?>>Exhibición</option>
                            <option value="Play-off" <?= $juego['tipo_juego'] == 'Play-off' ? 'selected' : '' ?>>Play-off</option>
                            <option value="Semifinal" <?= $juego['tipo_juego'] == 'Semifinal' ? 'selected' : '' ?>>Semifinal</option>
                            <option value="Final" <?= $juego['tipo_juego'] == 'Final' ? 'selected' : '' ?>>Final</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn text-white" style="background-color:rgb(233, 115, 4);">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    document.getElementById('formEditarJuego').addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
            equipo_local: document.getElementById('equipoLocal').value,
            equipo_visitante: document.getElementById('equipoVisitante').value,
            fecha: document.getElementById('fechaJuego').value,
            hora: document.getElementById('horaJuego').value,
            sede: document.getElementById('sede').value,
            categoria: document.getElementById('categoria').value,
            tipo_juego: document.getElementById('tipoJuego').value
        };

        fetch(`http://localhost/api/calendario/editar/${<?= $id_juego ?>}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.message) {
                alert(result.message);
                window.location.href = 'calendario.php';
            } else {
                alert('Error al editar el juego');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<!-- FOOTER -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
