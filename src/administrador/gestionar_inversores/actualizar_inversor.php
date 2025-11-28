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
$idInversor = $_POST['idInversor'];
$nombreInversor = $_POST['nombreInversor'];
$correo = $_POST['correo'];
$tlf = $_POST['tlf'];

function validarDatos($nombreInversor, $correo, $tlf)
{
    $errores = [];

    // Verificar que los campos no estén vacíos
    if (empty($nombreInversor) || empty($correo) || empty($tlf)) {
        echo ("Todos los campos son obligatorios.");
    }

    // Verificar formato de correo electrónico con expresión regular
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correo)) {
        echo ("El formato del correo electrónico no es válido.");
    }

    // Verificar formato de número de teléfono (solo números y al menos 9 dígitos)
    if (!preg_match('/^\d{9,}$/', $tlf)) {
        echo ("El formato del número de teléfono no es válido.");
    }

    // Si hay errores, se devuelve el array
    if (!empty($errores)) {
        return $errores;
    }

    // Si pasa todas las validaciones
    return null;
}

$validacion = validarDatos($nombreInversor, $correo, $tlf);

//Actualizar los datos en la base de datos
$consulta = "UPDATE Inversor SET nombreInversor = '$nombreInversor', correo = '$correo', tlf = '$tlf' WHERE idInversor = '$idInversor'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    header("Location: listado_inversores.php");
} else {
    echo "No se ha podido actualizar";
}
