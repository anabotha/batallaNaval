<?php
include "./ultimaPartida.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: loginView.php");
    exit;
}

$nick = $_SESSION["user"] ?? null;

$ultima = null;
if ($nick) {
    $ultima = getUltimaPartida($nick);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Batalla Naval</title>
     <link rel="stylesheet" href="./lobby.css">
</head>

<body id="body">
      <header>
          <h1>Última Partida</h1>
</header>
<main>
    <div class="ultima-partida">
    <?php if ($ultima): ?>
        <section>
        <p><strong>Fecha: </strong> </p>
        <p> <?= $ultima["fecha"] ?></p>
    </section>
        <section>
        <p><strong>Resultado: </strong> </p>
        <?php if( $ultima["resultado"] == 'User' || $ultima["resultado"] == 'user'): ?>
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
    <form id="formUltimaPartida" method="post" action="./formConfigurarPartida.php">
        <input type="hidden" name="nick" value="<?= $nick ?>">
        <button type="submit">Configurar partida</button>
        <button type="button" style="background-color: red;" onclick="location.href='../utils/logout.php'">Cerrar sesión</button>
    </form>
    </main>
        <footer>
</footer>
</html>
