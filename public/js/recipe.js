document.addEventListener('DOMContentLoaded', function () {
    const botonIngrediente = document.getElementById('agregarIngrediente');
    const botonPasos = document.getElementById('agregarPasos');

    // Agrega un evento de clic al botón Agregar Ingrediente
    botonIngrediente.addEventListener('click', function () {
        console.log('¡Agregaste un ingrediente!');
    });
    // Agrega un evento de clic al botón Agregar Pasos
    botonPasos.addEventListener('click', function () {
        console.log('¡Agregaste un Paso!');
    });
});