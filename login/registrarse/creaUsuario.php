<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_POST['obj'])) {
    responderJson(["error" => true, "mensaje" => "Faltan datos"]);
}

$data = json_decode($_POST['obj']);
if (!$data) {
    responderJson(["error" => true, "mensaje" => "JSON inválido"]);
}

$nick  = trim($data->nickname);
$email = trim($data->email);
$contra = trim($data->password);

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responderJson(["error" => true, "mensaje" => "Email inválido"]);
}

// Validar password mínima
if (strlen($contra) < 6) {
    responderJson(["error" => true, "mensaje" => "Contraseña demasiado corta"]);
}

// Conexión única
$db = new mysqli("localhost", "root", "", "batallanaval");
$db->set_charset("utf8mb4");

if ($db->connect_error) {
    responderJson(["error" => true, "mensaje" => "Error en la BD"]);
}

// Verificar existencia de nickname y email
$nombreExiste = existeNombre($db, $nick);
$emailExiste  = existeEmail($db, $email);

if ($nombreExiste || $emailExiste) {
    responderJson([
        "nuevo" => false,
        "nombreExiste" => $nombreExiste,
        "emailExiste" => $emailExiste,
        "explicacion" => $nombreExiste ? "Nickname ya registrado" : "Email ya registrado"
    ]);
}

// Crear usuario
if (!creaUsuario($db, $nick, $email, $contra)) {
    responderJson(["error" => true, "mensaje" => "No se pudo crear el usuario"]);
}

responderJson([
    "nuevo" => true,
    "nombreExiste" => false,
    "emailExiste" => false,
    "nickname" => $nick
]);



// =======================
// FUNCIONES
// =======================

function responderJson($obj) {
    echo json_encode($obj, JSON_UNESCAPED_UNICODE);
    exit;
}

function existeNombre($db, $nick) {
    $stmt = $db->prepare("SELECT 1 FROM Usuarios WHERE nickname = ? LIMIT 1");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function existeEmail($db, $email) {
    $stmt = $db->prepare("SELECT 1 FROM Usuarios WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function creaUsuario($db, $nick, $email, $contra) {

    // Insert usuario
    $stmt = $db->prepare("INSERT INTO Usuarios (nickname, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nick, $email);

    if (!$stmt->execute()) return false;

    // Insert contraseña hash
    $hash = password_hash($contra, PASSWORD_DEFAULT);
    $stmt2 = $db->prepare("INSERT INTO contraseñas (nickname, contraseñas) VALUES (?, ?)");
    $stmt2->bind_param("ss", $nick, $hash);

    return $stmt2->execute();
}
