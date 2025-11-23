//busque las posiciones de los barcos.

//calcule las posiciones de los barcos random de la compu

//evalua jugada

//pedir pista

//guardar cambios 

//sacar event listener
document.addEventListener("DOMContentLoaded", () => {
    const cells = document.querySelectorAll(".cell");
    const cells_en = document.querySelectorAll(".cell_enemigo");

    
     cells_en.forEach(cell=>{
          cell.addEventListener("click", posicionElegida);

     });
    cells.forEach(cell => {
        cell.addEventListener("click", posicionElegida);
    });
});
