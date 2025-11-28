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

echo " <link rel='stylesheet' href='/../../../styles.css'>";

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

$idMentor = $_GET['idMentor'];

// Mostrar todas las startups que no tengan mentor (startup guarda un parametro idMentor ) mostrar todas las startups que no tengan mentor
$consulta = "SELECT * FROM Startup WHERE idMentor IS NULL";
$resultado = mysqli_query($conexion, $consulta);

$num_filas = mysqli_num_rows($resultado);

echo "<h1>Startups</h1>";
if ($num_filas == 0) {
    echo "No hay startups disponibles";
    exit();
}
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Descripción</th>";
echo "<th>Sector</th>";
echo "<th>Estado</th>";
echo "<th>Correo</th>";
echo "<th>Teléfono</th>";
echo "<th>Asignar</th>";
echo "</tr>";

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['nombreStartup'] . "</td>";
    echo "<td>" . $fila['descripcion'] . "</td>";
    echo "<td>" . $fila['sector'] . "</td>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>" . $fila['correo'] . "</td>";
    echo "<td>" . $fila['tlf'] . "</td>";
    echo "<td><a href='form_asignar_mentor.html?idMentor=" . $idMentor . "&idStartup=" . $fila['idStartup'] . "' class='boton-estilo'>Asignar</a></td>";
    echo "</tr>";
}
echo "</table>";
