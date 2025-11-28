<?php

session_start();

require_once __DIR__ . '/../config.php';

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

$tipoUsuario = $_POST['tipoUsuario'];
$idUsuario = $_POST['idUsuario'];

switch ($tipoUsuario) {
    case 'administrador':
        $_SESSION['tipoUsuario'] = $tipoUsuario;
        header("Location: administrador/opciones_administrador.html");
        break;
    case 'responsable_startup':
        $consulta = "SELECT * FROM Startup WHERE idStartup = '$idUsuario'";
        $resultado = mysqli_query($conexion, $consulta);
        $numFilas = mysqli_num_rows($resultado);
        if ($numFilas > 0) {
            $_SESSION['id'] = $idUsuario;
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            header("Location: responsable_startup/opciones_startup.html");
        } else {
            header("Location: login_form.html");
        }
        break;
    case 'inversor':
        $consulta = "SELECT * FROM Inversor WHERE idInversor = '$idUsuario'";
        $resultado = mysqli_query($conexion, $consulta);
        $numFilas = mysqli_num_rows($resultado);
        if ($numFilas > 0) {
            $_SESSION['id'] = $idUsuario;
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            header("Location: inversor/opciones_inversor.html");
        } else {
            header("Location: login_form.html");
        }
        break;
    case 'mentor':
        $consulta = "SELECT * FROM Mentor WHERE idMentor = '$idUsuario'";
        $resultado = mysqli_query($conexion, $consulta);
        $numFilas = mysqli_num_rows($resultado);
        if ($numFilas > 0) {
            $_SESSION['id'] = $idUsuario;
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            header("Location: mentor/opciones_mentor.html");
        } else {
            header("Location: login_form.html");
        }
        break;
    default:
        header("Location: login_form.html");
        break;
}
