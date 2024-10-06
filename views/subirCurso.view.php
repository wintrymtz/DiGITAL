<?php 
$css = getFile('/subirCurso', 'css');
include('partials/head.php');
include('partials/nav.php');
 ?>

    <div class="popup " id="popup-1">
        <div class="overlay"></div>
        <div class="content">
            <div class="close-btn" onclick="tooglePopup()">&times;</div>
            <h1>Subir contenido</h1>
            <label for="subir-archivo">
                <div class="upload-file">
                    Adjuntar archivo
                    <input type="file" id="subir-archivo" accept=".jpg, .png, .mp4, .txt, .pdf">
                </div>
            </label>
            o
            <div class="upload-url">
                <label>URL:</label>
                <input id="subir-url" type="url" placeholder="url.com">
            </div>
            <p>'Enter' para enviar</p>
        </div>
    </div>
    <div class="main-container">
        <form id="formulario" class="upload-course-form">
            <div class="left-side">
                <h4 class="main-title">Crear nuevo curso:</h4>
                <div class="title">
                    <input id="titulo" class="input-title" type="text" placeholder="Titulo del curso" required>
                </div>
                <div class="description">
                    <textarea id="descripcion" style="width: 600px; height: 100px;" class="input-title"
                        placeholder="Descripción del curso" required></textarea>
                </div>
                <div class="levels">
                    <ol id="level-list">
                        <div class="add-levels">
                            <h4>Niveles del curso:</h4>
                            <span id="icon">
                                <div id="add-level-button">
                                    <div style="width: 30px; height: 30px;" tabindex="0" class="plusButton">
                                        <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                            <g mask="url(#mask0_21_345)">
                                                <path
                                                    d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </span>
                        </div>

                        <li>
                            <!--Nivel individual-->
                            <div class="level">
                                <input name="titulo-nivel" class="input-title" type="text"
                                    placeholder="Nombre del nivel" style="margin-bottom: 0;" required>
                                <input name="up-cont-btn" type="button" id="upload-content-btn-1"
                                    onclick="tooglePopup()" style="display: none;">
                                <label for="upload-content-btn-1">
                                    <span id="icon" class="material-symbols-outlined">
                                        attach_file
                                    </span>
                                </label>
                                <div>
                                    <!-- <label>Costo:</label> -->
                                    <!-- <input id="Gratis" type="radio" value="Gratis" name="precio-1" required>
                                    <label for="Gratis">Gratis</label>

                                    <input id="Pago" type="radio" value="Pago" name="precio-1" required>
                                    <label for="Pago">Pago</label> -->

                                    <label for="precio-1">Precio: $</label>
                                    <input name="precio" id="precio-1" class="precio" type="text" placeholder="00.00"
                                        style="width: 100px; height: 25px;">
                                </div>
                                <div name="content-1" class="level-content">
                                    <div class="content-element">
                                        <a href="#">
                                            <h6>CursoVideo.mp4</h6>
                                        </a>
                                    </div>
                                    <div class="content-element">
                                        <a href="#">
                                            <h6>Variables.pdf</h6>
                                        </a>
                                    </div>
                                    <div class="content-element">
                                        <a href="#">
                                            <h6>www.enseñame.com</h6>
                                        </a>
                                    </div>
                                    <div class="content-element">
                                        <a href="#">
                                            <h6>referencia.jpg</h6>
                                        </a>
                                    </div>
                                    <div class="content-element">
                                        <a href="#">
                                            <h6>Instrucciones</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- <li>
                            <div class="level">
                                <input name="titulo-nivel" type="text" placeholder="Nombre del nivel" required>
                                <span class="material-symbols-outlined">
                                    attach_file
                                </span>
                                <div class="level-content">
                                    <div class="content-element">
                                        <h6>CursoVideo.mp4</h6>
                                    </div>
                                </div>
                            </div>
                        </li> -->
                    </ol>
                </div>
            </div>
            <div class="right-side">
                <div class="right-side-up">
                    <div class="upload-image">
                        <!--
                        <img src="https://i.pinimg.com/564x/c9/d2/b0/c9d2b014b12a0333162eef4584e8f657.jpg" height="180"
                            width="320" style="display: block;">

                        <input type="file" id="upload-image-btn">
                        <label for="upload-image-btn" class="upload-certificate-label">
                            Agregar portada
                            <span class="material-symbols-outlined">
                                add_photo_alternate
                            </span>
                        </label> -->

                        <label for="file" class="custum-file-upload">
                            <div class="icon">
                                <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                            fill=""></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="text">
                                <span>Agregar portada</span>
                            </div>
                            <input id="file" type="file" accept=".jpg,.png">
                        </label>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                    <hr>
                    <div class="cost">
                        <label for="costo">Precio: $</label>
                        <input class="precio" id="costo" type="text" placeholder="00.00">
                    </div>
                    <hr>

                    <!-- <div class="certificate">
                        <img src="https://i.pinimg.com/564x/82/7d/97/827d97a83dd0382653f72dd482fd0af2.jpg"
                            style="display: block; width: 100%;">
                        <br>
                        <input type="file" id="upload-certificate-btn">
                        <label for="upload-certificate-btn" class="upload-certificate-label">
                            Subir certificado
                            <span class="material-symbols-outlined">
                                attach_file
                            </span>
                        </label>
                    </div> -->
                    <br>
                    <br>
                    <br>
                    <div class="add-categories">
                        <label style="display: block;">Seleccionar categorías</label>
                        <br>
                        <select class="select-category" multiple required>
                            <option class="category">Python</option>
                            <option class="category">C#</option>
                            <option class="category">CSS</option>
                            <option class="category">HTML</option>
                        </select>
                    </div>
                </div>
                <div class="right-side-down">
                    <input type="submit" value="Publicar" onclick="uploadCourse();">
                </div>
            </div>
        </form>
    </div>
    <script src="<?=getFile('/subirCurso', 'js') ?>"></script>
</body>