window.onload = function () {
     document
          .getElementById("registreUsuario")
          .addEventListener("click", function (e) {
               e.preventDefault();
               const nombre = document.getElementById("usuario").value;
               const password = document.getElementById("password").value;
               const email = document.getElementById("email").value;
               const fecha_nacimiento =
                    document.getElementById("fecha_nacimiento").value;
               const datosUsuario = {
                    nickname: nombre,
                    password: password,
                    email: email,
                    fechaNacimiento: fecha_nacimiento,
               };

               const json = JSON.stringify(datosUsuario);
               creaUsuario(json);
          });
};

function creaUsuario(usuario) {
     let xhr = new XMLHttpRequest();
     xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
               let respuesta = JSON.parse(xhr.responseText);
               gestionarRespuestas(respuesta);
          }
     };
     xhr.open("GET", "creaUsuario.php?obj=" + encodeURIComponent(usuario), true);
     xhr.send();
}

function gestionarRespuestas(usuario) {
     var p = document.getElementById("info");
     var exito = document.getElementById("exito");

     switch (true) {
          case (usuario.nombreExiste === false && usuario.nuevo):
               exito.innerText = "Registrado exitosamente";
               p.innerText = "";
               setTimeout(() => {
                    window.location.href = "../login.php";
               }, 2000); // 2000 ms = 2 segundos
               break;

          case (usuario.nombreExiste && usuario.nuevo === false):
               exito.innerText = "";
               p.innerText = "Ya existe un usuario con ese nombre, intente con otro";
               break;

          case (usuario.nombreExiste === false && usuario.menor):
               exito.innerText = "";
               p.innerText = "Debe ser mayor a 15 años";
               break;

          case (usuario.emailExiste && usuario.nuevo === false):
               exito.innerText = "";
               p.innerText = "Ya existe una cuenta asociada a ese email, intente con otro";
               break;

          default:
               exito.innerText = "";
               p.innerText = "hubo un error,intente de nuevo";
               break;
     }
}
