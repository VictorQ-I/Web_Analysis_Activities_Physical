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
            padding: 0;
            text-align: center;
            margin: 0 auto;
            background: #EBF5FB;
            background-size: cover;
        }

        .cuerpo-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .menu-container {
            background-color: #5DADE2;
            margin: 0;
            padding: 0;
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

        .header_img {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            gap: 10px;
        }

        .image-container {
            text-align: center;
            max-width: 100%;
            overflow: hidden;
        }

        .image {
            width: 100%;
            height: auto;
        }

        .image-description-container {
            display: inline-block;
            text-align: left;
            max-width: 100%;
            overflow: hidden;
        }

        .image-description {
            text-align: left;
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

    <div class="menu-container">
        <div class="header">
            <ul class="nav">
                <li><a href="">Inicio</a></li>
                <li><a class="nav-analisis" href="">Analisis</a>
                    <ul>
                        <li><a href="./Analisis2.php">Analisis 1</a></li>
                        <li><a href="./Analisis1.php">Analisis 2</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="cuerpo-container">
        <p class="texto">En este sistema podrás evidenciar las anomalías que se pueden presentar en las actividades físicas, es decir, registros que tengan patrones sospechosos y no estén dentro del promedio normal para un atleta profesional. Estos datos se sacaron de una base de datos con 30.000 registros de deportistas.</p>

        <div class="header_img">
            <div class="image-container">
                <img src="./IMG/Ciclismo.jpeg" class="image">
                <div class="image-description-container">
                    <p class="image-description">La práctica del ciclismo no solo fortalece los músculos y mejora la resistencia cardiovascular, sino que también fomenta la camaradería y el trabajo en equipo cuando se comparte la experiencia con otros ciclistas.</p>
                </div>
            </div>

            <div class="image-container">
                <img src="./IMG/Correr.jpg" class="image">
                <div class="image-description-container">
                    <p class="image-description">Al correr al aire libre, se tiene la oportunidad de explorar diferentes entornos, disfrutar de la naturaleza y experimentar beneficios adicionales para la salud mental, como la reducción del estrés y la mejora del estado de ánimo.</p>
                </div>
            </div>
        </div>
    </div>

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