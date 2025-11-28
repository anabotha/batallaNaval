window.onload = function () {
    document
        .getElementById("registreUsuario")
        .addEventListener("click", function (e) {
            e.preventDefault();
            const nombre = document.getElementById("usuario").value;
            const password = document.getElementById("password").value;
            const email = document.getElementById("email").value;

            const datosUsuario = {
                nickname: nombre,
                password: password,
                email: email,
            };

            const json = JSON.stringify(datosUsuario);
            creaUsuario(json);
        });
};

function creaUsuario(usuarioJson) {
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let respuesta = JSON.parse(xhr.responseText);
            gestionarRespuestas(respuesta);
        }
    };

    xhr.open("POST", "creaUsuario.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send("obj=" + encodeURIComponent(usuarioJson)); 
}


function gestionarRespuestas(usuario) {
     var p = document.getElementById("info");
     var exito = document.getElementById("exito");

     switch (true) {
          case (usuario.nombreExiste === false && usuario.nuevo):
               exito.innerText = "Registrado exitosamente";
               p.innerText = "";
               setTimeout(() => {
                    window.location.href = "../loginView.php";
               }, 2000); 
               break;

          case (usuario.nombreExiste && usuario.nuevo === false):
               exito.innerText = "";
               p.innerText = "Ya existe un usuario con ese nombre, intente con otro";
               break;


          case (usuario.emailExiste && usuario.nuevo === false):
               exito.innerText = "";
               p.innerText = "Ya existe una cuenta asociada a ese email, intente con otro";
               break;

          default:
               exito.innerText = "";
               p.innerText = usuario.mensaje;
               break;
     }
}
