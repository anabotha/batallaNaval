console.log("Flota cargada:", flota);
// VARIABLES GLOBALES
// let ocupadas = new Set();
let ocupadas = [];
let ocupadas_compu=[];
let listaBarcos = [];
let barcoActualIndex = 0;
let fin=false;
const prepararListaBarcos = () => {
    listaBarcos = [];

    for (let tipo in flota) {
        for (let i = 0; i < flota[tipo].cantidad; i++) {
            listaBarcos.push({
                tipo: tipo,
                index: i,
                color: flota[tipo].color,
                posiciones: [],
                tamaño:flota[tipo].tamaño,
                orientacion:flota[tipo].orientacion
            });
        }
    }

};

const mostrarBarcoActual = () => {
    const indicador = document.getElementById("indicaciones");

    const barco = listaBarcos[barcoActualIndex];

    indicador.innerHTML = `
        <h2>Colocá el barco: <span style="color:${barco.color}">${barco.tipo} #${barco.index + 1}</span></h2>
        <p>Click en una celda para colocarlo.</p>
    `;
};

const posicionElegida = (e) => {
     const barco = listaBarcos[barcoActualIndex];
     const fila =  parseInt(e.target.dataset.row);
     const col  =  parseInt(e.target.dataset.col);
     // guardar posición del barco
     barco.posiciones.push({ fila, col });

     console.log("Posición agregada a", barco.tipo, barco.posiciones,barco.color);
     
     const posicion=verificarPosicion(barco,fila,col);
     const noChoca=verificarChoque(barco,fila,col);
     // avanzar
     if (posicion && noChoca){
          ocuparCeldas(barco,fila,col);
          siguienteBarco();
     }else if(posicion){
          const indicador = document.getElementById("indicaciones");
          indicador.innerHTML = `
        <h2>Colocá el barco: <span style="color:${barco.color}">${barco.tipo} #${barco.index + 1}</span></h2>

               <p>La posicion no es valida, volvelo a intentar.</p>
          `;
     } else {
          const indicador = document.getElementById("indicaciones");
          indicador.innerHTML = `
        <h2>Colocá el barco: <span style="color:${barco.color}">${barco.tipo} #${barco.index + 1}</span></h2>

               <p>Ya esta ocupado ese lugar, volvelo a intentar.</p>
          `; 
     }
     console.log(posicion,noChoca);
};

const ocuparCeldas = (barco,fila,col) => {
     console.log("aa",col,fila);
    const tamaño = barco.tamaño;
    const orientacion = barco.orientacion;

    for (let i = 0; i < tamaño; i++) {
        let f = parseInt(fila);
        let c = parseInt(col);
        if (orientacion == "horizontal") {
            c = parseInt(col) + i;
        } else {
            f = parseInt(fila) + i;
          }
          
ocupadas.push({
    fila: f,
    col: c,
    barco: barco.tipo,     
    color: barco.color,
    orientacion:barco.orientacion

});

        //   ocupadas.add(`${f}-${c}`); esto es del set

     
     const celda = document.querySelector(`[data-row="${f}"][data-col="${c}"]`);
if (!celda) {
    console.error(`ERROR: No existe la celda (${f},${c})`);
    return;
}
console.log(celda);
celda.classList.add("ocupada");
celda.style.background = `${barco.color}`;
// celda.removeEventListener("onClick");
    }
};

const verificarPosicion = (barco, fila, col) => {
    const maxFilas = tablero.row;
    const maxCols  = tablero.col;

    if (barco.orientacion == "horizontal") {
        if (col + barco.tamaño > maxCols) {
            return false;
        }
    } else if (barco.orientacion == "vertical") {
        if (fila + barco.tamaño > maxFilas) {
            return false;
        }
    }

    return true;
};


const verificarChoque = (barco, fila, col) => {
    for (let i = 0; i < barco.tamaño; i++) {

        let f =  parseInt(fila);
        let c =  parseInt(col);
        console.log(barco);
        if (barco.orientacion == "horizontal") {
            console.log("horizontal")
            c = col + i;
        } else {
            f = fila + i;
            console.log("vertical")
        }

        // Usá otro nombre dentro del some
        if (ocupadas.some(cell => cell.fila === f && cell.col === c)) {
            return false;
        }
    }

    return true;
};

const siguienteBarco = () => {
    barcoActualIndex++;

    if (barcoActualIndex >= listaBarcos.length) {
        finalizarColocacion();
colocarBarcosComputadora();
console.log(ocupadas_compu);
        return;
    }

    mostrarBarcoActual();
};


const finalizarColocacion = () => {
    const indicador = document.getElementById("indicaciones");
    fin=true;

    indicador.innerHTML = `
        <h2>¡Todos los barcos fueron colocados!</h2>
        <p>Puedes continuar al siguiente paso.</p>
    `;

    console.log("Flota final con sus posiciones:", ocupadas);
    sessionStorage.removeItem("ocupadas");
    sessionStorage.setItem("ocupadas", JSON.stringify(ocupadas));

};

const sacarListeners=()=>{
    const cells = document.querySelectorAll(".cell");

    
    cells.forEach(cell => {
        cell.removeEventListener("click");
    });
}
const confirmarPosiciones=()=>{
    if( fin ) {
        window.location.href = "../vistas/juego.php";
        exit;
    } 
}

document.addEventListener("DOMContentLoaded", () => {
    const cells = document.querySelectorAll(".cell");

    prepararListaBarcos();
    mostrarBarcoActual();

    cells.forEach(cell => {
        cell.addEventListener("click", posicionElegida);
    });
});

