<?php
// models/EstadisticasModel.php

class EstadisticasModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene la lista de jugadores con sus estadísticas acumuladas
     * (puntos, triples y faltas) para un torneo dado.
     *
     * @param int $idTorneo  Identificador del torneo (opcional si manejas múltiples torneos)
     * @return array         Arreglo con las estadísticas de cada jugador
     */
    public function getEstadisticasJugadores($idTorneo = null) {
        // Suponiendo que tienes:
        // - Tabla 'jugadores' (id_jugador, nombre_jugador, foto, etc.)
        // - Tabla 'estadisticas_partidos' (id_jugador, puntos_anotados, tiros_3_anotados, faltas_cometidas, id_partido)
        // - Tabla 'partidos' (id_partido, id_torneo, etc.)

        // Si tu estructura es distinta, ajusta la consulta.
        $sql = "SELECT 
                    j.id_jugador,
                    j.nombre_jugador,
                    j.foto,
                    SUM(e.puntos_anotados) AS total_puntos,
                    SUM(e.tiros_3_anotados) AS total_triples,
                    SUM(e.faltas_cometidas) AS total_faltas
                FROM jugadores j
                INNER JOIN estadisticas_partidos e 
                    ON j.id_jugador = e.id_jugador
                INNER JOIN partidos p
                    ON e.id_partido = p.id_partido";

        // Si manejas múltiples torneos, filtra por idTorneo
        if ($idTorneo) {
            $sql .= " WHERE p.id_torneo = :idTorneo";
        }

        // Agrupamos por jugador
        $sql .= " GROUP BY j.id_jugador, j.nombre_jugador, j.foto
                  ORDER BY total_puntos DESC"; // Por ejemplo, ordenando por puntos desc

        $stmt = $this->pdo->prepare($sql);

        if ($idTorneo) {
            $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

class EstadisticasEquipoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene el standing de los equipos para un torneo, 
     * con opción de filtrar por categoría o grupo.
     *
     * @param int    $idTorneo      ID del torneo
     * @param string $categoria     Categoría (opcional)
     * @param string $grupo         Grupo (opcional)
     * @return array                Datos de cada equipo con sus estadísticas
     */
    public function getStandingEquipos($idTorneo, $categoria = null, $grupo = null) {
        /*
          Suponemos la tabla `partidos` tiene:
           - id_partido
           - id_torneo
           - id_equipo_local
           - id_equipo_visitante
           - puntos_local
           - puntos_visitante
           - ganador_por_default (null si no aplica)

          Y la tabla `equipos`:
           - id_equipo
           - nombre_equipo
           - categoria
           - grupo
        */

        // Creamos subconsultas para PF, PC, G, P, PD y PTS (puntaje).
        // Por ejemplo, G y P se basan en si un equipo anotó más o menos que el rival.
        // PD (perdido por default) se basaría en `ganador_por_default`.
        // Ajusta las reglas de puntaje (PTS) según tu reglamento.
        
        // Nota: A veces se separa la lógica para local y visitante. Aquí se puede unificar
        // en una sola consulta usando UNION o vistas. Para simplificar, usaremos un approach
        // con SUM e IF.
        
        $sql = "
        SELECT 
            e.id_equipo,
            e.nombre_equipo,
            e.logo,
            e.categoria,
            e.grupo,
            -- Puntos a favor
            COALESCE(SUM(
                CASE 
                  WHEN p.id_equipo_local = e.id_equipo THEN p.puntos_local
                  WHEN p.id_equipo_visitante = e.id_equipo THEN p.puntos_visitante
                END
            ), 0) AS PF,
            -- Puntos en contra
            COALESCE(SUM(
                CASE 
                  WHEN p.id_equipo_local = e.id_equipo THEN p.puntos_visitante
                  WHEN p.id_equipo_visitante = e.id_equipo THEN p.puntos_local
                END
            ), 0) AS PC,
            -- Partidos Ganados
            SUM(
                CASE
                  WHEN p.id_equipo_local = e.id_equipo AND p.puntos_local > p.puntos_visitante THEN 1
                  WHEN p.id_equipo_visitante = e.id_equipo AND p.puntos_visitante > p.puntos_local THEN 1
                  ELSE 0
                END
            ) AS G,
            -- Partidos Perdidos
            SUM(
                CASE
                  WHEN p.id_equipo_local = e.id_equipo AND p.puntos_local < p.puntos_visitante THEN 1
                  WHEN p.id_equipo_visitante = e.id_equipo AND p.puntos_visitante < p.puntos_local THEN 1
                  ELSE 0
                END
            ) AS P,
            -- Partidos perdidos por default
            SUM(
                CASE
                  WHEN p.ganador_por_default IS NOT NULL 
                       AND (p.id_equipo_local = e.id_equipo OR p.id_equipo_visitante = e.id_equipo)
                       AND p.ganador_por_default != e.id_equipo
                  THEN 1
                  ELSE 0
                END
            ) AS PD,
            -- Puntaje (ejemplo: 2 pts por victoria, 1 por derrota)
            (2 * SUM(
                CASE
                  WHEN (p.id_equipo_local = e.id_equipo AND p.puntos_local > p.puntos_visitante) 
                       OR (p.id_equipo_visitante = e.id_equipo AND p.puntos_visitante > p.puntos_local)
                  THEN 1
                  ELSE 0
                END
            )) 
            + (1 * SUM(
                CASE
                  WHEN (p.id_equipo_local = e.id_equipo AND p.puntos_local < p.puntos_visitante)
                       OR (p.id_equipo_visitante = e.id_equipo AND p.puntos_visitante < p.puntos_local)
                  THEN 1
                  ELSE 0
                END
            )) AS PTS
        FROM equipos e
        LEFT JOIN partidos p 
            ON (p.id_equipo_local = e.id_equipo OR p.id_equipo_visitante = e.id_equipo)
            AND p.id_torneo = :idTorneo
        WHERE 1 = 1
        ";

        // Filtros opcionales por categoría y grupo
        if ($categoria) {
            $sql .= " AND e.categoria = :categoria ";
        }
        if ($grupo) {
            $sql .= " AND e.grupo = :grupo ";
        }

        $sql .= "
        GROUP BY 
            e.id_equipo, 
            e.nombre_equipo, 
            e.logo,
            e.categoria,
            e.grupo
        ";

        // Ordenar por puntaje DESC, y si quieres, por diferencia de puntos, etc.
        // Ejemplo: PTS DESC, (PF - PC) DESC
        $sql .= "
        ORDER BY 
            PTS DESC, 
            (SUM(
                CASE 
                  WHEN p.id_equipo_local = e.id_equipo THEN p.puntos_local
                  WHEN p.id_equipo_visitante = e.id_equipo THEN p.puntos_visitante
                END
            ) - 
            SUM(
                CASE 
                  WHEN p.id_equipo_local = e.id_equipo THEN p.puntos_visitante
                  WHEN p.id_equipo_visitante = e.id_equipo THEN p.puntos_local
                END
            )) DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);

        if ($categoria) {
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        }
        if ($grupo) {
            $stmt->bindParam(':grupo', $grupo, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ahora calculamos DIF manualmente (PF - PC) en PHP
        foreach ($result as $key => $equipo) {
            $pf = $equipo['PF'];
            $pc = $equipo['PC'];
            $result[$key]['DIF'] = $pf - $pc;
        }

        return $result;
    }}



    ?>