<html>

<head>
    <title>Dev Tools</title>
</head>

<body>
    <h1>Dev Tools</h1>
    <?php
    require_once __DIR__ . '/config.php';
    echo " <link rel='stylesheet' href='/../../../styles.css'>";

    //Conectar con la base de datos
    $conexion = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME)
        or die("No se ha podido conectar con la base de datos");

    echo "Conexión con la base de datos establecida";

    /*
     
        Visualizar todas las tablas de la base de datos
    
        Programa=@idPrograma+nombrePorgrama+tipo+descripcion+duración
        Programa-startup=@idPrograma+@idStartup
        Inversion=@idStartup+@idInversor+cantidad
        Inversor=@idInversor+nombreInversor+correo+tlf
        Evento=@idEvento+nombreEvento+tipo+descripcion+fechaIni+fechaFin+plazas+ubicacion+sala
        StartUp=@idStartup+nombreStartup+descripcion+sector+estado+correo+tlf
        Mentor=@idMentor+nombreMentor+especialidad+experiencia+correo+tlf
        Subvencion=@idSubvencion+entSubvencionadora+estado+cantidad
        Startup-Evento=@idStartup+@idEvento
        Inversor-Evento=@idInversor + @idEvento
        Mentor-Evento=@idEvento + @idMentor
    
    */

    $nombresTablas = array("Evento", "Evento_Mentor", "Inversion", "Inversor", "Inversor_Evento", "Mentor", "Programa", "Programa_startup", "Startup", "Startup_Evento", "Subvencion", "Convocatoria", "SesionMentoria", "Evaluacion");

    foreach ($nombresTablas as $nombreTabla) {
        $consulta = "SELECT * FROM $nombreTabla";
        $resultado = mysqli_query($conexion, $consulta);
        $numero_filas = mysqli_num_rows($resultado);
        $numero_columnas = mysqli_num_fields($resultado);

        echo "<h2>$nombreTabla</h2>";
        echo "<table border='1'><tr>";
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
            echo "</tr>";
        }
        echo "</table>";
    }

    ?>

</body>

</html>