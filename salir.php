<?php

include('conexion.php');
session_start();

// ELIMINAMOS LOS DATOS Y LAS VARIABLES DE SESION
session_unset();
session_destroy();

header('Location: index.php');
exit();

?>