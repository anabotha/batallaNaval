<?php
#muestra login y registro.
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Memory Game</title>
     <link rel="stylesheet" href="./login.css">
     <script src="../utils/cookies.js" defer></script>
     <script src="../controlador/login.js" defer></script>
     <script src="../utils/storage.js" defer></script>
</head>

<body id="body">
      <div class="header">
    <div class="left"></div>
    <div><h1>BATALLA NAVAL</h1></div>
    <div class="right"> <button onclick="irARanking()" style="border: none; background: none;">
  <img src="../docs\iconos\star" title="Ranking" class="iconos">
</button></div>
  </div>
  <main>
     <section class="logins">
          <div class="login-box">
     <div class="crown">👑</div>
     <!-- <h2>PLAYER ONE</h2> -->
     <div class="ingresoData" id="ingresoData">
     <p>¿Listo para dominar?</p>
     <form action="juego.php" method="post">
          <input type="text" minlength="5" maxlength="15" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
          <input type="password" minlength="5" maxlength="15"id="password"name="password" placeholder="Contraseña" required>
          <button id="inicio" type="button">ENTRAR AL JUEGO</button>
     </form>
     <a href="./register/register.php">¿No tenés cuenta? Registrate</a>
     <p id="info" class="info"></p>

</div>

</div>

</section>
</main>
<footer>
</footer>
</body>
</html>