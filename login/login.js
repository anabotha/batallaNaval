
let jugador;

window.onload = function () {
     sessionStorage.clear();
     document.getElementById("inicio").addEventListener("click", function (e) {
          e.preventDefault(); 
          buscaNombre(document.getElementById("usuario").value,document.getElementById("password").value);
     });
     
}

function buscaNombre(usuario, contraseña) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "buscaUsuario.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            let respuesta = JSON.parse(xhr.responseText);
            gestionarRtas(respuesta);
        }
    };

    let data = new FormData();
    data.append("nick", usuario);
    data.append("password", contraseña);

    xhr.send(data); 
}

function finLogueo(){
          //pase a otra vista
          const btnLobby = document.createElement("button");
          btnLobby.textContent = " IR A LOBBY ";
          btnLobby.id = "btnLobby";
          btnLobby.className="btnLobby";
          const body = document.getElementById("body");
          body.appendChild(btnLobby);
          btnLobby.addEventListener("click",irLobby);//direcciona
          setTimeout(() => {
               irLobby();
          }, 1000); 
     
}

function gestionarRtas(rta){
     console.log(rta);
     if(rta.existe && !rta.enUso){
          if(rta.contra){
               const p=document.getElementById("info");
               p.innerText="";
               sessionStorage.setItem("user",rta.nickname);
               jugador=rta.nickname;
               finLogueo();
          }else{
               limpiarCampos();
               const p=document.getElementById("info");
               p.innerText="Contraseña incorrecta";
          }
     }
          else if(!rta.existe){
               limpiarCampos();
               const p=document.getElementById("info");
               p.innerText=" No tenes usuario? Registrate!";
     }
}

function irLobby() {
    window.location.href = "../lobby/lobby.php";
}


function limpiarCampos() {
     const usuario = document.getElementById("usuario");
     const password = document.getElementById("password");
     const info = document.getElementById("info");

     if (usuario) usuario.value = "";
     if (password) password.value = "";
     if (info) info.textContent = "";
}


