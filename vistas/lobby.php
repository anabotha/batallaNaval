<?php
// Incluimos el archivo con la función
include "../controlador/ultimaPartida.php";

// Supongamos que el nick lo tenés en sesión
session_start();
$nick = $_COOKIE["user"] ?? null;

$ultima = null;
if ($nick) {
    // Llamamos a la función que retorna fecha y resultado
    $ultima = getUltimaPartida($nick);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Memory Game</title>
     <link rel="stylesheet" href="./lobby.css">
         <script src="../utils/cookies.js" defer></script>
    <script src="../utils/storage.js" defer></script>
</head>

<body id="body">
      <header>
     <h1> Lobby de Batalla Naval </h1>
</header>
<main>
    <div class="ultima-partida">
        <h1>Última Partida</h1>
    <?php if ($ultima): ?>
        <section>
        <p><strong>Fecha: </strong> </p>
        <p> <?= $ultima["fecha"] ?></p>
    </section>
        <section>
        <p><strong>Resultado: </strong> </p>
        <?php if( $ultima["resultado"] == 'User'): ?>
            <p> ¡Felicidades, has ganado la última partida!</p>
        <?php elseif ( $ultima["resultado"] == 'Computadora' ) : ?>
            <p> La computadora ganó la última partida. ¡Mejor suerte la próxima vez!</p>
        <?php else: ?>
            <p> La última partida terminó en empate.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No hay partidas previas registradas.</p>
    <?php endif; ?>
</section>
</div>
<hr>
    <!-- BOTÓN para configurar nueva partida -->
    <form id="formUltimaPartida" method="post" action="../vistas/formConfigurarPartida.php">
        <input type="hidden" name="nick" value="<?= $nick ?>">
        <button type="submit">Configurar partida</button>
    </form>
    </main>
        <footer>
</footer>
</html>
