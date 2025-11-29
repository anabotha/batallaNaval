<?php
// utils/gameConfig.php

//     session_start();
function getGameConfig() {

    if (!isset($_SESSION['config_juego'])) {
        throw new Exception("No hay configuración cargada.");
    }

    $config = $_SESSION['config_juego'];

    switch ($config['tablero']) {
        case '100': return [10, 10, "chico"];
        case '150': return [10, 15, "mediano"];
        case '200': return [20, 10, "grande"];
        case '225': return [15, 15, "enorme"];
        default: throw new Exception("Tamaño de tablero inválido.");
    }
}
?>