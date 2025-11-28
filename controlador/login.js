
let jugador;

window.onload = function () {
     // deleteAllCookies();
     document.getElementById("inicio").addEventListener("click", function (e) {
          e.preventDefault(); 
          buscaNombre(document.getElementById("usuario").value,document.getElementById("password").value);
     });
     
}

function buscaNombre(usuario, contraseña) {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
            let respuesta = JSON.parse(xhr.responseText);
            gestionarRtas(respuesta);
        }
    };
     // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    console.log(usuario,contraseña);
    let data = new FormData();
    data.append("nick", usuario);
    data.append("password", contraseña);
    xhr.open("POST", "../controlador/buscaUsuario.php", true);
    console.log(data);
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
               setCookie("user",rta.nickname,1);
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

function irLobby(){//direcciona a la siguiente vista

     const req = new XMLHttpRequest()
     req.open('POST','../vistas/lobby.php',true)
     req.onreadystatechange = ()=>{
          if(req.readyState ==4 && req.status == 200){
               setTimeout(()=>{
                    window.location.href = "../vistas/lobby.php";
               },500)
          }
     }
     req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
     console.log("jugaodr"+jugador);
     req.send(jugador)

}

function limpiarCampos() {
     const usuario = document.getElementById("usuario");
     const password = document.getElementById("password");
     const info = document.getElementById("info");

     if (usuario) usuario.value = "";
     if (password) password.value = "";
     if (info) info.textContent = "";
}
function irARanking(){
     window.location.href="../vistas/ranking.php"
}

