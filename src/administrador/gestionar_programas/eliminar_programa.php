<?php

session_start();

require_once __DIR__ . '/../../../config.php';
// Autenticación
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario != 'administrador') {
    $error = "Error de autenticación";
    header("Location: ../../login_form.html?error=$error");
    exit();
}

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

//Eliminar el mentor
$idPrograma = $_GET['idPrograma'];
$consulta = "DELETE FROM Programa WHERE idPrograma = '$idPrograma'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: listado_programas.php");
} else {
    echo "No se ha podido eliminar";
}
