<?php
// Establecemos la conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "Activities_Physical");

// Verificar¿mos si la conexión fue exitosa
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Inicializamos la variable $resultados
$resultados = [];

//Analizamos el Ritmo_Prom_Minutos_Kg
$sql = "SELECT AVG(Ritmo_Prom_Minutos_Kg) AS PromedioRitmo, STDDEV(Ritmo_Prom_Minutos_Kg) AS DesviacionRitmo FROM registros_fisicos";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $promedioRitmo = $row['PromedioRitmo'];
    $desviacionRitmo = $row['DesviacionRitmo'];

    // Definimos el umbral (por ejemplo, 2 desviaciones estándar por debajo del promedio)
    $umbralRitmo = $promedioRitmo - (2 * $desviacionRitmo);

    // Buscamos UserId con ritmo significativamente menor
    $sql = "SELECT UserId, Ritmo_Prom_Minutos_Kg FROM registros_fisicos WHERE Ritmo_Prom_Minutos_Kg < $umbralRitmo";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error en la consulta UserId: " . $conn->error);
    }
}

//Analizamos si la elevación ganada es notablemente alta en comparación con la duración de la actividad 

$sql = "SELECT AVG(Ritmo_Prom_Minutos_Kg) AS PromedioRitmo, STDDEV(Ritmo_Prom_Minutos_Kg) AS DesviacionRitmo FROM registros_fisicos";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $promedioRitmo = $row['PromedioRitmo'];
    $desviacionRitmo = $row['DesviacionRitmo'];

    // Calculamos el promedio y la desviación estándar de la elevación ganada
    $sql = "SELECT AVG(Elevacion_Total_Metros) AS PromedioElevacion, STDDEV(Elevacion_Total_Metros) AS DesviacionElevacion FROM registros_fisicos";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $promedioElevacion = $row['PromedioElevacion'];
        $desviacionElevacion = $row['DesviacionElevacion'];

        // Calculamos el promedio y la desviación estándar de la duración
        $sql = "SELECT AVG(Duracion_Segundos) AS PromedioDuracion, STDDEV(Duracion_Segundos) AS DesviacionDuracion FROM registros_fisicos";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Error en la consulta: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $promedioDuracion = $row['PromedioDuracion'];
            $desviacionDuracion = $row['DesviacionDuracion'];

            // Calculamos el promedio y la desviación estándar de la distancia para poder sacar el resultado
            $sql = "SELECT AVG(Distancia_Metros) AS PromedioDistancia, STDDEV(Distancia_Metros) AS DesviacionDistancia FROM registros_fisicos";
            $result = $conn->query($sql);

            if ($result === false) {
                die("Error en la consulta: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $promedioDistancia = $row['PromedioDistancia'];
                $desviacionDistancia = $row['DesviacionDistancia'];

                // Definimos umbrales para duración, distancia y elevación (por ejemplo, 2 desviaciones estándar por encima del promedio)
                $umbralDuracion = $promedioDuracion + (2 * $desviacionDuracion);
                $umbralDistancia = $promedioDistancia + (2 * $desviacionDistancia);
                $umbralElevacion = $promedioElevacion + (2 * $desviacionElevacion);

                // Buscamos UserId con ritmo, elevación, duración o distancia significativamente fuera de los umbrales
                $sql = "SELECT UserId, Ritmo_Prom_Minutos_Kg, Elevacion_Total_Metros, Duracion_Segundos, Distancia_Metros FROM registros_fisicos WHERE Ritmo_Prom_Minutos_Kg < $umbralRitmo OR Elevacion_Total_Metros > $umbralElevacion OR Duracion_Segundos > $umbralDuracion OR Distancia_Metros > $umbralDistancia";
                $result = $conn->query($sql);

                if ($result === false) {
                    die("Error en la consulta Actividades Sospechosas: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $resultados[] = $row; // Guardamos los resultados en el array $resultados
                    }
                } else {
                    echo "No se encontraron actividades sospechosas.";
                }
            } else {
                echo "No se pudo calcular el promedio y la desviación estándar de la distancia.";
            }
        } else {
            echo "No se pudo calcular el promedio y la desviación estándar de la duración.";
        }
    } else {
        echo "No se pudo calcular el promedio y la desviación estándar de la elevación ganada.";
    }
} else {
    echo "No se pudo calcular el promedio y la desviación estándar del ritmo.";
}

