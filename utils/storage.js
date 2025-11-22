//local storage
function setLocal(key, value) {
     try {
          localStorage.setItem(key, JSON.stringify(value));
     } catch (e) {
          console.error("Error al guardar en localStorage:", e);
     }
}

function getLocal(key) {
     try {
          const item = localStorage.getItem(key);
          return item ? JSON.parse(item) : null;
     } catch (e) {
          console.error("Error al leer de localStorage:", e);
          return null;
     }
}
