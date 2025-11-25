<?php
//no srive BORRAR 
class Usuario {
     public $Usuarios;
     public $nickname;
     public $idUsuario;
     public $email;

     public function __construct($Usuarios, $nickname, $email) {
          $this->Usuarios = $Usuarios;
          $this->nickname = $nickname;
          $this->email = $email;
     }
     
}
?>