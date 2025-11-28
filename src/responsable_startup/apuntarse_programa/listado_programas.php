<?php

session_start();

require_once __DIR__ . '/../../../config.php';
// Autenticación
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario != 'responsable_startup') {
    $error = "Error de autenticación";
    header("Location: ../../login_form.html?error=$error");
    exit();
}

echo " <link rel='stylesheet' href='/../../../styles.css'>";

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

// Mostrar todos los programas en los que no esté apuntado el startup
$idStartup = $_SESSION['id'];
$consulta = "SELECT * FROM Programa WHERE idPrograma NOT IN (SELECT idPrograma FROM Programa_startup WHERE idStartup = '$idStartup')";
$resultado = mysqli_query($conexion, $consulta);

$num_filas = mysqli_num_rows($resultado);
echo "<h1 class='titulo'>Programas</h1>";
echo "<hr class='hr4'>";
if ($num_filas == 0) {
    echo "<p>No hay programas disponibles</p>";
    exit();
}
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Tipo</th>";
echo "<th>Descripción</th>";
echo "<th>Duración</th>";
echo "<th>Apuntarse</th>";
echo "</tr>";
while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['nombrePrograma'] . "</td>";
    echo "<td>" . $fila['tipo'] . "</td>";
    echo "<td>" . $fila['descripcion'] . "</td>";
    echo "<td>" . $fila['duracion'] . "</td>";
    echo "<td><a href='apuntarse_programa.php?idPrograma=" . $fila['idPrograma'] . "'>Apuntarse</a></td>";
    echo "</tr>";
}

echo "</table>";
