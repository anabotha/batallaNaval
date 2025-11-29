<?php

//     session_start();
function getDataBarcos() {

    if (!isset($_SESSION['config_juego'])) {
        throw new Exception("No hay configuración cargada.");
    }

    
$config = $_SESSION['config_juego'] ?? null;
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

    return $flota;
}
?>