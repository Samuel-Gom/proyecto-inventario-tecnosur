<?php

include('conexion.php');
session_start();

// VERIFICAMOS SI LA SESION NO ESTA INICIADA, LO MANDAMOS A INDEX
if (!isset($_SESSION['autentificado'])) {
    header('Location: salir.php');
    exit();
}

$compra = "SELECT c.IdCompra, c.Fecha, c.NroDoc, c.Proveedor, c.RucProveedor, c.IdProducto, c.Cantidad, p.NombreProducto
        FROM compra AS c
        JOIN producto AS p ON c.IdProducto = p.IdProducto";

$venta = "SELECT v.IdVenta, v.Fecha, v.NroDoc, v.Cliente, v.Ruc, v.IdProducto, v.Cantidad, p.NombreProducto
        FROM venta AS v
        JOIN producto AS p ON v.IdProducto = p.IdProducto";;

$producto = "SELECT * FROM producto";

$resultCompra = mysqli_query($cnx, $compra);
$resultVenta = mysqli_query($cnx, $venta);
$resultProducto = mysqli_query($cnx, $producto);

mysqli_close($cnx);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final - Home</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="preload" href="./assets/font/Montserrat-VariableFont_wght.woff2" as="font" type="font/woff2" crossorigin>
    <script src="./js/view-list.js" defer></script>
</head>
<body>
    <main class="container">
        <div class="texts">
            <h1 class="welcome">
                <?php
                echo $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'] ;
                ?>
            </h1>
            <a class="logout" href="salir.php">
                <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
            </a>
        </div>
        <div class="options">
            <button id="ver-compra" class="btn-option">Ver lista de compras</button>
            <button id="ver-venta" class="btn-option">Ver lista de ventas</button>
            <button id="ver-producto" class="btn-option">Ver productos</button>
        </div>
        <section id="lista-compra" class="list-container">
            <div class="list-texts">
                <h2 class="title">Listado de compras registradas</h2>
                <a class="btn" href="compra.php">
                <p class="paragraph">Nuevo</p>
                <span class="icon">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg>
                </span>
                </a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Nro Documento</th>
                            <th>Proveedor</th>
                            <th>Ruc Proveedor</th>
                            <th>Id Producto</th>
                            <th>Cantidad</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($fila = mysqli_fetch_assoc($resultCompra))
                        {
                            echo "<tr>";
                            echo "<td>" . $fila['IdCompra'] . "</td>";
                            echo "<td>" . $fila['Fecha'] . "</td>";
                            echo "<td>" . $fila['NroDoc'] . "</td>";
                            echo "<td>" . $fila['Proveedor'] . "</td>";
                            echo "<td>" . $fila['RucProveedor'] . "</td>";
                            echo "<td title='" . $fila['NombreProducto'] . "'>" . $fila['IdProducto'] . "</td>";
                            echo "<td>" . $fila['Cantidad'] . "</td>";
                            echo 
                            "<td>
                                <a class='opc opc--edit' href='compra.php?idCompra=" . $fila['IdCompra'] . "&fecha=" . $fila['Fecha'] . "&nroDoc=" . $fila['NroDoc'] . "&proveedor=" . $fila['Proveedor'] . "&rucProveedor=" . $fila['RucProveedor'] . "&idProducto=" . $fila['IdProducto'] . "&cantidad=" . $fila['Cantidad'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                                    </svg>
                                </a>
                                <a class='opc opc--delete' href='eliminar.php?idCompra=" . $fila['IdCompra'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5'/>
                                    </svg>
                                </a>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="lista-venta" class="list-container">
            <div class="list-texts">
                <h2 class="title">Listado de ventas registradas</h2>
                <a class="btn" href="venta.php">
                    <p class="paragraph">Nuevo</p>
                    <span class="icon">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg>
                    </span>
                </a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Nro Documento</th>
                            <th>Cliente</th>
                            <th>Ruc</th>
                            <th>Id Producto</th>
                            <th>Cantidad</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($fila = mysqli_fetch_assoc($resultVenta))
                        {
                            echo "<tr>";
                            echo "<td>" . $fila['IdVenta'] . "</td>";
                            echo "<td>" . $fila['Fecha'] . "</td>";
                            echo "<td>" . $fila['NroDoc'] . "</td>";
                            echo "<td>" . $fila['Cliente'] . "</td>";
                            echo "<td>" . $fila['Ruc'] . "</td>";
                            echo "<td title='" . $fila['NombreProducto'] . "'>" . $fila['IdProducto'] . "</td>";
                            echo "<td>" . $fila['Cantidad'] . "</td>";
                            echo 
                            "<td>
                                <a class='opc opc--edit' href='venta.php?idVenta=" . $fila['IdVenta'] . "&fecha=" . $fila['Fecha'] . "&nroDoc=" . $fila['NroDoc'] . "&cliente=" . $fila['Cliente'] . "&ruc=" . $fila['Ruc'] . "&idProducto=" . $fila['IdProducto'] . "&cantidad=" . $fila['Cantidad'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                                    </svg>
                                </a>
                                <a class='opc opc--delete' href='eliminar.php?idVenta=" . $fila['IdVenta'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5'/>
                                    </svg>
                                </a>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section id="lista-producto" class="list-container">
            <div class="list-texts">
                <h2 class="title">Listado de productos</h2>
                <a class="btn" href="producto.php">
                    <p class="paragraph">Nuevo</p>
                    <span class="icon">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg>
                    </span>
                </a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre Producto</th>
                            <th>Cantidad</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($fila = mysqli_fetch_assoc($resultProducto))
                        {
                            echo "<tr>";
                            echo "<td>" . $fila['IdProducto'] . "</td>";
                            echo "<td>" . $fila['NombreProducto'] . "</td>";
                            echo "<td>" . $fila['Cantidad'] . "</td>";
                            echo 
                            "<td>
                                <a class='opc opc--edit' href='producto.php?idProducto=" . $fila['IdProducto'] . "&nombreProducto=" . $fila['NombreProducto'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                                    </svg>
                                </a>
                                <a class='opc opc--delete' href='eliminar.php?idProducto=" . $fila['IdProducto'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='opc-icon' viewBox='0 0 16 16'>
                                    <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5'/>
                                    </svg>
                                </a>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>