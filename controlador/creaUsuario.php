<?php
if (isset($_GET['obj'])) {
$json_string = $_GET['obj'];
$data = json_decode($json_string);
$nick = trim($data->nickname);
$fechaNac = trim($data->fechaNacimiento);
$email = trim($data->email);
$contra=trim($data->password);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
responderJson([
     "error" => true,
     "mensaje" => "Email inválido"
]);
exit;
}

$nombreExiste = existeNombre($nick);
$emailExiste = existeEmail($email);

if (!$nombreExiste && !$emailExiste) {
creaUsuario($nick, $fechaNac, $email,$contra);
} else {
responderJson([
     "nickname" => $nick,
     "nombreExiste" => $nombreExiste,
     "emailExiste" => $emailExiste,
     "nuevo" => false,
     "explicacion" => $nombreExiste ? "Nickname ya registrado" : "Email ya registrado"
]);
}
}

#chequea si el usuario existe y lo devuelve de lo cntrario, devuelve null
function responderJson($obj){
echo json_encode($obj);
}

function existeNombre($nick) {
// Conexión segura a la base
$db = new mysqli("localhost", "root", "", "batallanaval");
// Manejo de error de conexión
if ($db->connect_error) {
die("Error de conexión: " . $db->connect_error);
}
$db->set_charset("utf8mb4");

// Limpiar el nickname recibido
$nick = trim($nick); // Quita espacios adelante/atrás
//la query
$result = $db->query("SELECT 1 FROM Usuarios WHERE nickname='$nick' LIMIT 1");
$existe = ($result->num_rows > 0);
return $existe;
}

function existeEmail($email) {
// Conexión segura a la base
$db = new mysqli("localhost", "root", "", "batallanaval");

// Manejo de error de conexión
if ($db->connect_error) {
die("Error de conexión: " . $db->connect_error);
}

$db->set_charset("utf8mb4");

// Limpiar y validar el email
$email = trim($email);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
return false; // No es un email válido
}

// Usar consulta preparada para evitar inyección SQL

$result = $db->query("SELECT 1 FROM Usuarios WHERE  email ='$email' LIMIT 1");
$existe = ($result->num_rows > 0);
return $existe;
}


function hashContraseña($contra, $nick) {
// Hashea la contraseña con el algoritmo por defecto (bcrypt)
$hash = password_hash($contra, PASSWORD_DEFAULT);

// Conexión a la base de datos
$db = new mysqli("localhost", "root", "", "batallanaval");
$db->set_charset("utf8mb4");

// Verifica si hubo error en la conexion
if ($db->connect_error) {
     return false;
}

// Preparo la consulta para evitar inyecciones SQL
$stmt = $db->prepare("INSERT INTO contraseñas (nickname, contraseñas) VALUES (?, ?)");
if (!$stmt) {
     return false;
}

// Asocio los parámetros
$stmt->bind_param("ss", $nick, $hash);

// Ejecuta la consulta
$stmt->execute();

// Verifica si se inserto correctamente
$resultado = $stmt->affected_rows > 0;
// Cierro bd
$stmt->close();
$db->close();

return $resultado;
}

function creaUsuario($nick, $fechaNac, $email,$contra) {
$json_temp = new stdClass();

     $db = new mysqli("localhost", "root", "", "batallanaval");
     $db->set_charset("utf8mb4");

     $insert = "INSERT INTO Usuarios (
          nickname, fechaNacimiento,  email
     ) VALUES ('$nick', '$fechaNac', '$email');";

     $db->query($insert);

     if ($db->affected_rows > 0) {
          $json_temp->nombreExiste = false;
          $json_temp->emailExiste = false;
          $json_temp->nuevo = true;
          $json_temp->nickname = $nick;
          hashContraseña($contra,$nick);
     } else {
          $json_temp->nombreExiste = true;
          $json_temp->emailExiste = false;
          $json_temp->nuevo = false;
          $json_temp->error = true;
     }


responderJson($json_temp);
}
?>