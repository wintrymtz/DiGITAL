<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página web Opcion 1</title>
    <link rel="shortcut icon" href="img/icono por mientras.png" type="image/x-icon">
    <link rel="stylesheet" href="css/home.css">

    <!--navbar links-->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
</head>

<body>
<?php include('partials/nav.php') ?>

    <header class="second-header">
        <!-- efecto Wavy, la ola(wave) de la portada-->
        <div class="wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #fff;"></path>
            </svg></div>
    </header>


    <main>
        <section class="contenedor sobre-nosotros">
            <h2 class="titulo">Cursos mejor valorados</h2>
            <div class="contenedor-sobre-nosotros-">
                <div class="carousel">
                    <div class="carousel__item">
                        <img class="carousel-img" src="img/MV.jpg">
                    </div>
                    <div class="carousel__item">C
                        <img class="carousel-img" src="img/winApi.jpg">
                    </div>
                    <div class="carousel__item">
                        <img class="carousel-img" src="img/FrontEnd.jpg">
                    </div>
                </div>
            </div>
            </div>
        </section>


        <!-- el contenedor no lo ponemos en el section, por que tiene una animacion y color-->
        <section class="portafolio">
            <div class="contenedor">
                <h2 class="titulo">Explorar cursos</h2>
                <div class="galeria-port"> <!-- galeria del portafolio-->
                    <div name="imagenes" class="imagen-port">
                        <img src="img/MV.jpg" alt="">

                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt=""> <!-- es el icono de la flecha, para dar estilo-->
                            <p>Matemáticas para Videojuegos</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/FrontEnd.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>Frontend para principiantes</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/winApi.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>Curso WinAPI</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/img1.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>HTML</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/img4.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>CSS</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/img5.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>Web services</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/img6.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>CSS</p>
                        </div>
                    </div>
                    <div name="imagenes" class="imagen-port">
                        <img src="img/img7.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="img/icono1.png" alt="">
                            <p>C#</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>





        <section class="clientes contenedor">
            <h2 class="titulo">Profesionales Inscritos</h2>
            <div class="cards"> <!-- llevara toda la inf dentro de una imagen-->
                <div class="card">
                    <img src="img/face1.jpg" alt="">
                    <div class="contenido-texto-card">
                        <h4>Lic. Sofía Fernanda</h4>
                        <p>Desarrolladora de aplicaciones web</p>
                    </div>
                </div>


                <div class="card">
                    <img src="img/face2.jpg" alt="">
                    <div class="contenido-texto-card">
                        <h4>Ing. María Fernanda</h4>
                        <p>Gerente en tecnologías de desarrollo de software para Google</p>
                    </div>
                </div>
            </div>
        </section>




        <section class="about-services"> <!-- los servicios-->
            <div class="contenedor">
                <h2 class="titulo">Nuestros servicios</h2>
                <div class="servicio-cont"> <!-- servicio contenedor-->
                    <div class="servicio-ind"> <!-- servicio individual-->
                        <img src="img/ilustracion1.svg" alt="">
                        <h3>Aprendizaje de calidad</h3>
                        <p>Compra y estudia los cursos que ofrece una gran cantidad de instructores capacitados </p>
                    </div>

                    <div class="servicio-ind">
                        <img src="img/ilustracion4.svg" alt="">
                        <h3>Confiabilidad</h3>
                        <p>Toma cursos o niveles gratuitos antes de comprar un curso entero, así te puedes asegurar tu
                            decisión</p>
                    </div>

                    <div class="servicio-ind">
                        <img src="img/ilustracion3.svg" alt="">
                        <h3>Enseña</h3>
                        <p>¿Crees que tienes la capacidad de enseñar? Sube tus propios cursos a la plataforma y vende tu
                            conocimiento</p>
                    </div>
                </div>
            </div>
        </section>
    </main>




    <footer> <!--nuestra informacion de abajo-->
        <div class="contenedor-footer">
            <div class="content-foo">
                <h4>telefono</h4>
                <p>8296312</p>
            </div>
            <div class="content-foo">
                <h4>Correo</h4>
                <p>josejaime.riosm@gmail.com</p>
            </div>
            <div class="content-foo">
                <h4>Localizacion</h4>
                <p>Av. Universidad</p>
            </div>
        </div>
        <h2 class="titulo-final">&copy; DiGITAL | Cursos</h2>
    </footer>
</body>
<script src="js/home.js"></script>

</html>