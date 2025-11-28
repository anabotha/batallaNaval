<?php
function init ($nick){

     if ( isset($_POST['nick']) ) {
     
         $nick = trim($_POST['nick']);
     
          $ultimaPartida = getUltimaPartida($nick);
}
}

function getUltimaPartida($nick) {
    $db = new mysqli("localhost", "root","", "batallanaval");
    $db->set_charset("utf8mb4");
     $stmt = $db->prepare("SELECT 
    P.fecha_partida,
    CASE
        WHEN P.ganador_jugador = P.id_jugador THEN 'User'
        WHEN P.gano_computadora = 1 THEN 'Computadora'
        WHEN P.ganador_jugador IS NULL THEN 'Empate'
    END AS resultado
FROM Partida AS P
JOIN Usuarios AS U 
    ON P.id_jugador = U.id_usuario
WHERE U.nickname = ?
ORDER BY P.fecha_partida DESC
LIMIT 1;
");
     $stmt->bind_param("s", $nick);
     $stmt->execute();
     $result = $stmt->get_result();
     if ($result && $result->num_rows === 1) {
         $partida = $result->fetch_assoc();
         return [
             "fecha" => $partida['fecha_partida'],
             "resultado" => $partida['resultado'],
         ];
     } else {
         return null;
     }
}
?>
