<!DOCTYPE html>
<html lang="es">

<head>
    <title>Buscar curso</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Busquedas.css">

    <!--navbar links-->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">

</head>

<body>
<?php include('partials/nav.php') ?>

    <section class="body-container">
        <div class="title-container">
            <h2>Resultados de búsqueda:</h2>
        </div>
        <section class="filter-section">
            <div class="filter-word">
                <h4>Filtrar</h4>
            </div>
            <div class="filter">
                <label>Categorías: </label>
                <select>
                    <option>Python</option>
                    <option>CSS</option>
                    <option>C++</option>
                    <option>SQL</option>
                </select>
                <label>Desde: </label>
                <input type="date"></input>
                <label>Hasta: </label>
                <input type="date"></input>
            </div>
            <br>
            <span class="category">
                <label>Python</label>
            </span>
            <span class="category">
                <label>CSS</label>
            </span>
            <span class="category">
                <label>C++</label>
            </span>
        </section>
        <section class="results-container">
            <div class="result" id="result1">
                <!-- <a href="#"> -->
                <div class="image-container">
                    <img height="180" width="320" alt="imagen del curso" src="img/MV.jpg">
                </div>
                <div class="description-container">
                    <h3>Matemáticas para Videojuegos</h3>

                    <p>Curso de matemáticas enfocado a elementos básicos de las gráficas por computadora y lógica de
                        videojuegos.
                    </p>

                    <div class="creator">
                        <a class="autor" href="chat.view.php">José Jaime De Los Ríos Martínez
                        </a>
                    </div>

                    <div class="categories">
                        <div class="category">
                            <label>Programación</label>
                        </div>
                        <div class="category">
                            <label>C#</label>
                        </div>
                    </div>
                </div>
                <div class="cost-container">
                    <h2>$100.00</h2>
                </div>
            </div>
            <div class="result" id="result1">
                <!-- <a href="#"> -->
                <div class="image-container">
                    <img height="180" width="320" alt="imagen del curso" src="img/FrontEnd.jpg">
                </div>
                <div class="description-container">
                    <h3>Frontend para principiantes</h3>

                    <p>Curso de HTML, CSS y JS para principiantes, los fundamentos de la creación de paginas web,
                        consejos, metodologías, documentación y ejercicios practicos
                    </p>

                    <div class="creator">
                        <a class="autor" href="chat.view.php">Isaac Nehemías Mata Dominguez
                        </a>
                    </div>

                    <div class="categories">
                        <div class="category">
                            <label>Programación</label>
                        </div>
                        <div class="category">
                            <label>HTML</label>
                        </div>
                        <div class="category">
                            <label>CSS</label>
                        </div>
                        <div class="category">
                            <label>JS</label>
                        </div>
                    </div>
                </div>
                <div class="cost-container">
                    <h2>$290.00</h2>
                </div>
            </div>
            <div class="result" id="result1">
                <!-- <a href="#"> -->
                <div class="image-container">
                    <img height="180" width="320" alt="imagen del curso" src="img/winApi.jpg">
                </div>
                <div class="description-container">
                    <h3>Curso de WinAPI</h3>

                    <p>Curso de WinAPI en visual studio, mediante el uso de c++ para el desarrollo de aplicaciones de
                        escritorio usando el API de windows para crear ventanas, proyecto final buscaminas.
                    </p>

                    <div class="creator">
                        <a class="autor" href="chat.view.php">Erick Mauricio Castañeda Garza
                        </a>
                    </div>

                    <div class="categories">
                        <div class="category">
                            <label>Programación</label>
                        </div>
                        <div class="category">
                            <label>C++</label>
                        </div>
                    </div>
                </div>
                <div class="cost-container">
                    <h2>$560.80</h2>
                </div>
            </div>
        </section>
    </section>


    <script>
        document.getElementById("result1").addEventListener("click", function () {
            window.location.href = "comprarCurso.view.php";
        });
    </script>
</body>

</html>