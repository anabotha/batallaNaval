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


// Barcos
$ac_cant   = $config['acorazados']['cantidad'];
$ac_pos    = $config['acorazados']['posicion'];
$ac_color  = $config['acorazados']['color'];

$des_cant  = $config['destructores']['cantidad'];
$des_pos   = $config['destructores']['posicion'];
$des_color = $config['destructores']['color'];

$sub_cant  = $config['submarinos']['cantidad'];
$sub_pos   = $config['submarinos']['posicion'];
$sub_color = $config['submarinos']['color'];

$porta_pos   = $config['portaviones']['posicion'];
$porta_color = $config['portaviones']['color'];

$jsonFlota=json_encode([
     'acorazados' => [
          'cantidad' => $ac_cant,
          'posicion' => $ac_pos,
          'color'    => $ac_color
     ],
     'destructores' => [
          'cantidad' => $des_cant,
          'posicion' => $des_pos,
          'color'    => $des_color
     ],
     'submarinos' => [
          'cantidad' => $sub_cant,
          'posicion' => $sub_pos,
          'color'    => $sub_color
     ],
     'portaviones' => [
          'posicion' => $porta_pos,
          'color'    => $porta_color
     ]
]);

//tablero
require_once "../utils/gameConfig.php";

list($row, $col, $tab) = getGameConfig();
$jsonTablero = json_encode(["row" => $row, "col" => $col]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Batalla naval</title>
     <link rel="stylesheet" href="./juego.css">

     <script> const flota = <?php echo $jsonFlota; ?>;</script>
     <script>const tablero = <?php echo $jsonTablero; ?>;</script>
     <script src="./juego.js" defer></script>
</head>
<body>
     <header>
</header>
     <main>
          <div class="layout_3col">
          <div class="instrucciones">
               
               <h2>Instrucciones para atacar las embarcaciones:</h2>
               <ul>
                    <li>Haga clic en una celda del tablero enemigo para atacar una embarcación.</li>
                    <li>Repita el proceso hasta que todas las embarcaciones estén sumergidas.</li>
               </ul>
               <div class="reloj" id="reloj">
                    <h2>Tiempo transcurrido:</h2>
                    <p id="tiempo">00:00</p>
               </div>
               <section class="botones_juego">     
               <button id="finalizar_btn" onclick="abandonarPartida()">Abandonar partida</button>
                    <button id="pista_btn" onclick="darPista()">Pista</button>
               </section>

          </div>  

          <div class="info_juego">
               <div class="separador">
                    <h3>Tu tablero</h3>
                    <h3>Tablero enemigo</h3>
               </div>
               <div class="contenedor_tableros">   
                    <div class="tablero_<?php echo $tab; ?>" id="tablero">
                         <?php for ($i = 0; $i < $row; $i++): ?>
                              <?php for ($j = 0; $j < $col; $j++): ?>
                                   <div class="cell" id="<?php echo 'cell-' . $i . '-' . $j; ?>">

                                   </div>
                              <?php endfor; ?>
                         <?php endfor; ?>
                    </div>
               <div class="tablero_<?php echo $tab; ?>" id="tablero"">
                    <?php for ($i = 0; $i < $row; $i++): ?>
                         <?php for ($j = 0; $j < $col; $j++): ?>
                              <div class="cell_enemigo"  id="<?php echo 'cell-en-' . $i . '-' . $j; ?>"></div>
                         <?php endfor; ?>
                    <?php endfor; ?>
               </div>
               </div>

          <div id="indicaciones" class="indicaciones">
               <p id="mensaje_resultado"> Info:  <span id="resultado"></span></p>
          </div>

          <section id="estadisticas" class="estadisticas">
               <p id="mensaje_perdidos"> Barcos perdidos : <span id="perdidos"> 0</span></p>
               <p id="mensaje_hundidos"> Barcos hundidos : <span id="hundidos"> 0 </span></p>
          </section>
     </div>

     <div id="ranking">
          <h3>Ranking personal</h3>
          <p id="ranking_list"></p>

          <div>
          <h3>Recuerda</h3>
          <h4>Submarinos: 1 celda</h4>
          <h4>Destructores: 2 celdas</h4>
          <h4>Acorazados: 3 celdas</h4>
          <h4>Portaviones: 4 celdas</h4>
     </div>
     </div>

     </div>

     </main>
<footer>
     
</footer>
</body>
</html>