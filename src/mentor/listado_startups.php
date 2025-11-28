<?php

session_start();

require_once __DIR__ . '/../../config.php';
// Autenticación
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario != 'mentor') {
    $error = "Error de autenticación";
    header("Location: ../login_form.html?error=$error");
    exit();
}


echo " <link rel='stylesheet' href='/../../../styles.css'>";

//Conectar con la base de datos
$conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
    or die("No se ha podido conectar con la base de datos");

// Mostrar todas las startups pertenecientes al mentor
$idMentor = $_SESSION['id'];
$consulta = "SELECT * FROM Startup WHERE idMentor = '$idMentor'";
$resultado = mysqli_query($conexion, $consulta);


$num_filas = mysqli_num_rows($resultado);
echo "<h1 class='titulo'>Startups</h1>";
echo "<hr class='hr4'>";
if ($num_filas == 0) {
    echo "<p>No tiene registrada ninguna startup</p>";
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
echo "<th>Crear sesion de mentoria</th>";
echo "<th>Evaluar startup</th>";
echo "</tr>";

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['nombreStartup'] . "</td>";
    echo "<td>" . $fila['descripcion'] . "</td>";
    echo "<td>" . $fila['sector'] . "</td>";
    echo "<td>" . $fila['estado'] . "</td>";
    echo "<td>" . $fila['correo'] . "</td>";
    echo "<td>" . $fila['tlf'] . "</td>";
    //Pass all parameters in the URL
    $parameters = array(
        'idStartup' => $fila['idStartup'],
        'nombreStartup' => $fila['nombreStartup'],
        'descripcion' => $fila['descripcion'],
        'sector' => $fila['sector'],
        'estado' => $fila['estado'],
        'correo' => $fila['correo'],
        'tlf' => $fila['tlf']
    );
    echo "<td><a href='form_sesion_mentoria.html?" . http_build_query($parameters) . "'>Crear</a></td>";
    echo "<td><a href='form_evaluacion_startup.html?" . http_build_query($parameters) . "'>Evaluar</a></td>";
    echo "</tr>";
}
