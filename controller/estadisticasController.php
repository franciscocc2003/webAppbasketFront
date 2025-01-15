<?php
// controllers/EstadisticasController.php

class EstadisticasController {

    private $estadisticasModel;

    public function __construct($estadisticasModel) {
        $this->estadisticasModel = $estadisticasModel;
    }

    /**
     * Método para mostrar la vista con las estadísticas de jugadores.
     */
    public function index($idTorneo = null) {
        // 1. Obtener los datos del modelo
        $estadisticas = $this->estadisticasModel->getEstadisticasJugadores($idTorneo);

        // 2. Incluir la vista y pasarle los datos
        //    Ajusta la ruta según tu estructura de carpetas
        include_once './views/estadisticasJugadores.php';
    }
}

class EstadisticasEquipoController {
    private $model;

    public function __construct($estadisticasEquipoModel) {
        $this->model = $estadisticasEquipoModel;
    }

    /**
     * Muestra la vista con el Standing general o por grupo/categoría.
     */
    public function index($idTorneo, $categoria = null, $grupo = null) {
        // 1. Obtener los datos del modelo
        $estadisticas = $this->model->getStandingEquipos($idTorneo, $categoria, $grupo);

        // 2. Cargar la vista correspondiente
        //    Ajusta la ruta a tu estructura de carpetas:
        include_once './views/estadisticasEquipo.php';
    }
}

?>