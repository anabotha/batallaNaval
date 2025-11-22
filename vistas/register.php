<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Memory Game</title>
     <script src="register.js" defer></script>
          <link rel="stylesheet" href="./register.css">


</head>
<body>
     
<div class="register-box">
     <div class="emoji">📝</div>
     <h2>REGISTRATE</h2>
     <p>¡Unite a la partida!</p>
     <form id="form" action="login.php" method="post">
          <label for="usuario">Nombre de usuario</label>
          <input id="usuario" type="text" name="usuario" minlength="5" maxlength="15" placeholder="ej: superMemoria18" required>
          <label for="password">Contraseña</label>
          <input id="password" type="password" minlength="5" maxlength="15" name="password" placeholder="ej:12345" required>
          <label for="fecha_nacimiento">Fecha de nacimiento</label>   
          <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" required>
          <label for="email">Email</label>
          <input id="email" type="email" name="email" placeholder="usuario@gmail.com" required>
          <button id="registreUsuario" type="submit">REGISTRARME ✅</button>
     </form>
     <a href="../login.php">¿Ya tenés cuenta? Iniciá sesión</a>
</div>
<p id="info" class="info"></p>
<p id="exito" class="exito"></p> 
</body>
</html>