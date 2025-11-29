
document.addEventListener("DOMContentLoaded", () => {
    // Lista de grupos de colores por barco
    const grupos = [
        "color_acorazados",
        "color_destructores",
        "color_submarinos",
        "color_portaviones",
    ];

    function actualizarColores() {
        // Obtener el color seleccionado en cada grupo
        const usados = new Set();

        grupos.forEach(name => {
            const sel = document.querySelector(`input[name="${name}"]:checked`);
            if (sel) usados.add(sel.value);
        });

        // Por cada grupo, deshabilitar colores ya usados en los otros grupos
        grupos.forEach(name => {
            const radios = document.querySelectorAll(`input[name="${name}"]`);
            radios.forEach(radio => {
                const color = radio.value;
                const seleccionado = radio.checked;

                // Si el color está usado en otro grupo, bloquearlo
                if (usados.has(color) && !seleccionado) {
                    radio.disabled = true;
                } else {
                    radio.disabled = false;
                }
            });
        });
    }

    // Agregar listeners a todos los radios de color
    grupos.forEach(name => {
        const radios = document.querySelectorAll(`input[name="${name}"]`);
        radios.forEach(radio => {
            radio.addEventListener("change", actualizarColores);
        });
    });

    // Ejecutar al cargar
    actualizarColores();
});

