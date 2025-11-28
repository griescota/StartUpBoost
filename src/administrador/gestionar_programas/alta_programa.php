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
$nombrePrograma = $_POST['nombrePrograma'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];

function validarDatos($nombrePrograma, $tipo, $descripcion, $duracion)
{
    $errores = [];

    // Verificar que los campos no estén vacíos
    if (empty($nombrePrograma) || empty($tipo) || empty($descripcion) || empty($duracion)) {
        return $errores = "Todos los campos son obligatorios.";
    }
    return null;
}

$validacion = validarDatos($nombrePrograma, $tipo, $descripcion, $duracion);

if ($validacion !== null) {
    $error = $validacion;
    header("Location: form_intro_datos_programa.html?error=$error");
    exit();
} else {

    //Insertar los datos en la base de datos
    $consulta = "INSERT INTO Programa (nombrePrograma, tipo, descripcion, duracion) VALUES ('$nombrePrograma', '$tipo', '$descripcion', '$duracion')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        header("Location: listado_programas.php");
    } else {
        $error = "No se ha podido insertar.";
        header("Location: form_intro_datos_startup.html?error=$error");
        exit();
    }
}
