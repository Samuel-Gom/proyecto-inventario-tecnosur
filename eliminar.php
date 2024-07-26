<?php

include("conexion.php");

$id;
$tabla;
$campo;

if (isset($_GET['idCompra'])) {
    $id = $_GET['idCompra'];
    $tabla = 'compra';
    $campo = 'IdCompra';
} else if (isset($_GET['idVenta'])) {
    $id = $_GET['idVenta'];
    $tabla = 'venta';
    $campo = 'IdVenta';
} else {
    $id = $_GET['idProducto'];
    $tabla = 'producto';
    $campo = 'IdProducto';
}

$sql = "DELETE FROM $tabla WHERE $campo = $id";

$result = mysqli_query($cnx, $sql);

mysqli_close($cnx);

header('Location: home.php');
exit();

?>