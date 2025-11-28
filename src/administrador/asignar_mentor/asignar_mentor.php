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

//Recoger los datos del formulario
$idStartup = $_POST['idStartup'];
$idMentor = $_POST['idMentor'];

//Insertar los datos en la base de datos (tabla Startup: añadir idMentor)
$consulta = "UPDATE Startup SET idMentor = '$idMentor' WHERE idStartup = '$idStartup'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: ../opciones_administrador.html");
} else {
    echo "No se ha podido insertar";
}
