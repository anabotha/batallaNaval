<?php
class Barco {
    public string $color;
    public int $cantidad;
    public string $orientacion; 
    public int $tamaño; 
    public function __construct($color, $cantidad, $orientacion,$tamaño) {
        $this->color = $color;
        $this->cantidad = $cantidad;
        $this->orientacion = $orientacion;
        $this->tamaño = $tamaño;
    }
}
?>