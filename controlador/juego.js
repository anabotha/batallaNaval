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

const posicionElegida=(e)=>{
    console.log(e.target.id)
}

//calcule las posiciones de los barcos random de la compu

//evalua jugada

//pedir pista

//guardar cambios 

//sacar event listener
document.addEventListener("DOMContentLoaded", () => {
    const cells = document.querySelectorAll(".cell");
    const cells_en = document.querySelectorAll(".cell_enemigo");

    
    const ocupadas = JSON.parse(sessionStorage.getItem("ocupadas") || "[]");
    console.log(ocupadas);

    colorearCeldasOcupadas(ocupadas);

     cells_en.forEach(cell=>{
          cell.addEventListener("click", posicionElegida);

     });
    cells.forEach(cell => {
        cell.addEventListener("click", posicionElegida);
    });
});
