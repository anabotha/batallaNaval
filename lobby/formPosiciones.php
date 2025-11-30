<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$config = $_SESSION['config_juego'] ?? null;

if (!$config) {
    die("No hay configuración cargada.");
}

//tablero
require_once "../utils/tablero.php";

list($row, $col, $tab) = getGameConfig();
$jsonTablero = json_encode(["row" => $row, "col" => $col]);

require_once "../utils/dataBarcos.php";
$flota = getDataBarcos();
$jsonFlota = json_encode($flota);



?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Batalla Naval</title>
     <link rel="stylesheet" href="./posiciones.css">
     <script>const flota = <?php echo $jsonFlota; ?>;</script>
     <script>const tablero = <?php echo $jsonTablero; ?>;</script>
     <script src="./posiciones.js" defer></script>
     <script src="./posiciones_cpu.js" defer></script>

</head>
<body>
     <header>
          <h1>Coloca tus embarcaciones</h1>
     </header>
     <main>
     <div class="instrucciones">
          
          <ul>
               <li>Haga clic en una celda del tablero para seleccionar la posición inicial de la embarcación.</li>
               <li>Repita el proceso hasta que todas las embarcaciones estén colocadas.</li>
          </ul>
          
          <div id="indicaciones">
               </div>  
          
          </div>  
     <div class="contenedor_tableros"> 


          <div class="tablero_<?php echo $tab; ?>" id="tablero">
               <?php for ($i = 0; $i < $row; $i++): ?>
                    <?php for ($j = 0; $j < $col; $j++): ?>
                    <div class="cell" data-row="<?= $i ?>" data-col="<?= $j ?>"></div>

                         <?php endfor; ?>
               <?php endfor; ?>
          </div>
          <div>
               <h3>Recuerda</h3>
          <h4>Submarinos: 1 celda</h4>
          <h4>Destructores: 2 celdas</h4>
          <h4>Acorazados: 3 celdas</h4>
          <h4>Portaviones: 4 celdas</h4>
          <button id="confirmarPosiciones" onClick="confirmarPosiciones()">Confirmar Posiciones</button>
          <button type="button" style="background-color: red;" onclick="location.href='../utils/logout.php'">Cerrar sesión</button>

     </div>
     </div>

                    </main>
                    <footer>
                    </footer>
</body>
</html>