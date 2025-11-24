<?php
session_start();

$config = $_SESSION['config_juego'] ?? null;

if (!$config) {
    die("No hay configuración cargada.");
}

// Tamaño del tablero
$tablero = $config['tablero']; 

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


switch ($tablero) {
     case '100':
          $row=10;
          $col=10;
          $tab="chico";
     break;
     case '150':
          $row=10;
          $col=15;
          $tab="mediano";
     break;
     case '200':
          $row=20;
          $col=10;
          $tab="grande";
     break; 
     case '225':
          $row=15;
          $col=15;
          $tab="enorme";
     break;
     default:
          # code...
          break;
}

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
$jsonTablero=json_encode([
     'row' => $row,
     'col' => $col
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="./posiciones.css">
     <script> const flota = <?php echo $jsonFlota; ?>;</script>
     <script>const tablero = <?php echo $jsonTablero; ?>;</script>
     <script src="../controlador/juego.js" defer></script>
</head>
<body>
      <div class="instrucciones">
          <h2>Instrucciones para atacar las embarcaciones:</h2>
          <ul>
               <li>Haga clic en una celda del tablero enemigo para atacar una embarcación.</li>
               <li>Repita el proceso hasta que todas las embarcaciones estén sumergidas.</li>
          </ul>
          <div id="indicaciones">
          <p id="turno"></p>
               <p id="mensaje_resultado"> Tus jugadas <span id="resultado"></span></p>
               <p id="mensaje_resultado_en"> Jugadas de la CPU <span id="resultado_en"></span></p>

               <p id="mensaje_hundidos"> Barcos hundidos : <span id="hundidos"></span></p>
               <p id="mensaje_perdidos"> Barcos perdidos : <span id="perdidos"></span></p>

               </div>  
          </div>  
     <div class="contenedor_tableros">   
                    <div class="tablero_<?php echo $tab; ?>" id="tablero">
                    <!-- <h2>Tu tablero</h2> -->
               <?php for ($i = 0; $i < $row; $i++): ?>
                    <?php for ($j = 0; $j < $col; $j++): ?>
                         <div class="cell" id="<?php echo 'cell-' . $i . '-' . $j; ?>"></div>
                    <?php endfor; ?>
               <?php endfor; ?>
          </div>
          <div class="tablero_enemigo_<?php echo $tab; ?>" id="tablero"">
               <?php for ($i = 0; $i < $row; $i++): ?>
                    <?php for ($j = 0; $j < $col; $j++): ?>
                         <div class="cell_enemigo"  id="<?php echo 'cell-en-' . $i . '-' . $j; ?>"></div>
                    <?php endfor; ?>
               <?php endfor; ?>
          </div>
     </div>
</body>
</html>