
//variables globales
let esTurnoJugador = true;
let tirosComputadora = new Set(); // Para no repetir tiros
let barcosHundidosCPU = new Set();
let barcosHundidosJugador = new Set();
let impactosCPU = [];
let impactosJugador = [];
let aciertosComputadora = [
  { nombre: "submarino", cantidad: 0 },
  { nombre: "destructor", cantidad: 0 },
  { nombre: "acorazado", cantidad: 0 },
  { nombre: "portaviones", cantidad: 0 },
];
let aciertos = [
  { nombre: "submarino", cantidad: 0 },
  { nombre: "destructor", cantidad: 0 },
  { nombre: "acorazado", cantidad: 0 },
  { nombre: "portaviones", cantidad: 0 },
];
let tiempoTranscurrido = 0;
let intervaloReloj = null;
let pista=false;
let pistaComputadora=false;
const ocupadas_compu = JSON.parse(sessionStorage.getItem("ocupadas_compu") || "[]");
const totalBarcos=calcularTotalBarcos();
console.log("totalBarcos",totalBarcos);
console.log("cpu", ocupadas_compu);
// event listener
document.addEventListener("DOMContentLoaded", () => {
  const inicio = Date.now();
  sessionStorage.setItem("inicioPartida", inicio);
  reloj();
  const cells_en = document.querySelectorAll(".cell_enemigo");
  const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
  console.log(ocupadas);
  colorearCeldasOcupadas(ocupadas);
  cells_en.forEach((cell) => {
    cell.addEventListener("click", posicionElegida);
  });
});


//calcule la cantidad de barcos
function calcularTotalBarcos() {
  const flota = JSON.parse(sessionStorage.getItem("flota") || "{}");

  let total = 0;

  Object.values(flota).forEach(tipo => {
    total += tipo.cantidad;
  });

  console.log("Total barcos:", total);
  return total;
}

//busque las posiciones de los barcos.
function colorearCeldasOcupadas(ocupadas) {
  ocupadas.forEach(({ fila, col, color }) => {
    const id = `cell-${fila}-${col}`;
    const cell = document.getElementById(id);
    if (cell) {
      cell.style.backgroundColor = color;
    }
  });
}

const posicionElegida = (e) => {
  evaluaJugada(e);

  // finalizaJuego();
  if(!finalizaJuego()){ 
  if (!esTurnoJugador) {
    jugadaComputadora();
  }
};
}

function jugadaComputadora() {
  // obtener tus barcos desde sessionStorage
  let jugada={};
  if(pista && !pistaComputadora){
    jugada=darPistaComputadora();
    console.log("jugada",jugada);
  }
  const ocupadasJugador = JSON.parse(
    sessionStorage.getItem("ocupadas") || "[]"
  );
  let fila, col, id;
  if (pistaComputadora && jugada!={}){
    fila=jugada.fila;
    col=jugada.col;
    id = `cell-${fila}-${col}`;
  }else
{
  // Buscar una posición no repetida
  do {
    fila = Math.floor(Math.random() * tablero.row);
    col = Math.floor(Math.random() * tablero.col);
    id = `cell-${fila}-${col}`;
  } while (tirosComputadora.has(id));

}
// Registrar el tiro
tirosComputadora.add(id);
const cell = document.getElementById(id);
if (!cell) return; // borde de seguridad
const resultado = document.getElementById("resultado"); 
  // verificar impacto
  const impacto = ocupadasJugador.find((b) => b.fila === fila && b.col === col);

  if (impacto) {
    cell.innerText = "X";
    resultado.innerText = ` La CPU impactó tu ${impacto.barco}`;
    esTurnoJugador = false;
    impactosCPU.push({
      fila,
      col,
      barco: impacto.barco,
      id: impacto.id,
    });

    evaluaBarco(impacto.barco, "computadora", impacto.id);
  } else {
    // agua
    cell.style.backgroundColor = "lightblue";

    esTurnoJugador = true;
  }
}

