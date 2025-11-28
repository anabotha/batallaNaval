<?php

function obtenerTop5PartidasGanadas() {

    $db = new mysqli("localhost", "root", "", "batallanaval");
    $db->set_charset("utf8mb4");

    if ($db->connect_error) return false;

    $stmt = $db->prepare("
        SELECT 
            P.id_partida,
            P.duracion_partida,
            P.fecha_partida,
            U.nickname
        FROM Partida P
        JOIN Usuarios U ON U.id_usuario = P.id_jugador
        WHERE P.ganador_jugador = 1
        ORDER BY P.duracion_partida ASC
        LIMIT 5
    ");

    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) return false;

    $partidas = $res->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $db->close();

    return $partidas;
}
?>
