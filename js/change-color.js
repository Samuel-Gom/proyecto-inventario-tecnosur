// CAMBIAR DE COLOR LOS INPUT SELECT Y FECHA, CUANDO SE SELECCIONE UN VALOR - ARCHIVO COMPRA.PHP Y VENTA.PHP
const producto = document.getElementById("cmbProducto");
const fecha = document.getElementById("txtFecha");

cambiarColorTexto(producto);
cambiarColorTexto(fecha);

function cambiarColorTexto(elemento) {
    elemento.addEventListener("change", function() {
        elemento.classList.add("form__input--change");
    });

    if (elemento.value !== '') {
        elemento.classList.add("form__input--change");
    }
}