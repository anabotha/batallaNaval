<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['nick']) || !isset($_POST['password'])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

$nick = trim($_POST['nick']);
$password = trim($_POST['password']);

buscaUsuario($nick, $password);


function verificarContraseña($password, $nick) {
    $db = new mysqli("localhost", "root", "", "batallanaval");
    $db->set_charset("utf8mb4");

    $stmt = $db->prepare("SELECT contraseñas FROM contraseñas WHERE nickname = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 0) return false;

    $hash = $result->fetch_assoc()['contraseñas'];
    $stmt->close();
    $db->close();

    return password_verify($password, $hash);
}


function buscaUsuario($nick, $password) {
    $db = new mysqli("localhost", "root", "", "batallanaval");
    $db->set_charset("utf8mb4");

    $stmt = $db->prepare("SELECT * FROM Usuarios WHERE nickname = ? LIMIT 1");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $result = $stmt->get_result();

    $json = new stdClass();

    if ($result->num_rows === 1) {

        if (verificarContraseña($password, $nick)) {

            $user = $result->fetch_object();

            $_SESSION["user"] = $user->nickname;  // ✔ forma segura

            $json->existe = true;
            $json->contra = true;
            $json->nickname = $user->nickname;
            $json->enUso = false;

        } else {
            $json->existe = true;
            $json->contra = false;
            $json->enUso = false;
        }

    } else {
        $json->existe = false;
        $json->enUso = false;
    }

    echo json_encode($json);
    $stmt->close();
    $db->close();
}
?>
