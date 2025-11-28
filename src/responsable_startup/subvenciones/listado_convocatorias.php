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

//Obtener todas convocatorias
$consulta = "SELECT * FROM Convocatoria";
$resultado = mysqli_query($conexion, $consulta);

echo "<h1 class='titulo'>Convocatorias</h1>";
echo ("<hr class='hr4'>");
if (mysqli_num_rows($resultado) == 0) {
    echo "<p>No hay convocatorias disponibles</p>";
}
//Mostrar todas las convocatorias, y si la startup no está inscrita, mostrar un botón para inscribirse
$idStartup = $_SESSION['id'];
echo "<table>";
echo "<tr>";
echo "<th>Fecha de inicio</th>";
echo "<th>Fecha de fin</th>";
echo "<th>Descripción</th>";
echo "<th>Inscribirse</th>";
echo "</tr>";
while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['fechaIniConvocatoria'] . "</td>";
    echo "<td>" . $fila['fechaFinConvocatoria'] . "</td>";
    echo "<Td>" . $fila['descripcion'] . "</td>";
    //Check if the startup is already enrolled in the program
    $consulta2 = "SELECT * FROM Subvencion WHERE idStartup = '$idStartup' AND idConvocatoria = '" . $fila['idConvocatoria'] . "'";
    $resultado2 = mysqli_query($conexion, $consulta2);
    $num_filas = mysqli_num_rows($resultado2);
    if ($num_filas == 0) {
        //Pass all parameters in the URL
        $parameters = array(
            'idConvocatoria' => $fila['idConvocatoria'],
            'fechaIniConvocatoria' => $fila['fechaIniConvocatoria'],
            'fechaFinConvocatoria' => $fila['fechaFinConvocatoria'],
            'descripcion' => $fila['descripcion']
        );
        echo "<td><a href='form_subvencion.html?" . http_build_query($parameters) . "'>Inscribirse</a></td>";
    } else {
        echo "<td>Ya inscrito</td>";
    }
    echo "</tr>";
}
echo "</table>";
