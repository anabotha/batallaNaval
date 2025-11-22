<?php

if (isset($_POST['nick']) && isset($_POST['password'])) {

    $nick = trim($_POST['nick']);
    $password = trim($_POST['password']);

    if (!cookieEsIgualA("user", $nick)) {
        buscaUsuario($nick, $password);
    } else {
        echo json_encode([
            "existe" => true,
            "enUso" => true
        ]);
    }
}

function setCookiePHP($nombre, $valor, $dias = 7) {
    $tiempoExpiracion = time() + ($dias * 86400);
    setcookie($nombre, $valor, $tiempoExpiracion, "/");
}

function getCookiePHP($nombre) {
    return $_COOKIE[$nombre] ?? null;
}

function cookieEsIgualA($nombre, $valorEsperado) {
    return isset($_COOKIE[$nombre]) && $_COOKIE[$nombre] === $valorEsperado;
}

function verificarContraseña($password, $nick) {
    $db = new mysqli("localhost", "root","", "batallanaval");
    $db->set_charset("utf8mb4");

    $stmt = $db->prepare("SELECT contraseñas FROM contraseñas WHERE nickname = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 0) return false;

    $hash = $result->fetch_assoc()['contraseñas'];

    return password_verify($password, $hash);
}

function buscaUsuario($nick, $password) {

    $db = new mysqli("localhost", "root","", "batallanaval");
    $db->set_charset("utf8mb4");

    $stmt = $db->prepare("SELECT * FROM Usuarios WHERE nickname = ? LIMIT 1");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $result = $stmt->get_result();

    $json_temp = new stdClass();

    if ($result && $result->num_rows === 1) {

        if (verificarContraseña($password, $nick)) {

            $user = $result->fetch_object();

            $json_temp->existe = true;
            $json_temp->contra = true;
            $json_temp->nickname = $user->nickname;
            $json_temp->enUso = false;

            setCookiePHP("user", $user->nickname, 1);

        } else {
            $json_temp->existe = true;
            $json_temp->contra = false;
            $json_temp->enUso = false;
        }

    } else {
        $json_temp->existe = false;
        $json_temp->enUso = false;
    }

    echo json_encode($json_temp);
    $db->close();
}

?>
