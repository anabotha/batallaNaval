<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="./fin.css">
</head>
<body>
     <header>
</header>
     <main>
<body>
     <?php
     include_once "../juego/ranking.php";
     $top5 = obtenerTop5PartidasGanadas();
     if ($top5 === false) {
          echo "<p>No hay partidas ganadas registradas.</p>";
     } else {
          echo "<h2>Top 5 Partidas Ganadas Más Rápidas</h2>";
          echo "<table border='1'>
                    <tr>
                         <th>Posición</th>
                         <th>Nickname</th>
                         <th>Duración</th>
                         <th>Fecha</th>
                    </tr>";
          $posicion = 1;
          foreach ($top5 as $partida) {
               echo "<tr>
                         <td>{$posicion}</td>
                         <td>{$partida['nickname']}</td>
                         <td>{$partida['duracion_partida']}</td>
                         <td>{$partida['fecha_partida']}</td>
                    </tr>";
               $posicion++;
          }
          echo "</table>";
     }
     ?>
     <button onclick="window.location.href='../lobby/lobby.php'">Volver a jugar</button>
     <button onclick="window.location.href='../login/loginView.php'">Salir</button>
</body>
</html>