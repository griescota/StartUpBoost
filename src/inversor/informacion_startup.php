<?php

session_start();

require_once __DIR__ . '/../../config.php';

// Autenticación
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario != 'inversor') {
    $error = "Error de autenticación";
    header("Location: ../login_form.html?error=$error");
    exit();
}

echo " <link rel='stylesheet' href='/../../../styles.css'>";



//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

$idStartup = $_GET['idStartup'];
$nombreStartup = $_GET['nombreStartup'];
$descripcion = $_GET['descripcion'];
$sector = $_GET['sector'];
$estado = $_GET['estado'];
$correo = $_GET['correo'];
$tlf = $_GET['tlf'];

$idInversor = $_SESSION['id'];

// Si el inversor ya ha invertido en la startup, no mostrar el botón de invertir
// Si el inversor no ha invertido en la startup, mostrar el botón de invertir
$consulta = "SELECT * FROM Inversion WHERE idStartup = '$idStartup' AND idInversor = '$idInversor'";
$resultado = mysqli_query($conexion, $consulta);

$numFilas = mysqli_num_rows($resultado);
if ($numFilas > 0) {
    $invertido = true;
} else {
    $invertido = false;
}

echo "<h1>Información de la startup</h1>";
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Descripción</th>";
echo "<th>Sector</th>";
echo "<th>Estado</th>";
echo "<th>Correo</th>";
echo "<th>Teléfono</th>";
echo "<th>Invertir</th>";
echo "</tr>";
echo "<tr>";
echo "<td>$nombreStartup</td>";
echo "<td>$descripcion</td>";
echo "<td>$sector</td>";
echo "<td>$estado</td>";
echo "<td>$correo</td>";
echo "<td>$tlf</td>";
if ($invertido) {
    echo "<td><a href='../inversor/listado_startups.php'>Ya has invertido en esta startup</a></td>";
} else {
    echo "<td><a href='form_invertir_startup.html?idStartup=$idStartup'>Invertir</a></td>";
}
echo "</tr>";
echo "</table>";
