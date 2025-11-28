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

echo "<link rel='stylesheet' href='../../../styles.css'>";

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

//Evento: nombreEvento, tipo, descripcion, fechaIni, fechaFin, plazas, ubicacion
$idEvento = $_SESSION['idEvento'];
$nombreEvento = $_SESSION['nombreEvento'];
$tipo = $_SESSION['tipo'];
$descripcion = $_SESSION['descripcion'];
$fechaIni = $_SESSION['fechaIni'];
$fechaFin = $_SESSION['fechaFin'];
$plazas = $_SESSION['plazas'];
$ubicacion = $_SESSION['ubicacion'];
$sala = $_SESSION['sala'];

//Mostrar tabla con los datos del evento
echo "<h1>Evento</h1>";
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Tipo</th>";
echo "<th>Descripción</th>";
echo "<th>Fecha inicio</th>";
echo "<th>Fecha fin</th>";
echo "<th>Plazas</th>";
echo "<th>Ubicación</th>";
echo "<th>Sala</th>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $nombreEvento . "</td>";
echo "<td>" . $tipo . "</td>";
echo "<td>" . $descripcion . "</td>";
echo "<td>" . $fechaIni . "</td>";
echo "<td>" . $fechaFin . "</td>";
echo "<td>" . $plazas . "</td>";
echo "<td>" . $ubicacion . "</td>";
echo "<td>" . $sala . "</td>";
echo "</tr>";
echo "</table>";

//BOTONES
//Eliminar evento 
echo "<div>";

echo "<a href='form_eliminar_evento.html?idEvento=" . $idEvento . "'>Eliminar evento</a><br><br>";

//Inscribir startup
echo "<a href='form_inscribir_startup.html?idEvento=" . $idEvento . "'>Inscribir startup</a><br><br>";

//Inscribir inversor
echo "<a href='form_inscribir_inversor.html?idEvento=" . $idEvento . "'>Inscribir inversor</a><br><br>";

echo "</div>";
