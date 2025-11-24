     <?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="./config.css">
     <script src="../controlador/configurarPartida.js" defer></script>
</head>
<body>
  
<form method="POST" action="../controlador/configurarPartida.php">

      <div class="div-form">
     <label for="tablero"> Tamaño de tablero </label>
     <input type="radio" name="tablero" id="100" value="100" checked required> 10 x 10 (pequeño) </input>
     <input type="radio" name="tablero" id="150" value="150"> 10 x 15 (mediano) </input>
     <input type="radio" name="tablero" id="200" value="200"> 20 x 10 (grande) </input>
     <input type="radio" name="tablero" id="225" value="225"> 15 x 15 (super-grande) </input>
</div>
     <br>
     <section class="div-mismo_tipo" >
     <div class="div-form">
     <label for="acorazados"> Cantidad de acorazados </label>
     <input type="radio" name="acorazados" id="1" value="1" required> 1 </input>
     <input type="radio" name="acorazados" id="2" value="2" checked> 2 </input>
     <input type="radio" name="acorazados" id="3" value="3"> 3 </input>
</div>
      <div class="div-form">
     <label for="posicion_acorazados"> Posición de los acorazados </label>
     <input type="radio" name="posicion_acorazados" id="vertical" value="vertical" required checked> vertical </input>
     <input type="radio" name="posicion_acorazados" id="horizontal" value="horizontal"> horizontal </input>

</div>
<div class="div-form">
 <label for="color">Color del acorazado</label>
      <input type="radio" name="color_acorazados" id="amarillo" value="yellow" required checked> amarillo </input>
 <input type="radio" name="color_acorazados" id="rojo" value="red"> rojo </input>
 <input type="radio" name="color_acorazados" id="verde" value="green"> verde </input>
 <input type="radio" name="color_acorazados" id="blanco" value="grey"> blanco </input>
</div>

</section>
     <br>
     <section class="div-mismo_tipo" >

     <div class="div-form">
     <label for="destructores"> Cantidad de destructores </label>
     <input type="radio" name="destructores" id="2" value="2"> 2 </input>
     <input type="radio" name="destructores" id="3" value="3" checked required> 3 </input>
     <input type="radio" name="destructores" id="4" value="4"> 4 </input>
</div>
     <div class="div-form">
     <label for="posicion_destructores"> Posición de los destructores </label>
     <input type="radio" name="posicion_destructores" id="vertical" value="vertical" required checked> vertical </input>
     <input type="radio" name="posicion_destructores" id="horizontal" value="horizontal"> horizontal </input>

</div>
     <div class="div-form">

 <label for="color">Color de los destructores </label>
      <input type="radio" name="color_destructores" id="amarillo" value="yellow" required > amarillo </input>
 <input type="radio" name="color_destructores" id="rojo" value="red"> rojo </input>
 <input type="radio" name="color_destructores" id="verde" value="green"> verde </input>
 <input type="radio" name="color_destructores" id="blanco" value="grey" checked> blanco </input>
</div>

</section>
     <br>
     <section class="div-mismo_tipo" >

     <div class="div-form">
     <label for="submarinos"> Cantidad de submarinos </label>
     <input type="radio" name="submarinos" id="3" value="3" required> 3 </input>
     <input type="radio" name="submarinos" id="4" value="4" checked> 4 </input>
     <input type="radio" name="submarinos" id="5" value="5"> 5 </input>
</div>
     <div class="div-form">
     <label for="posicion_submarinos"> Posición de los submarinos </label>
     <input type="radio" name="posicion_submarinos" id="vertical" value="vertical" required checked> vertical </input>
     <input type="radio" name="posicion_submarinos" id="horizontal" value="horizontal"> horizontal </input>
</div>
     <div class="div-form">

 <label for="color">Color de los submarinos</label>
      <input type="radio" name="color_submarinos" id="amarillo" value="yellow" required > amarillo </input>
 <input type="radio" name="color_submarinos" id="rojo" value="red" checked> rojo </input>
 <input type="radio" name="color_submarinos" id="verde" value="green"> verde </input>
 <input type="radio" name="color_submarinos" id="blanco" value="grey"> blanco </input>
</div>
</section>
     <br>
     <section class="div-mismo_tipo" >

     <div class="div-form">
     <label for="posicion_portaviones"> Posición del portaviones </label>
     <input type="radio" name="posicion_portaviones" id="vertical" value="vertical" required checked> vertical </input>
     <input type="radio" name="posicion_portaviones" id="horizontal" value="horizontal"> horizontal </input>

</div>
     <div class="div-form">

     <label for="color">Color del portaviones</label>
      <input type="radio" name="color_portaviones" id="amarillo" value="yellow" required > amarillo </input>
  <input type="radio" name="color_portaviones" id="verde" value="green" checked> verde </input>
 <input type="radio" name="color_portaviones" id="blanco" value="grey"> blanco </input>

</div>
</section>
<br>
     <button type="submit" id="posiciones" > Posiciones </button>
     </form>

</body>
</html>