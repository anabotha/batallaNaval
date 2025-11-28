<?php
header('Content-Type: application/json; charset=utf-8');

$usuario = $_GET['usuario'] ?? "";

if ($usuario === "") {
    echo json_encode(["error" => true, "mensaje" => "Falta usuario"]);
    exit;
}

$respuesta = obtenerTop3PartidasGanadas($usuario);

echo json_encode($respuesta === false ? false : $respuesta);
exit;

function obtenerTop3PartidasGanadas($nickname) {

    $db = new mysqli("localhost", "root", "", "batallanaval");
    $db->set_charset("utf8mb4");

    if ($db->connect_error) return false;

    // Buscar ID
    $stmt = $db->prepare("
        SELECT id_usuario 
        FROM Usuarios 
        WHERE nickname = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows !== 1) {
        return false; // usuario no encontrado
    }

    $id_usuario = (int)$res->fetch_assoc()['id_usuario'];
    $stmt->close();

    // Top 3 ganadas más rápidas
    $stmt = $db->prepare("
        SELECT 
            P.id_partida,
            P.duracion_partida,
            P.fecha_partida,
            U.nickname
        FROM Partida P
        JOIN Usuarios U ON U.id_usuario = P.id_jugador
        WHERE P.id_jugador = ? 
          AND P.ganador_jugador = 1
        ORDER BY P.duracion_partida ASC
        LIMIT 3
    ");

    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        return false;
    }

    $partidas = $res->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $db->close();

    return $partidas;
}



?>
