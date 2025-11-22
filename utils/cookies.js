//cookies
function setCookie(nombre, valor, dias) {
     const d = new Date();
     d.setTime(d.getTime() + (dias * 24 * 60 * 60 * 1000)); // días → ms
     const expiracion = "expires=" + d.toUTCString();
     document.cookie = `${nombre}=${valor}; ${expiracion}; path=/`;
}

function getCookie(nombre) { //
     const nombreEQ = nombre + "=";
     const cookies = document.cookie.split(";");

     for (let i = 0; i < cookies.length; i++) {
          let c = cookies[i].trim();
          if (c.indexOf(nombreEQ) === 0) {
               return c.substring(nombreEQ.length);
          }
     }
     return null;
}

function deleteCookie(nombre) {
     document.cookie = `${nombre}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
}
function deleteAllCookies() {
const cookies = document.cookie.split(";");

for (let cookie of cookies) {
     const nombre = cookie.split("=")[0].trim();
     document.cookie = `${nombre}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
}
}
