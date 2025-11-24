    const ocupadas_compu=JSON.parse(sessionStorage.getItem("ocupadas_compu") ||[])
    let esTurnoJugador=true;
    let tirosComputadora = new Set();  // Para no repetir tiros

console.log("cpu",ocupadas_compu);
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
const manejoTurnos = () => {

    const divTurno = document.getElementById("turno");

    if (esTurnoJugador) {
        // divTurno.innerText = "Tu turno para jugar";
    } else {
        // divTurno.innerText = "Turno de la computadora";
        jugadaComputadora();
    }
};

const posicionElegida = (e) => {
    const r = evaluaJugada(e);
    manejoTurnos();
};


//ataques de la compu
function jugadaComputadora() {

    // obtener tus barcos desde sessionStorage
    const ocupadasJugador = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");

    let fila, col, id;

    // Buscar una posición no repetida
    do {
        fila = Math.floor(Math.random() * tablero.row);
        col = Math.floor(Math.random() * tablero.col);
        id = `cell-${fila}-${col}`;
    } while (tirosComputadora.has(id));

    // Registrar el tiro
    tirosComputadora.add(id);
    const resultado=document.getElementById("resultado_en");
    const cell = document.getElementById(id);
    if (!cell) return; // borde de seguridad

    // verificar impacto 
    const impacto = ocupadasJugador.find(b => b.fila === fila && b.col === col);

    if (impacto) {
        cell.innerText = "X";
        resultado.innerText = ` impactó tu ${impacto.barco}`;
        esTurnoJugador = false;
    } else {
        // agua
        cell.style.backgroundColor = "lightblue";
        resultado.innerText = " tiró y falló";

        esTurnoJugador = true;
    }

    // actualizar cartel de turno
    manejoTurnos();
}

const evaluaJugada = (e) => {
    const resultadoDiv=document.getElementById("resultado");

    const cell = document.getElementById(e.target.id);
    cell.removeEventListener("click", posicionElegida); // evitar re-click
    const resultado = ocupadas_compu.find(b => {
        const id = `cell-en-${b.fila}-${b.col}`;
        return cell.id === id;
    });

    if (resultado) {
        cell.style.backgroundColor = "red";
        resultadoDiv.innerText = ` ¡Impactaste el ${resultado.barco} de la computadora!`;
        return {
            impacto: true,
            barco: resultado.barco,
            fila: resultado.fila,
            col: resultado.col
        };
    } else {
        cell.style.backgroundColor = "blue";
        resultadoDiv.innerText = " ¡Agua!";
        
        esTurnoJugador = false;

        return {
            impacto: false,
            barco: null
        };
    }
};

//pedir pista

//guardar cambios 

// event listener
document.addEventListener("DOMContentLoaded", () => {
    const cells_en = document.querySelectorAll(".cell_enemigo");

    
    const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
    console.log(ocupadas);
    colorearCeldasOcupadas(ocupadas);
    

     cells_en.forEach(cell=>{
          cell.addEventListener("click", posicionElegida);

     });
    
});
