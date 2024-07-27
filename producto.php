<?php

include('conexion.php');

// OBTENIENDO LOS VALORES
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['txtId'];
    $nombreProducto = $_POST['txtNombreProducto'];
}

// PROCESAMIENTO DE LOS DATOS ENVIADOS
if (isset($_POST["btnRegistrar"])) {
    if (!empty($nombreProducto)) {
        // SI ID ES MAYOR A 0 (QUE LO VA SER CUANDO SE QUIERA EDITAR), EDITAMOS, SINO INSERTAMOS
        if ($id > 0) {
            $sql = "UPDATE producto SET NombreProducto='$nombreProducto'
                    WHERE IdProducto = $id";
        } else {
            $sql = "INSERT INTO producto (NombreProducto)
                    VALUES ('$nombreProducto')";
        }

        $result = mysqli_query($cnx, $sql);

        if ($result) {
            if (!isset($_GET['idProducto'])) {
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
        header('Location: producto.php?error=empty');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final - Venta</title>
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
        <h1 class="form__title">Formulario Producto</h1>
        <form class="form__form" action="" method="post">
            <input type="hidden" name="txtId" value="<?php echo isset($_GET['idProducto']) ? $_GET['idProducto'] : ''; ?>">
            <div class="form__container-input">
                <input class="form__input" name="txtNombreProducto" type="text" placeholder="Nombre del producto" value="<?php echo isset($_GET['nombreProducto']) ? $_GET['nombreProducto'] : ''; ?>">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <input class="form__input form__input--submit" name="btnRegistrar" type="submit" value="<?php echo isset($_GET['idProducto']) ? 'Editar producto' : 'Registrar producto'; ?>">
        </form>
    </section>
</body>
</html>