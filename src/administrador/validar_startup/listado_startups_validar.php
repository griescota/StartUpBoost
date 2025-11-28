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

//Seleccionar todas las startups que estén en estado pendiente
$consulta = "SELECT * FROM Startup WHERE estado = 'pendiente'";
$resultado = mysqli_query($conexion, $consulta);

//Mostrar todas las startups que estén en estado pendiente
$numero_filas = mysqli_num_rows($resultado);
$numero_columnas = mysqli_num_fields($resultado);

echo "<h1 class='titulo'>Startups pendientes de validar</h1>";
echo "<table><tr>";
for ($i = 0; $i < $numero_columnas; $i++) {
    $nombreColumna = mysqli_fetch_field_direct($resultado, $i)->name;
    echo "<th>$nombreColumna</th>";
}
echo "</tr>";
for ($i = 0; $i < $numero_filas; $i++) {
    $fila = mysqli_fetch_array($resultado);
    echo "<tr>";
    for ($j = 0; $j < $numero_columnas; $j++) {
        echo "<td>" . $fila[$j] . "</td>";
    }
    //Pass all parameters in the URL
    $parameters = array(
        'idStartup' => $fila[0],
        'nombreStartup' => $fila[1],
        'descripcion' => $fila[2],
        'sector' => $fila[3],
        'estado' => $fila[4],
        'correo' => $fila[5],
        'tlf' => $fila[6]
    );
    echo "<td><a href='form_validar_startup.html?" . http_build_query($parameters) . "' class='boton-estilo'>Validar</a></td>";
    echo "</tr>";
}
echo "</table>";
