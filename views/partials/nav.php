    
    <body>
    <!--Navbar-->
    <header class="main-header">
        <a href="<?=getProjectRoot("/")?>">
            <img class="logo" src="views/img/logo_v2.jpg">
        </a>
        <form method="GET" class="search-form" action="<?=getProjectRoot("/buscar")?>">
            <div class="search">
                <span class=" search-icon material-symbols-outlined">search</span>
                <input name="query" class="search-input" type="search" placeholder="Buscar curso">
            </div>
        </form>
        <nav class="nav-header">
            <ul class="nav-options">
                <li class="li-categories"><a href="#">Categorías</a>
                    <ul id='category-nav-list' class="dropdown">
                        <!-- <li><a href="#">Cocina</a></li>
                        <li><a href="#">Python</a></li>
                        <li><a href="#">HTML</a></li>
                        <li><a href="#">Machine Learnig</a></li>
                        <li><a href="#">API's</a></li>
                        <li><a href="#">API's</a></li> -->
                    </ul>
                </li>
                <?php
                if($rol ==='instructor'){
                    ?>
                    <li class="li-option"><a href="<?=getProjectRoot("/subirCurso")?>">Subir Curso</a></li>
                    <?php
                } else if($rol === 'estudiante'){
                    ?>
                    <li class="li-option"><a href="<?=getProjectRoot("/kardex")?>">Kardex</a></li>
                    <?php
                } else if($rol === 'administrador'){
                    ?>
                    <?php
                } else{
                    
                }?>  
                <li class="li-categories">
                    <ul class="dropdown">
                        <?php 
                        if($rol ==='instructor'){
                            ?>
                            <li><a href="<?=getProjectRoot("/manejarPerfil")?>">Perfil</a></li>
                            <li><a href="<?=getProjectRoot("/ventasGeneral")?>">Ventas</a></li>
                            <li><a href="<?=getProjectRoot("/iniciarSesion")?>">Cerrar Sesión</a></li>
                            <?php
                        } else if($rol === 'estudiante'){
                            ?>
                            <li><a href="<?=getProjectRoot("/manejarPerfil")?>">Perfil</a></li>
                            <li><a href="<?=getProjectRoot("/iniciarSesion")?>">Cerrar Sesión</a></li>
                            <?php
                        } else if($rol === 'administrador'){
                            ?><li><a href="<?=getProjectRoot("/manejarPerfil")?>">Perfil</a></li>
                              <li><a href="<?=getProjectRoot("/iniciarSesion")?>">Cerrar Sesión</a></li>
                              <li><a href="<?=getProjectRoot("/administrador")?>" style="color: red;">Administrador</a></li>
                            <?php
                        } else{
                            echo 'Sesión no iniciada';
                        }?>                        
                    </ul>
                    <div class="btn-iniciarSesion">
                        <a  href="<?=getProjectRoot("/iniciarSesion")?>" class="link-sesion" >Iniciar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <script> 
         let categoryList = document.getElementById('category-nav-list');
        // console.log(categoryList)

            function _getCategories() {
                fetch('http://localhost:80/DiGITAL/admin/category/getAll', {
                    method: 'GET',
                }).then((response) => {
                    if (!response.ok) {
                        throw response.json();
                    }
                    return response.json();
                }).then((response) => {
                    let data = response['data'];
                    _renderCategories(data);
                }).catch((error) => {
                    console.log(error);
                });
            }

        
        function _renderCategories(data) {
            data.forEach(element => {
                let option = document.createElement('li');
                option.id = 'c_'+ element.idCategoria;
                option.innerHTML = `<a href="#">${element.nombre}</a>`;
            
                categoryList.appendChild(option);
                // console.log(option);
            });
        }

        _getCategories();
        </script>
    </header>
