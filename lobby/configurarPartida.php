<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Tablero
    $tablero = $_POST['tablero'];

    // Acorazados
    $cantAcorazados = $_POST['acorazados'];
    $posAcorazados  = $_POST['posicion_acorazados'];  
    $colorAcorazado = $_POST['color_acorazados'];

    // Destructores
    $cantDestructores = $_POST['destructores'];
    $posDestructores  = $_POST['posicion_destructores']; 
    $colorDestructores = $_POST['color_destructores'];

    // Submarinos
    $cantSubmarinos = $_POST['submarinos'];
    $posSubmarinos  = $_POST['posicion_submarinos'];
    $colorSubmarinos = $_POST['color_submarinos'];

    // Portaviones
    $colorPortaviones = $_POST['color_portaviones'];
    $posPortaviones   = $_POST['posicion_portaviones'];

    // Ver datos (debug)
    var_dump($_POST);
$config = [
    "tablero" => $tablero,
    "acorazados" => [
        "cantidad" => $cantAcorazados,
        "posicion" => $posAcorazados,
        "color"    => $colorAcorazado
    ],
    "destructores" => [
        "cantidad" => $cantDestructores,
        "posicion" => $posDestructores,
        "color"    => $colorDestructores
    ],
    "submarinos" => [
        "cantidad" => $cantSubmarinos,
        "posicion" => $posSubmarinos,
        "color"    => $colorSubmarinos
    ],
    "portaviones" => [
        "posicion" => $posPortaviones,
        "color"    => $colorPortaviones
    ]
];

// Guardarlo en sesión o en DB
$_SESSION['config_juego'] = $config;



// Redirigir directamente a la vista
header("Location: ./formPosiciones.php"); //redirige al form de posiciones
exit;

}
