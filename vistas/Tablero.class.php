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