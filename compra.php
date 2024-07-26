<?php

include('conexion.php');

// OBTENIENDO LOS VALORES
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['txtId'];
    $fecha = $_POST['txtFecha'];
    $nroDoc = $_POST['txtNroDoc'];
    $proveedor = $_POST['txtProveedor'];
    $rucProveedor = $_POST['txtRucProveedor'];
    $idProducto = $_POST['txtProducto'];
    $cantidad = $_POST['txtCantidad'];
}

// PROCESAMIENTO DE LOS DATOS ENVIADOS
if (isset($_POST["btnRegistrar"])) {
    if (!empty($fecha) && !empty($nroDoc) && !empty($proveedor) && !empty($rucProveedor) && !empty($idProducto) && !empty($cantidad)) {
        // SI ID ES MAYOR A 0 (QUE LO VA SER CUANDO SE QUIERA EDITAR), EDITAMOS, SINO INSERTAMOS
        if ($id > 0) {
            $sql = "UPDATE compra SET Fecha='$fecha', NroDoc='$nroDoc', Proveedor='$proveedor',            RucProveedor='$rucProveedor', IdProducto='$idProducto', Cantidad='$cantidad'
            WHERE IdCompra = $id";
        } else {
            $sql = "INSERT INTO compra (Fecha, NroDoc, Proveedor, RucProveedor, IdProducto, Cantidad)
                    VALUES ('$fecha', '$nroDoc', '$proveedor', '$rucProveedor', '$idProducto', '$cantidad')";
        }

        $result = mysqli_query($cnx, $sql);

        if ($result) {
            if (!isset($_GET['idCompra'])) {
                echo "<script>alert('Registro exitoso')</script>";
            } else {
                // ESTO SUCEDE CUANDO EDITAMOS, CUANDO EL USUARIO EDITE, LO MANDAMOS A HOME
                header('Location: home.php');
                exit();
            }
        } else {
            echo "<script>alert('Ocurrio un error')</script>";
        }
    } else {
        header('Location: compra.php?error=empty');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final - Compra</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="preload" href="./assets/font/Montserrat-VariableFont_wght.woff2" as="font" type="font/woff2" crossorigin>
    <script src="./js/change-color.js" defer></script>
</head>
<body>
    <section class="form form--wrap">
        <div class="texts">
            <p class="return">Regresar</p>
            <a class="logout" href="home.php">
                <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
            </a>
        </div>
        <h1 class="form__title">Formulario Compra</h1>
        <form class="form__form form__form--wrap" action="" method="post">
            <input type="hidden" name="txtId" value="<?php echo isset($_GET['idCompra']) ? $_GET['idCompra'] : ''; ?>">
            <div class="form__container-input">
                <input id="txtFecha" class="form__input form__input--date" name="txtFecha" type="date" placeholder="Fecha" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <input class="form__input" name="txtNroDoc" type="text" placeholder="Número de documento" value="<?php echo isset($_GET['nroDoc']) ? $_GET['nroDoc'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <input class="form__input" name="txtProveedor" type="text" placeholder="Proveedor" value="<?php echo isset($_GET['proveedor']) ? $_GET['proveedor'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <input class="form__input" name="txtRucProveedor" type="text" placeholder="Ruc Proveedor" value="<?php echo isset($_GET['rucProveedor']) ? $_GET['rucProveedor'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <select id="cmbProducto" class="form__input form__input--select" name="txtProducto">
                    <option value="" selected disabled>Seleccionar producto</option>
                    <?php
                    $sql = 'SELECT * FROM producto';
                    $result = mysqli_query($cnx, $sql);

                    while($fila = mysqli_fetch_assoc($result)) {
                        // VERIFICAMOS SI EXISTE IDPRODUCTO POR GET, Y LO ASIGNAMOS A ESTA VARIABLE PARA SELECCIONARLO POR DEFECTO
                        $selected = isset($_GET['idProducto']) && $_GET['idProducto'] == $fila['IdProducto'] ? 'selected' : '';

                        echo "<option value='" . $fila['IdProducto'] . "'" . $selected . ">"  . $fila['NombreProducto'] . "</option>";
                    }

                    mysqli_close($cnx);
                    ?>
                </select>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <input class="form__input" name="txtCantidad" type="number" placeholder="Cantidad" value="<?php echo isset($_GET['cantidad']) ? $_GET['cantidad'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <input class="form__input form__input--submit" name="btnRegistrar" type="submit" value="<?php echo isset($_GET['idCompra']) ? 'Editar compra' : 'Registrar compra'; ?>">
        </form>
    </section>
</body>
</html>