// MOSTRAR EL LISTADO CUANDO DEMOS CLICK EN EL BOTON RESPECTIVO - ARCHIVO HOME.PHP
const verCompra = document.querySelector("#ver-compra");
const listaCompra = document.querySelector("#lista-compra");
const verVenta = document.querySelector("#ver-venta");
const listaVenta = document.querySelector("#lista-venta");
const verProducto = document.querySelector("#ver-producto");
const listaProducto = document.querySelector("#lista-producto");

verCompra.addEventListener("click", function() {
    listaVenta.classList.remove("list-view");
    listaProducto.classList.remove("list-view");
    listaCompra.classList.add("list-view");
})

verVenta.addEventListener("click", function() {
    listaCompra.classList.remove("list-view");
    listaProducto.classList.remove("list-view");
    listaVenta.classList.add("list-view");
})

verProducto.addEventListener("click", function() {
    listaCompra.classList.remove("list-view");
    listaVenta.classList.remove("list-view");
    listaProducto.classList.add("list-view");
})