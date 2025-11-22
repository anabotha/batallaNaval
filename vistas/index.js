function selectPosition(event){
    if(ship.quantity > 0){
        let grid = event.target
        let gridID = grid.id.split(",");
        let x = parseInt(gridID[0]);
        let y = parseInt(gridID[1]);
        if(ship.position === "horizontal"){
            if((y + (ship.size - 1)) < 10){
                for(let i=y; i<(y + ship.size); i++){
                    matrix[x][i] = "ship";
                    document.getElementById(x + "," + i + "," + "player").className += " selected";
                }
                quantityShip[ship.id] -= 1;
                ship = {}
            }
            else{
                alert("Selecciona una posición válida");
            }
        }
        else if(ship.position === "vertical"){
            if((x + (ship.size - 1)) < 10){
                for(let i=x; i<(x + ship.size); i++){
                    matrix[i][y] = "ship";
                    document.getElementById(i + "," + y + "," + "player").className += " selected";
                }
                quantityShip[ship.id] -= 1;
                ship = {}
            }
            else{
                alert("Selecciona una posición válida");
            }
        }
    }
    else{
        alert("Debes seleccionar un barco disponible");
    }
}function checkPosition(pos, axis, size){
    if(shipRandom.position  === pos){
        if((axis + (size - 1)) < 10){
            return true;
        }
        else{
            return false;
        }
    }
}