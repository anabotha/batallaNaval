// ==========================
//   COLOCAR BARCOS CPU
// ==========================

function colocarBarcosComputadora() {
    ocupadas_compu = []; // limpiar por si se llama de nuevo

    // Copio tu misma estructura listaBarcos pero independiente
    const flotaCPU = [];

    for (let tipo in flota) {
        for (let i = 0; i < flota[tipo].cantidad; i++) {
            flotaCPU.push({
                tipo: tipo,
                index: i,
                color: flota[tipo].color,
                tamaño: flota[tipo].tamaño,
                orientacion: flota[tipo].orientacion, // respeta tu lógica
                posiciones: []
            });
        }
    }

    // Colocar cada barco aleatoriamente
    for (let barco of flotaCPU) {
        colocarBarcoCPU(barco);
    }

    console.log("Barcos CPU colocados:", ocupadas_compu);

    sessionStorage.setItem("ocupadas_compu", JSON.stringify(ocupadas_compu));
}


// -------------------------------------------------------
// Coloca un barco de manera aleatoria con tus reglas
// -------------------------------------------------------
function colocarBarcoCPU(barco) {
    const maxFilas = tablero.row;
    const maxCols = tablero.col;

    let colocado = false;

    while (!colocado) {

        // elegir posición aleatoria inicial
        const fila = Math.floor(Math.random() * maxFilas);
        const col = Math.floor(Math.random() * maxCols);

        // verificar límite
        if (!verificarPosicionCPU(barco, fila, col)) continue;

        // verificar choque
        if (!verificarChoqueCPU(barco, fila, col)) continue;

        // si pasa todo → ocupar celdas
        ocuparCeldasCPU(barco, fila, col);

        colocado = true;
    }
}


// -------------------------------------------------------
// Verifica límites (versión compu)
// -------------------------------------------------------
function verificarPosicionCPU(barco, fila, col) {
    const maxFilas = tablero.row;
    const maxCols  = tablero.col;

    if (barco.orientacion === "horizontal") {
        if (col + barco.tamaño > maxCols) return false;
    } else {
        if (fila + barco.tamaño > maxFilas) return false;
    }

    return true;
}


// -------------------------------------------------------
// Verifica choques con barcos CPU
// -------------------------------------------------------
function verificarChoqueCPU(barco, fila, col) {
    for (let i = 0; i < barco.tamaño; i++) {
        let f = fila;
        let c = col;

        if (barco.orientacion === "horizontal") {
            c = col + i;
        } else {
            f = fila + i;
        }

        if (ocupadas_compu.some(cell => cell.fila === f && cell.col === c)) {
            return false;
        }
    }

    return true;
}


// -------------------------------------------------------
// Ocupa las celdas en ocupadas_compu
// -------------------------------------------------------
function ocuparCeldasCPU(barco, fila, col) {
    for (let i = 0; i < barco.tamaño; i++) {
        let f = fila;
        let c = col;

        if (barco.orientacion === "horizontal") {
            c = col + i;
        } else {
            f = fila + i;
        }

        ocupadas_compu.push({
            fila: f,
            col:  c,
            barco: barco.tipo,
            orientacion: barco.orientacion,
            color: barco.color
        });
    }
}
