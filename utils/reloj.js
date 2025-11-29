document.addEventListener("DOMContentLoaded", () => {

     reloj();
     });

function reloj() {
  let tiempoTranscurrido = 0;

  intervaloReloj = setInterval(() => {
    tiempoTranscurrido++;

    const minutos = Math.floor(tiempoTranscurrido / 60);
    const segundos = tiempoTranscurrido % 60;

    const tiempoFormateado = 
      `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
    document.getElementById('tiempo').textContent = tiempoFormateado;
  }, 1000);
}

function detenerReloj() {
  clearInterval(intervaloReloj);
}