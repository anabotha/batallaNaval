<?php
session_start();

$config = $_SESSION['config_juego'] ?? null;

if (!$config) {
    die("No hay configuración cargada.");
}

// Tamaño del tablero
$tablero = $config['tablero']; 

// Barcos
require_once __DIR__ . "/Barco.class.php";


$acorazado = new Barco(
    color: $config['acorazados']['color'],
    cantidad: $config['acorazados']['cantidad'],
    orientacion: $config['acorazados']['posicion'] ?? 'Horizontal', 
     tamaño: 3
);

$destructor = new Barco(
    color: $config['destructores']['color'],
    cantidad: $config['destructores']['cantidad'],
    orientacion: $config['destructores']['posicion'] ?? 'Horizontal',
     tamaño: 2
);

$submarino = new Barco(
    color: $config['submarinos']['color'],
    cantidad: $config['submarinos']['cantidad'],
    orientacion: $config['submarinos']['posicion'] ?? 'Horizontal',
     tamaño: 1
);

$portaviones = new Barco(
    color: $config['portaviones']['color'],
    cantidad: 1, // normalmente 1 portaviones
    orientacion: $config['portaviones']['posicion'] ?? 'Horizontal',
     tamaño: 4
);
$flota = [
    'acorazado'   => $acorazado,
    'destructor'  => $destructor,
    'submarino'   => $submarino,
    'portaviones' => $portaviones
];

$jsonFlota = json_encode($flota);
switch ($tablero) {
     case '100':
          $row=10;
          $col=10;
     break;
     case '150':
          $row=10;
          $col=15;
     break;
     case '200':
          $row=20;
          $col=10;
     break; 
     case '225':
          $row=15;
          $col=15;
     break;
     default:
          # code...
          break;
}
$jsonTablero = json_encode(["row" => $row, "col" => $col]);


?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="./posiciones.css">
     <script>
    const flota = <?php echo $jsonFlota; ?>;
</script>
<script>
    const tablero = <?php echo $jsonTablero; ?>;
</script>
     <script src="../controlador/posiciones.js" defer></script>
</head>
<body>
     <div class="instrucciones">
          <h2>Instrucciones para colocar las embarcaciones:</h2>
          <ul>
               <li>Haga clic en una celda del tablero para seleccionar la posición inicial de la embarcación.</li>
               <li>Repita el proceso hasta que todas las embarcaciones estén colocadas.</li>
          </ul>
          <div id="indicaciones">

               </div>  
          </div>  
     <div class="contenedor_tableros"> 


          <div class="tablero">
               <?php for ($i = 0; $i < $row; $i++): ?>
                    <?php for ($j = 0; $j < $col; $j++): ?>
                         <!-- <div class="cell" id="<?php echo 'cell-' . $i . '-' . $j; ?>"></div> -->
                    <div class="cell" data-row="<?= $i ?>" data-col="<?= $j ?>"></div>

                         <?php endfor; ?>
               <?php endfor; ?>
          </div>
         <button id="confirmarPosiciones" href="siguientepestaña">Confirmar Posiciones</button>
     </div>
</body>
</html>