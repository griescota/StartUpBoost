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

//Eliminar el inversor
$idInversor = $_GET['idInversor'];

// Primero, eliminar las referencias en la tabla Inversor_Evento
$consultaEliminarReferencias = "DELETE FROM Inversor_Evento WHERE idInversor = '$idInversor'";
$resultadoReferencias = mysqli_query($conexion, $consultaEliminarReferencias);

// Ahora, eliminar el inversor de la tabla Inversor
$consulta = "DELETE FROM Inversor WHERE idInversor = '$idInversor'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: listado_inversores.php");
} else {
    echo "No se ha podido eliminar";
}
