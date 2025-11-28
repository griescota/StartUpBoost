<?php

session_start();

function mostrar_mensaje($error)
{
    $mostrar_error = <<<ERRORES
   <script languaje="javascript" type="text/javascript">
   alert("$error");
    </script>
ERRORES;
    echo $mostrar_error;
}

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

$aceptar = $_POST['aceptar'];
$rechazar = $_POST['rechazar'];
$idStartup = $_POST['idStartup'];
$nuevoEstado = "";
if ($aceptar != null) {
    $nuevoEstado = "aceptada";
} else {
    $nuevoEstado = "rechazada";
}

//Cambiar el estado de la startup
$consulta = "UPDATE Startup SET estado = '$nuevoEstado' WHERE idStartup = '$idStartup'";
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    mostrar_mensaje("No se ha podido cambiar el estado de la startup");
    exit();
}

//Redirigir a opciones de administrador
header("Location: ../opciones_administrador.html");
