<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Batalla Naval</title>
     <link rel="stylesheet" href="./login.css">
     <script src="./login.js" defer></script>
</head>

<body id="body">
          <header><h1>BATALLA NAVAL</h1></header>
  <main>
          <div class="login-box">
     <div class="crown">👑</div>
     <div class="ingresoData" id="ingresoData">
     <p>¿Listo para dominar?</p>
     <form action="juego.php" method="post">
          <input type="text" minlength="5" maxlength="15" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
          <input type="password" minlength="5" maxlength="15"id="password"name="password" placeholder="Contraseña" required>
          <button id="inicio" type="button">ENTRAR AL JUEGO</button>
     </form>
     <a href="./registrarse/register.html">¿No tenés cuenta? Registrate</a>
     <p id="info" class="info"></p>
     

     
</div>
</div>
</main>
<footer>
</footer>
</body>
</html>