function barcoHundido(tipo, atacante, id) {
  const posiciones =
    atacante === "jugador"
      ? JSON.parse(sessionStorage.getItem("ocupadas_compu") || "[]")
      : JSON.parse(sessionStorage.getItem("ocupadas") || "[]");

  // celdas del barco exacto
  const celdasBarco = posiciones.filter((c) => c.barco === tipo && c.id === id);

  // Ver impactos (celda hundida)
  const impactos = atacante === "jugador" ? impactosJugador : impactosCPU;

  const celdasImpactadas = impactos.filter(
    (h) => h.barco === tipo && h.id === id
  );
  console.log(impactos, celdasBarco, celdasImpactadas);

  return celdasImpactadas.length === celdasBarco.length;
}

// contar aciertos por barco
const evaluaJugada = (e) => {
  const resultadoDiv = document.getElementById("resultado");
  const cell = document.getElementById(e.target.id);

  cell.removeEventListener("click", posicionElegida); // evitar re-click

  const resultado = ocupadas_compu.find((b) => {
    const id = `cell-en-${b.fila}-${b.col}`;
    return cell.id === id;
  });

  if (resultado) {
    impactosJugador.push({
      fila: resultado.fila,
      col: resultado.col,
      barco: resultado.barco,
      id: resultado.id,
    });

    cell.innerText = "X";
    cell.style.backgroundColor = "red";
    resultadoDiv.innerText = ` ¡Impactaste el ${resultado.barco} de la computadora!`;
    evaluaBarco(resultado.barco, "jugador", resultado.id);
  } else {
    cell.style.backgroundColor = "lightblue";
    resultadoDiv.innerText = " ¡Agua!";
    esTurnoJugador = false;
  }
};

const evaluaBarco = (tipo, jugador, id) => {
  const resultadoDiv = document.getElementById("resultado");
  const hundidos = document.getElementById("hundidos");
  const perdidos = document.getElementById("perdidos");
  if (jugador === "jugador") {
    console.log(aciertos);
    if (
      barcoHundido(tipo, "jugador", id) &&
      !barcosHundidosJugador.has(tipo + "-" + id)
    ) {
      console.log(tipo);
      barcosHundidosJugador.add(tipo + "-" + id);
      aciertos.find((b) => b.nombre === tipo).cantidad++;

      console.log(" Hundiste", tipo, "#", id);
      resultadoDiv.innerText = ` 🎉 ¡Hundiste el ${tipo} de la computadora!`;
      hundidos.innerText = ` ${Array.from(barcosHundidosJugador).length}`;
    }
  } else {
    if (
      barcoHundido(tipo, "cpu", id) &&
      !barcosHundidosCPU.has(tipo + "-" + id)
    ) {
      barcosHundidosCPU.add(tipo + "-" + id);
      aciertosComputadora.find((b) => b.nombre === tipo).cantidad++;
      perdidos.innerText = ` ${Array.from(barcosHundidosCPU).length}`;
      resultadoDiv.innerText = ` 💀 La CPU hundió tu ${tipo}!`;
    }
  }
};

function darPistaComputadora(){
  pistaComputadora=true;
  const ocupadasJugador = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
  if(ocupadasJugador.length>0){
    const randomIndex = Math.floor(Math.random() * ocupadasJugador.length);
    const pistaBarco = ocupadasJugador[randomIndex];
    if (!pistaValida(pistaBarco)){
      darPistaComputadora(); //llamar recursivamente hasta encontrar una pista valida
    }
    console.log("pistaBarco",pistaBarco);
    return {fila:pistaBarco.fila, col:pistaBarco.col};
      }}

