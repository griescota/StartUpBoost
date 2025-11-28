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

$idEvento = $_POST['idEvento'];
$idInversor = $_POST['idInversor'];

// Consulta para obtener el nombre del inversor
$consultaNombre = "SELECT nombreInversor FROM Inversor WHERE idInversor = '$idInversor'";
$resultadoNombre = mysqli_query($conexion, $consultaNombre);
$fila = mysqli_fetch_assoc($resultadoNombre);
$nombreInversor = $fila['nombreInversor'];

// Consulta para obtener el nombre del evento
$consultaNombreEvento = "SELECT nombreEvento FROM Evento WHERE idEvento = '$idEvento'";
$resultadoNombreEvento = mysqli_query($conexion, $consultaNombreEvento);
$filaEvento = mysqli_fetch_assoc($resultadoNombreEvento);
$nombreEvento = $filaEvento['nombreEvento'];

//Insertar los datos en la base de datos
$consulta = "INSERT INTO Inversor_Evento (idEvento, idInversor) VALUES ('$idEvento', '$idInversor')";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $url = "justificante_inversor.html?nombreInversor=$nombreInversor&nombreEvento=$nombreEvento";
    header("Location: $url");
    //header("Location: listado_eventos.php");
} else {
    echo "No se ha podido insertar";
}
