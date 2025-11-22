<?php
//no srive BORRAR 
class Usuario {
     public $Usuarios;
     public $nickname;
     public $fechaNacimiento;
     public $PartidasJugadas;
     public $PartidasGanadas;
     public $idUsuario;
     public $email;

     public function __construct($Usuarios, $nickname, $fechaNacimiento, $email) {
          $this->Usuarios = $Usuarios;
          $this->nickname = $nickname;
          $this->fechaNacimiento = $fechaNacimiento;
          $this->PartidasJugadas =0;
          $this->PartidasGanadas =0;
          $this->email = $email;
     }
     public function esMayorDe15() {
          $fechaNacimiento = new DateTime($this->fechaNacimiento);
          $hoy = new DateTime();
          $edad = $hoy->diff($fechaNacimiento)->y;
          return $edad >= 15;
     }
}
?>