function pistaValida(pistaBarco){
  if (impactosJugador.some(impacto => impacto.fila === pistaBarco.fila && impacto.col === pistaBarco.col && pistaBarco.id===impacto.id)) {
    console.log("pistaBarco",pistaBarco,false);
        return false; // ya fue impactado
    } else{
      
      return true;
    }
}
//pedir pista
function darPista(){
  pista=true;
  const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas_compu") || "[]");
  const pistaDiv= document.getElementById("pista");
  const btnPista= document.getElementById("pista_btn");
  btnPista.style.display="none"; //ocultar boton pista despues de usarlo
  if(ocupadas.length>0){
    const randomIndex = Math.floor(Math.random() * ocupadas.length);
    const pistaBarco = ocupadas[randomIndex];
    if (!pistaValida(pistaBarco)){
      darPista(); //llamar recursivamente hasta encontrar una pista valida
    }else{
      // pistaDiv.innerHTML=` <h2>Pista:</h2>
        // <p>El ${pistaBarco.barco} está en la fila ${(pistaBarco.fila + 1)}, columna ${(pistaBarco.col + 1)}.</p>
      // `;
      let celda=document.getElementById("cell-en-" + pistaBarco.fila + "-" + pistaBarco.col );
      celda.style.backgroundColor = "yellow";
      setTimeout(() => {
        if (celda.style.backgroundColor === "yellow") {
        celda.style.backgroundColor = "white";}
      }, 15000);
    }
    }
    
  

}
//guardar cambios
//abandonar partida
function abandonarPartida() {
  let confirmar = confirm("¿Estás seguro de que deseas abandonar la partida?");
  if (confirmar) {
      alert("Has abandonado la partida. La CPU será declarada ganadora.");
  }
  detenerReloj();
  irLobby();
}

//tiempo


function reloj() {
  tiempoTranscurrido = 0;

  intervaloReloj = setInterval(() => {
    tiempoTranscurrido++;

    const minutos = Math.floor(tiempoTranscurrido / 60);
    const segundos = tiempoTranscurrido % 60;

    const tiempoFormateado = 
      `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;

    document.getElementById('tiempo').textContent = tiempoFormateado;
  }, 1000);
}

function detenerReloj() {
  clearInterval(intervaloReloj);
}

function calcularTiempo(){
  const inicio = Number(sessionStorage.getItem("inicioPartida"));
const fin = Number(sessionStorage.getItem("finPartida"));

const duracionMs = fin - inicio;

const duracionSeg = Math.floor(duracionMs / 1000);
return duracionSeg;
}
//evalua si finaliza el juego. 
function finalizaJuego() {

    let jugadorGana = false;
    let cpuGana = false;
    let cantBarcos=0;
    let fin= false;
  
    aciertos.forEach(tipo => {
        cantBarcos+=tipo.cantidad
        console.log("tipo",tipo.nombre,tipo.cantidad);
        if (cantBarcos<totalBarcos){
          fin=false;
        }else{
          fin=true;
          console.log("fin");
          jugadorGana = true;
        }
    });
    aciertosComputadora.forEach(tipo => {
      if (cantBarcos<totalBarcos){
          fin=false;
        }else{
          fin=true;
            cpuGana = true;
        }
      }
    );

    if (jugadorGana) {
        alert("🎉 ¡GANASTE! Hundiste toda la flota enemiga.");
        const fin = Date.now();
        sessionStorage.setItem("finPartida", fin);
        detenerReloj();
        agregaPartidaBd("jugador");
        // irFinalizar();
        
        return true;    }

    if (cpuGana) {
        alert("💀 PERDISTE. La CPU hundió toda tu flota.");
        const fin = Date.now();
        sessionStorage.setItem("finPartida", fin);
        detenerReloj();
        agregaPartidaBd("computadora");
        // irFinalizar();
        return true;
    }
    // irFinalizar();
    return false;
}
function agregaPartidaBd(ganador) {
     
  if (ganador==="jugador"){
    ganoJugador=true;
    ganoComputadora=false;
  }else {
    ganoJugador=false;
    ganoComputadora=true;
  }

  let infoPartida={
      usuario: sessionStorage.getItem("user") , // no anda el user
      ganoJugador: ganoJugador,
      ganoComputadora: ganoComputadora,
      tiempo: calcularTiempo(),
  }
  console.log("infoPartida",infoPartida);
     let xhr = new XMLHttpRequest();
     xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {

               let respuesta = JSON.parse(xhr.responseText);
              //  irAResults();
          }
     };
     xhr.open("GET", "agregaPartidas.php?resultado=" + encodeURIComponent(JSON.stringify(infoPartida)), true);

     xhr.send();//no anda
}

//dirigir
function irLobby(){
  window.location.href = "lobby.php";
}
function irFinalizar() {
    window.location.href = "fin.php";
}