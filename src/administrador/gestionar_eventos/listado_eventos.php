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

echo "<link rel='stylesheet' href='/../../../styles.css'>";

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

//Obtener todos los eventos
$consulta = "SELECT * FROM Evento";
$resultado = mysqli_query($conexion, $consulta);

//Mostrar solo los nombres de los eventos junto con un boton de opciones
echo "<h1>Eventos</h1>";
echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "</tr>";
while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['nombreEvento'] . "</td>";
    //Pass parameters
    $_SESSION['idEvento'] = $fila['idEvento'];
    $_SESSION['nombreEvento'] = $fila['nombreEvento'];
    $_SESSION['tipo'] = $fila['tipo'];
    $_SESSION['descripcion'] = $fila['descripcion'];
    $_SESSION['fechaIni'] = $fila['fechaIni'];
    $_SESSION['fechaFin'] = $fila['fechaFin'];
    $_SESSION['plazas'] = $fila['plazas'];
    $_SESSION['ubicacion'] = $fila['ubicacion'];
    $_SESSION['sala'] = $fila['sala'];
    echo "<td><a href='opciones_evento.php'>Opciones</a></td>";
    echo "</tr>";
}