mysqli_close($conn);
?>

<!--Creamos la estructura de la página con sus estilos-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Analisis de actividades físicas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background: #EBF5FB;
            background-size: cover;
        }

        h2 {
            font-weight: normal;
            text-align: left;
            margin-left: 20px;
            font-size: 18px;
        }

        table {
            width: 98%;
            margin: 20px auto;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #D5F5E3;
        }

        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            border: 1px solid #000;
            background-color: #A9DFBF;
            color: black;
            text-align: center;
            font-weight: bold;
        }

        td {
            border: 1px solid #dddddd;
            text-align: left;
            border: 1px solid #000;
            padding: 8px;
        }

        .header-container {
            background-color: #5DADE2;
        }

        .header {
            margin: auto;
            width: 500px;
            font-family: Arial, sans-serif;
            font-size: 18px;
        }

        ul,
        ol {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav>li {
            display: inline-block;
            position: relative;
        }

        .nav li a {
            color: black;
            text-decoration: none;
            padding: 10px 12px;
            display: block;
        }

        .nav li a:hover {
            background-color: #434343;
        }

        .nav li ul {
            display: none;
            position: absolute;
            min-width: 140px;
            left: 0;
        }

        .nav li:hover>ul {
            display: block;
            background-color: white;
        }

        .nav li ul li {
            position: relative;
        }

        .nav li ul li ul {
            left: 100%;
            top: 0;
        }

        .texto {
            text-align: left;
            font-size: 18px;
            margin: 20px;
            padding: 10px;
        }

        .nav li .nav-analisis::after {
            content: '\25BC';
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
        }

        .footer-contact {
            text-align: left;
        }

        .footer-social {
            text-align: right;
            margin-left: auto;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-politicas{
            text-align: center;
            color: white;
            flex-grow: 1;
        }

        .footer {
            background-color: #5DADE2;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <div class="header">
            <ul class="nav">
                <li><a href="./Index.php">Inicio</a></li>
                <li><a class="nav-analisis" href="">Analisis</a>
                    <ul>
                        <li><a href="./Analisis2.php">Analisis 1</a></li>
                        <li><a href="./Analisis1.php">Analisis 2</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <h2>*Registros con su elevación total en metros en comparación con la duración de la actividad y si una sola actividad tiene una duración muy prolongada o cubre una distancia muy superior al promedio</h2>

    <?php
    if (count($resultados) > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Usuario</th>';
        echo '<th>Ritmo</th>';
        echo '<th>Elevación total en metros</th>';
        echo '<th>Duración en segundos</th>';
        echo '<th>Distancia en metros</th>';
        echo '</tr>';

        foreach ($resultados as $actividad) {
            echo '<tr>';
            echo '<td>' . $actividad['UserId'] . '</td>';
            echo '<td>' . $actividad['Ritmo_Prom_Minutos_Kg'] . '</td>';
            echo '<td>' . $actividad['Elevacion_Total_Metros'] . '</td>';
            echo '<td>' . $actividad['Duracion_Segundos'] . '</td>';
            echo '<td>' . $actividad['Distancia_Metros'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No se encontraron actividades sospechosas.';
    }
    ?>

    <div class="footer">
        <div class="footer-contact">
            <a>Contacto</a><br><a href=>+123456789</a>
        </div>

        <div class="footer-politicas">
            <a href="">Política de privacidad</a>
            <br>
            <a href="">Términos de uso</a>
        </div>

        <div class="footer-social">
            <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
        </div>
    </div>

</body>

</html>