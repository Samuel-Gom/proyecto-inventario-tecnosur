<?php

include('conexion.php');

// OBTENIENDO LOS VALORES
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['txtUsuario'];
    $password = $_POST['txtPassword'];
}

// PROCESAMIENTO DE LOS DATOS ENVIADOS
if (isset($_POST["btnIngresar"])) {
    if (!empty($usuario) && !empty($password)) {
        $sql = "SELECT * FROM login WHERE Usuario = '$usuario' AND Password = '$password'";
        $result = mysqli_query($cnx, $sql);

        if ($fila = mysqli_fetch_assoc($result)) {
            // VARIABLES DE SESION
            session_start();
            $_SESSION['autentificado'] = true;
            $_SESSION['nombres'] = $fila['Nombres'];
            $_SESSION['apellidos'] = $fila['Apellidos'];

            header('Location: home.php');
            exit();
        } else {
            header('Location: index.php?error=not-found');
            exit();
        }
    } else {
        header('Location: index.php?error=empty');
        exit();
    }
}

mysqli_close($cnx);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final - Iniciar Sesión</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="preload" href="./assets/font/Montserrat-VariableFont_wght.woff2" as="font" type="font/woff2" crossorigin>
    <script src="./js/view-password.js" defer></script>
</head>
<body>
    <section class="form form--login">
        <h1 class="form__title">Iniciar Sesiòn</h1>
        <form class="form__form" action="" method="post">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'not-found') {
                echo "<p class='form__info'>No se encontraron coincidencias</p>";
            }
            ?>
            <div class="form__container-input">
                <input class="form__input" name="txtUsuario" type="text" placeholder="Usuario">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <div class="form__container-input">
                <input id="password" class="form__input" name="txtPassword" type="password" placeholder="Contraseña">
                <button id="view-password" class="form__view-password" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg>
                </button>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'empty') {
                    echo "<span class='form__error'>Este campo es requerido</span>";
                }
                ?>
            </div>
            <input class="form__input form__input--submit" name="btnIngresar" type="submit" value="Ingresar">
        </form>
    </section>
</body>
</html>