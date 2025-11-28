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


//Seleccionar todos los mentores
$consulta = "SELECT * FROM Inversor";
$resultado = mysqli_query($conexion, $consulta);

//Visualizar todos los inversores
$numero_filas = mysqli_num_rows($resultado);
$numero_columnas = mysqli_num_fields($resultado);

echo "<h1 class='titulo'>Inversores</h1>";
echo ("<hr class='hr4'>");
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
    echo "<td><a href='eliminar_inversor.php?idInversor=" . $fila[0] . "' class='boton-estilo'>Eliminar</a></td>";
    //Pass all parameters in the URL
    $parameters = array(
        'idInversor' => $fila[0],
        'nombreInversor' => $fila[1],
        'correo' => $fila[2],
        'tlf' => $fila[3]
    );
    echo "<td><a href='form_actualizar_inversor.html?" . http_build_query($parameters) . "' class='boton-estilo'>Actualizar</a></td>";

    echo "</tr>";
}
echo "</table>";

function redirectEliminarInversor($idInversor)
{
    $_SESSION['idInversor'] = $idInversor;
    header("Location: eliminar_inversor.php");
    exit;
}
