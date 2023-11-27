<?php
// Establecer la conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "Activities_Physical");

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Inicializamos la variable $resultados
$resultados = [];

// Calcular el ritmo promedio general
$sql = "SELECT AVG(Ritmo_Prom_Minutos_Kg) AS RitmoPromedio FROM registros_fisicos";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$ritmoPromedioGeneral = $row['RitmoPromedio'];

// Definir un umbral para considerar un ritmo como significativamente menor
$umbralRitmo = 0.8; // Puedes ajustar este valor según tus criterios

// Obtener UserId con ritmo significativamente menor
$sql = "SELECT DISTINCT UserId, Ritmo_Prom_Minutos_Kg FROM registros_fisicos WHERE Ritmo_Prom_Minutos_Kg < ? * ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'dd', $umbralRitmo, $ritmoPromedioGeneral);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $userId, $ritmo);

echo "<ul>";
while (mysqli_stmt_fetch($stmt)) {
    $resultados[] = ["UserId" => $userId, "Ritmo_Prom_Minutos_Kg" => $ritmo];
}

echo "</ul>";

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

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
            ;
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

        .button-container {
            margin-top: 10px;
            text-align: right;
            margin-right: 20px;
        }

        .button-container a {
            display: inline-block;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
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

        .nav li .nav-analisis::after {
            content: '\25BC';
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
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

        .footer-politicas {
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
                <li><a href="./Index.html">Inicio</a></li>
                <li><a class="nav-analisis" href="">Analisis</a>
                    <ul>
                        <li><a href="./Analisis2.php">Analisis 1</a></li>
                        <li><a href="./Analisis1.php">Analisis 2</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>


    <h2>*Registros con ritmo significativamente menor que los demás</h2>

    <?php
    if (count($resultados) > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Usuario</th>';
        echo '<th>Ritmo</th>';
        echo '</tr>';

        foreach ($resultados as $actividad) {
            echo '<tr>';
            echo '<td>' . $actividad['UserId'] . '</td>';
            echo '<td>' . $actividad['Ritmo_Prom_Minutos_Kg'] . '</td>';
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