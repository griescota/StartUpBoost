<?php

session_start();

require_once __DIR__ . '/../../config.php';
// Autenticación
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario != 'mentor') {
    $error = "Error de autenticación";
    header("Location: ../login_form.html?error=$error");
    exit();
}

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

$idStartup = $_POST['idStartup'];
$comentario = $_POST['comentario'];
$resultado = $_POST['resultado'];

//Insertar los datos en la base de datos
$consulta = "INSERT INTO Evaluacion (idStartup, comentario, resultado) VALUES ('$idStartup', '$comentario', '$resultado')";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: opciones_mentor.html");
} else {
    echo "No se ha podido insertar";
}
