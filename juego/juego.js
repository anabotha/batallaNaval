
//variables globales
const totalBarcos=calcularTotalBarcos();
let esTurnoJugador = true;
let tirosComputadora = new Set(); // Para no repetir tiros
let barcosHundidosCPU = new Set();
let barcosHundidosJugador = new Set();
let impactosCPU = [];
let impactosJugador = [];
let objetivosCPU = []; // posiciones pendientes para hundir un barco
let ultimoImpactoCPU = null; // para extender dirección
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
let intervaloReloj = null;
let pista=false;
let pistaComputadora=false;


// event listener
document.addEventListener("DOMContentLoaded", () => {
  const inicio = Date.now();
  const cells_en = document.querySelectorAll(".cell_enemigo");
  const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
  sessionStorage.setItem("inicioPartida", inicio);
  colorearCeldasOcupadas(ocupadas);
  ranking();
  reloj(); //inicia el reloj
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

  if (!finalizaJuego()) { 
    if (!esTurnoJugador) {
      jugadaComputadora(); // <- AHORA SÍ SE EJECUTA
    }
  }
};

function agregarObjetivosAledaños(fila, col) {
  const candidatos = [
    { fila: fila - 1, col },     // arriba
    { fila: fila + 1, col },     // abajo
    { fila, col: col - 1 },      // izquierda
    { fila, col: col + 1 }       // derecha
  ];

  // Filtrar posiciones válidas
  candidatos.forEach(c => {
    if (
      c.fila >= 0 && c.fila < tablero.row &&
      c.col >= 0 && c.col < tablero.col
    ) {
      const id = `cell-${c.fila}-${c.col}`;
      if (!tirosComputadora.has(id)) {
        objetivosCPU.push(c);
      }
    }
  });
}

function jugadaComputadora() {
  const ocupadasJugador = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");

  let fila, col, id;

  // 1) Si hay objetivos, atacarlos primero
  if (objetivosCPU.length > 0) {
    const objetivo = objetivosCPU.shift();
    fila = objetivo.fila;
    col = objetivo.col;
    id = `cell-${fila}-${col}`;
  } 
  else if (pistaComputadora) {
    const jugada = darPistaParaComputadora();
    if (jugada) {
      fila = jugada.fila;
      col = jugada.col;
      id = `cell-${fila}-${col}`;
    }
  }

  // 2) Si no hay estrategia, elegir aleatorio
  if (!id) {
    do {
      fila = Math.floor(Math.random() * tablero.row);
      col = Math.floor(Math.random() * tablero.col);
      id = `cell-${fila}-${col}`;
    } while (tirosComputadora.has(id));
  }

  tirosComputadora.add(id);

  const cell = document.getElementById(id);
  if (!cell) return;

  const impacto = ocupadasJugador.find(b => b.fila === fila && b.col === col);

  if (impacto) {
    cell.innerText = "X";
    resultado.innerText = `La CPU impactó tu ${impacto.barco}`;
    esTurnoJugador = false;

    impactosCPU.push({ fila, col, barco: impacto.barco, id: impacto.id });

    evaluaBarco(impacto.barco, "computadora", impacto.id);

    // guardar último impacto
    ultimoImpactoCPU = { fila, col };

    // agregar objetivos alrededor
    agregarObjetivosAledaños(fila, col);

    // volver a jugar inmediatamente
    jugadaComputadora();
    return;
  } else {
    // agua
    resultado.innerText += `
     La CPU falló. ¡Agua!`
    ;
    cell.style.backgroundColor = "lightblue";
    ultimoImpactoCPU = null;
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

  return celdasImpactadas.length === celdasBarco.length;
}

// contar aciertos por barco
const evaluaJugada = (e) => {
  const resultadoDiv = document.getElementById("resultado");
  const cell = document.getElementById(e.target.id);
const ocupadas_compu = JSON.parse(sessionStorage.getItem("ocupadas_compu") || "[]");

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
          esTurnoJugador = true;

    evaluaBarco(resultado.barco, "jugador", resultado.id);
  } else {
    cell.style.backgroundColor = "lightblue";
    if (esTurnoJugador) resultadoDiv.innerText = " ¡Agua!";

    esTurnoJugador = false;
  }
};

const evaluaBarco = (tipo, jugador, id) => {
  const resultadoDiv = document.getElementById("resultado");
  const hundidos = document.getElementById("hundidos");
  const perdidos = document.getElementById("perdidos");
  if (jugador === "jugador") {
    if (
      barcoHundido(tipo, "jugador", id) &&
      !barcosHundidosJugador.has(tipo + "-" + id)
    ) {
      barcosHundidosJugador.add(tipo + "-" + id);
      aciertos.find((b) => b.nombre === tipo).cantidad++;

      resultadoDiv.innerText = ` 🎉 ¡Hundiste el ${tipo} de la computadora!`;
      hundidos.innerText = ` ${Array.from(barcosHundidosJugador).length}`;
          esTurnoJugador =true;

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
          esTurnoJugador = false;

    }
  }
};

function pistaValida(pistaBarco){
  // Devuelve true si YA fue impactada (para EXCLUIRLA); false si está disponible
  const yaImpactada = impactosJugador.some(impacto => 
    impacto.fila === pistaBarco.fila && impacto.col === pistaBarco.col
  );
  return yaImpactada; // true = ya impactada, false = disponible
}

// Función paralela para la CPU: sin recursión, usa filter directo
function darPistaParaComputadora(){
  const ocupadasJugador = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
  
  if (ocupadasJugador.length === 0) return null;
  
  // Filtrar celdas no impactadas aún
  const celdasDisponibles = ocupadasJugador.filter(celda => !pistaValida(celda));
  
  if (celdasDisponibles.length === 0) {
    return null;
  }
  
  const randomIndex = Math.floor(Math.random() * celdasDisponibles.length);
  const pistaBarco = celdasDisponibles[randomIndex];
  
  return { fila: pistaBarco.fila, col: pistaBarco.col };
}
function darPista(intentos = 0){
  pista=true;
  const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas_compu") || "[]");
  const btnPista= document.getElementById("pista_btn");
  btnPista.style.display="none"; //ocultar boton pista despues de usarlo
  
  if(ocupadas.length>0 && intentos < 20){ 
    const randomIndex = Math.floor(Math.random() * ocupadas.length);
    const pistaBarco = ocupadas[randomIndex];
    if (pistaValida(pistaBarco)){ // si ya fue impactada
      darPista(intentos + 1); //llamar recursivamente hasta encontrar una pista valida
      return;
    } else { // celda no impactada aún = válida para pista
      let celda=document.getElementById("cell-en-" + pistaBarco.fila + "-" + pistaBarco.col );
      celda.style.backgroundColor = "yellow";
      setTimeout(() => {
        if (celda.style.backgroundColor === "yellow") {
        celda.style.backgroundColor = "white";}
      }, 15000);
    }
    esTurnoJugador = false; 
  }
}

//abandonar partida
function abandonarPartida() {
  let confirmar = confirm("¿Estás seguro de que deseas abandonar la partida?");
  if (confirmar) {
      alert("Has abandonado la partida. Esta partida no se guardará.");
  }
  detenerReloj();
  irLobby();
}

//tiempo


function reloj() {
  let tiempoTranscurrido = 0;

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
const totalSegundos = Math.floor(duracionMs / 1000);
const horas = Math.floor(totalSegundos / 3600);
const minutos = Math.floor((totalSegundos % 3600) / 60);
const segundos = totalSegundos % 60;

return `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;

}
//evalua si finaliza el juego. 
function finalizaJuego() {
    let jugadorGana = false;
    let cpuGana = false;
    let cantBarcos=0;
    let fin= false;
  
    aciertos.forEach(tipo => {
        cantBarcos+=tipo.cantidad
        if (cantBarcos<totalBarcos){
          fin=false;
        }else{
          fin=true;
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
        irFinalizar();
        
        return true;    }

    if (cpuGana) {
        alert("💀 PERDISTE. La CPU hundió toda tu flota.");
        const fin = Date.now();
        sessionStorage.setItem("finPartida", fin);
        detenerReloj();
        agregaPartidaBd("computadora");
        irFinalizar();
        return true;
    }
    return false;
}

//guarda la partida
function agregaPartidaBd(ganador) {
const user=sessionStorage.getItem("user");
  const infoPartida = {
    usuario: user,
    ganoJugador: ganador === "jugador" ? 1 : 0,
    ganoComputadora: ganador !== "jugador" ? 1 : 0,
    tiempo: calcularTiempo(),
  };


  fetch('./agregaPartida.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(infoPartida)
  })
  .then(res => {
    console.log('status', res.status);
    return res.text();
  })
  .then(text => {
    console.log('agregaPartidas response:', text);
    try { const json = JSON.parse(text); console.log('respuesta json', json); } catch(e){/* no JSON */ }
  })
  .catch(err => {
    console.error('Error enviando partida:', err);
  });
}

//Ranking
function ranking(){
    const nombreUsuario = sessionStorage.getItem("user") || "";
      let xhr = new XMLHttpRequest();
     xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {

            console.log(xhr.responseText);
               let respuesta = JSON.parse(xhr.responseText);
               
            mostrarRanking(respuesta);
          }
     };
     xhr.open("GET", "../juego/top3.php?usuario=" + encodeURIComponent(nombreUsuario), true);
     xhr.send();
  
}

function mostrarRanking(data){
let p=document.getElementById("ranking_list");
if(data.length === 0) {
  p.innerText = "No hay partidas jugadas aún.";
}else{
  data.forEach((usuario, index) => {
      let linea=document.createElement("p");
      linea.innerText=`
      ${index + 1}. Duracion partida: ${usuario.duracion_partida}
                   Fecha: ${usuario.fecha_partida}`;
      p.appendChild(linea);
  });
}
}

//dirigir
function irLobby(){
  window.location.href = "../lobby/lobby.php";
}
function irFinalizar() {
    window.location.href = "fin.php";
}