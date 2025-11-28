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

$idInversor = $_SESSION['id'];

$consulta = "SELECT * FROM Startup";
$resultado = mysqli_query($conexion, $consulta);

$numero_filas = mysqli_num_rows($resultado);
$numero_columnas = mysqli_num_fields($resultado);

echo "<h1>Startups</h1>";
echo "<table><tr>";
echo "<th>Nombre Startup</th><th>Información</th>"; // Only display Name and Invertir button
echo "</tr>";

for ($i = 0; $i < $numero_filas; $i++) {
    $fila = mysqli_fetch_array($resultado);
    echo "<tr>";

    // Display only the name of the startup
    echo "<td>" . $fila['nombreStartup'] . "</td>";

    // Pass all parameters in the URL
    $parameters = http_build_query(array(
        'idStartup' => $fila['idStartup'],
        'nombreStartup' => $fila['nombreStartup'],
        'descripcion' => $fila['descripcion'],
        'sector' => $fila['sector'],
        'estado' => $fila['estado'],
        'correo' => $fila['correo'],
        'tlf' => $fila['tlf']
    ));

    // Display the "Invertir" button with a link to the form
    echo "<td><a href='informacion_startup.php?$parameters'>Más información</a></td>";

    echo "</tr>";
}

echo "</table>";





/*
$consulta = "SELECT * FROM Programa WHERE idPrograma NOT IN (SELECT idPrograma FROM Programa_startup WHERE idStartup = '$idStartup')";
$resultado = mysqli_query($conexion, $consulta);

$num_filas = mysqli_num_rows($resultado);
echo "<h1>Programas</h1>";
if ($num_filas == 0) {
    echo "No hay programas disponibles";
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
}*/