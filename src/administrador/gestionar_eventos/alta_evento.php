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

//Evento: nombreEvento, tipo, descripcion, fechaIni, fechaFin, plazas, ubicacion 

$nombreEvento = $_POST['nombreEvento'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];
$plazas = $_POST['plazas'];
$ubicacion = $_POST['ubicacion'];
$sala = $_POST['sala'];

//Insertar los datos en la base de datos
$consulta = "INSERT INTO Evento (nombreEvento, tipo, descripcion, fechaIni, fechaFin, plazas, ubicacion, sala) VALUES ('$nombreEvento', '$tipo', '$descripcion', '$fechaIni', '$fechaFin', '$plazas', '$ubicacion', '$sala')";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: listado_eventos.php");
} else {
    echo "No se ha podido insertar";
}
