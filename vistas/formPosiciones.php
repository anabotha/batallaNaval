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
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="./posiciones.css">
     <script src="../controlador/posiciones.js" defer></script>
</head>
<body>
     <div class="contenedor_tableros">   
          <div class="tablero">
               <?php for ($i = 0; $i < $row; $i++): ?>
                    <?php for ($j = 0; $j < $col; $j++): ?>
                         <div class="cell" id="<?php echo 'cell-' . $i . '-' . $j; ?>"></div>
                    <?php endfor; ?>
               <?php endfor; ?>
          </div>
         <button id="confirmarPosiciones">Confirmar Posiciones</button>
     </div>
</body>
</html>