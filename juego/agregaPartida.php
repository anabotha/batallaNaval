<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => true, "mensaje" => "Método no permitido. Use POST."]); 
    exit;
}

$raw = file_get_contents('php://input');
if (!$raw) {
    echo json_encode(["error" => true, "mensaje" => "No se recibió body JSON"]);
    exit;
}

$data = json_decode($raw, true);
if ($data === null) {
    echo json_encode(["error" => true, "mensaje" => "JSON inválido"]);
    exit;
}

$usuario = $data['usuario'] ?? null;
$ganoJugador = !empty($data['ganoJugador']);
$ganoComputadora = !empty($data['ganoComputadora']);
$tiempo = $data['tiempo'] ?? null;

$db = new mysqli("localhost", "root", "", "batallanaval");
$db->set_charset("utf8mb4");
if ($db->connect_error) {
    echo json_encode(["error" => true, "mensaje" => "Error de conexión a la BD"]);
    exit;
}

$id_jugador = null;
if ($usuario) {
    $stmt = $db->prepare("SELECT id_usuario FROM Usuarios WHERE nickname = ? LIMIT 1");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $id_jugador = (int)$row['id_usuario'];
    }
    $stmt->close();
}

// INSERCIÓN
if ($id_jugador === null) {

    // usuario desconocido
    $stmt = $db->prepare("
        INSERT INTO Partida (id_jugador, ganador_jugador, gano_computadora, duracion_partida, fecha_partida)
        VALUES (NULL, NULL, ?, ?, CURDATE())
    ");
    $stmt->bind_param('is', $ganoComputadora, $tiempo);

} else {

    if ($ganoJugador) {
        // ganó el usuario
        $stmt = $db->prepare("
            INSERT INTO Partida (id_jugador, ganador_jugador, gano_computadora, duracion_partida, fecha_partida)
            VALUES (?, 1, ?, ?, CURDATE())
        ");
        $stmt->bind_param('iis', $id_jugador, $ganoComputadora, $tiempo);

    } else {
        // perdió o no ganó
        $stmt = $db->prepare("
            INSERT INTO Partida (id_jugador, ganador_jugador, gano_computadora, duracion_partida, fecha_partida)
            VALUES (?, NULL, ?, ?, CURDATE())
        ");
        $stmt->bind_param('iis', $id_jugador, $ganoComputadora, $tiempo);
    }
}

// ejecutar
$stmt->execute();
$insertId = $stmt->insert_id;
$stmt->close();
$db->close();

echo json_encode([
    "error" => false,
    "mensaje" => "Partida guardada",
    "id" => $insertId
]);
