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
                                    <!-- <div style="width: 30px; height: 30px;" tabindex="0" class="plusButton">
                                        <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                            <g mask="url(#mask0_21_345)">
                                                <path
                                                    d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div> -->
                                </div>
                            </span>
                            <span class="price-options">
                                <span>
                                    <input id="precioTotal" type="radio" value="precioTotal" name="precioTipo" disabled>
                                    <label for="precioTotal">Precio Total</label>
                                </span>
                                <span>
                                    <input id="precioIndividual" type="radio" value="precioIndividual" name="precioTipo" disabled>
                                    <label for="precioIndividual">Precio Por Nivel</label>
                                </span>
                            </span>
                        </div> 
                    </ol>
                </div>
            </div>
            <div class="right-side">
                <div class="right-side-up">
                    <div class="upload-image">

                        <label for="file" class="custum-file-upload">
                            <div class="icon">
                                <svg id="file-icon" viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                            fill=""></path>
                                    </g>
                                </svg>
                            </div>
                            <img id="course-image" src="" height = 115.2 style="display:none">
                            <div class="text">
                                <span>Portada</span>
                            </div>
                            <input id="file" type="file" accept=".jpg,.png" disabled>
                        </label>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                    <hr>
                    <div class="cost">
                        <label for="costo">Precio: $</label>
                        <input class="precio2" id="costo" type="text" placeholder="00.00">
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
                        <select id='category-list' class="select-category" multiple disabled>
                        </select>
                    </div>
                </div>
                <div class="right-side-down">
                    <input type="submit" value="Actualizar" onclick="updateCourse();">
                </div>
            </div>
        </form>
    </div>
    <script>
        const $url = "<?=getProjectRoot(null)?>";
    </script>
    <script>
        
    let tituloInput=   document.getElementById("titulo");
    let descripcionInput=   document.getElementById("descripcion");

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    console.log(id)
    getCourse(id);

    document.getElementById('formulario').addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

    function getCourse(id){
        fetch(`http://localhost:80/DiGITAL/courses/get?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response['data']);
            renderInformation(response['data'].curso, response['data'].niveles);
        }).then(() => {
            console.log('terminó');
        })
    }

    function renderInformation(curso, niveles){
        document.getElementById("titulo").value = curso.nombre;

        document.getElementById("descripcion").value = curso.descripcion;
        document.getElementById("course-image").src = `data:${curso.mimeType};base64,${curso.foto}`;
        document.getElementById("course-image").style.display = 'block';
        document.getElementById('file-icon').style.display = 'none';

        if(curso.PorNivel == 0){
            document.getElementById('precioTotal').checked = true;
            document.getElementById("costo").value = curso.costo;
            document.getElementById("costo").disabled = true;
        } else{
            document.getElementById('precioIndividual').checked = true;
            document.getElementById("costo").disabled = true;
        }

        levelIndex = 0;
        niveles.forEach((nivel)=>{
            console.log('click');
        // levelIndex += 1;
         let newLevel = document.createElement('li');
            newLevel.innerHTML = `
                            <div class="level">
                                <input class="input-title" name="titulo-nivel" type="text" value='${nivel.nombre}' style="margin-bottom: 0;" disabled>`
        if(curso.PorNivel == 1)
            newLevel.innerHTML +=
                                `
                                <div class ="div-price">
                                    <label class="precio" for="precio-${levelIndex}" disabled>Precio:</label>
                                                                        <h5>$</h5>
                                    <input name="precio" id="precio-${levelIndex}" class="precio" type="text" placeholder="00.00"
                                        style="width: 100px; height: 25px;" disabled>
                                </div>
                                <div id=content-${levelIndex} class="level-content">
                                </div>
                            </div>
                        `;
            let list = document.getElementById('level-list');
            list.appendChild(newLevel);
            //agregamos botón y actualizamos eventos
            let newButton = document.getElementById(`upload-content-btn-${levelIndex}`)
            // levelButtons.push(newButton);
            // filesArray.push([]);
            // amountFiles.push(0);
            // checkButtonIndex();
            levelIndex++;
        })
    }

function updateCourse(){
        
    tituloInput.setCustomValidity('');
    descripcionInput.setCustomValidity('');

    //Validacion del titulo
    if (tituloInput.value.length > 80) {
        tituloInput.setCustomValidity('El titulo no puede exceder de 80 caracteres');
        tituloInput.reportValidity();
        return;
    }

    //validacion de la descripcion
    if (descripcionInput.value.length > 200) {
        descripcionInput.setCustomValidity('La descripcion no puede exceder de 200 caracteres');
        descripcionInput.reportValidity();
        return;
    }

    sendUpdateCourse();
}

function sendUpdateCourse(){
        
        let data = new FormData();

        data.append('nombre', tituloInput.value);
        data.append('descripcion', descripcionInput.value);
        data.append('idCurso', id);

        fetch('http://localhost:80/DiGITAL/courses/update', {
        method: 'POST',
        body: data
         }).then((response) => {
        if (!response.ok) {
            throw response.json();
        } else {
            // requestState = true;
        }
        return response.json()
    }).then((response) => {

        // window.location.href = $url + "/ventasGeneral";
        alert(response['msg']);
        location.reload();

    }).catch((error) => {
        console.log(error);
        alert(error['msg']);
    });
}
    </script>
</body>