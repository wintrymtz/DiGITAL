    
    <body>
    <!--Navbar-->
    <header class="main-header">
        <a href="home.view.php">
            <img class="logo" src="views/img/logo_v2.jpg">
        </a>
        <form class="search-form" action="busquedas.view.php">
            <div class="search">
                <span class=" search-icon material-symbols-outlined">search</span>
                <input class="search-input" type="search" placeholder="Buscar curso">
            </div>
        </form>
        <nav class="nav-header">
            <ul class="nav-options">
                <li class="li-categories"><a href="#">Categorías</a>
                    <ul class="dropdown">
                        <li><a href="#">Cocina</a></li>
                        <li><a href="#">Python</a></li>
                        <li><a href="#">HTML</a></li>
                        <li><a href="#">Machine Learnig</a></li>
                        <li><a href="#">API's</a></li>
                        <li><a href="#">API's</a></li>
                    </ul>
                </li>
                <li class="li-option"><a href="subirCurso.view.php">Subir Curso</a></li>
                <li class="li-option"><a href="kardex.view.php">Kardex</a></li>
                <li class="li-categories">
                    <ul class="dropdown">
                        <li><a href="manejarPerfil.view.php">Perfil</a></li>
                        <li><a href="VentasGeneral.view.php">Ventas</a></li>
                        <li><a href="inicioSesion.view.php">Cerrar Sesión</a></li>
                        <li><a href="administrador.view.php" style="color: red;">Administrador</a></li>
                    </ul>
                    <div class="btn-iniciarSesion">
                        <a  href="<?=getProjectRoot("/iniciarSesion")?>" class="link-sesion" >Iniciar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
