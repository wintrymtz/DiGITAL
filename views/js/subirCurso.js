const formulario = document.getElementById('formulario');
const tituloInput = document.getElementById('titulo');
const descripcionInput = document.getElementById('descripcion');
let categorySelect = document.getElementById('category-list');

let levelNamesInputs = [];
let levelPriceInputs = [];
let selectedValues;
let porNivel = false;

let categories = [];

let levelFileInput = document.getElementById('subir-archivo');
let urlInput = document.getElementById('subir-url');

//inputs
const imageFileInput = document.getElementById('file');
const priceInput = document.getElementById('costo');
const addLevelBtn = document.getElementById('add-level-button');

//arreglo de botones de archivo (para el index)
//cada vez que se agrega un nuevo nivel, tambien un nuevo boton con un id en incremento, asi podemos saber el indice del nivel que estamos manejando, principalmente con lo archivos
let levelButtons = [];
levelButtons[0] = document.getElementById(`upload-content-btn-1`)
checkButtonIndex();

//Archivos de los niveles
let currentLevel = 1;
//cantidad de archivos por nivel
let amountFiles = [];
amountFiles[0] = 0;
//archivos
let filesArray = [];
filesArray.push([]);

//level index (ultimo)
let levelIndex = 1;

//Contenedor de elementos
let divArchivos = document.getElementById('levelContent')

document.getElementsByName("precioTipo").forEach((radio) => {
    radio.addEventListener('change', (e) => {
        console.log(e.target.value);
        levelPriceInputs = document.getElementsByName('precio');

        if (e.target.value === "precioTotal") {
            porNivel = false;
            // Crear un nuevo elemento de estilo
            const style = document.createElement('style');
            style.id = 'precioEstilo';
            style.innerHTML = `
                 .div-price {
                    display:none;
                }
              `;
            levelPriceInputs.forEach((input) => {
                input.removeAttribute('required');
            })
            document.head.appendChild(style);
        } else {
            porNivel = true;
            // Crear un nuevo elemento de estilo
            const style = document.createElement('style');
            style.id = 'precioEstilo';
            style.innerHTML = `
                 .div-price {
                display: flex;
                     align-items: center;
                }
              `;
            levelPriceInputs.forEach((input) => {
                input.setAttribute('required', '');
            })
            document.head.appendChild(style);
        }
    });
});


categorySelect.addEventListener('change', () => {
    selectedValues = Array.from(categorySelect.selectedOptions).map(option => option.id);
    console.log('Valores seleccionados:', selectedValues);
});

imageFileInput.addEventListener('change', (e) => {
    const file = imageFileInput.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("course-image").src = e.target.result; // Asigna el contenido al src de la imagen
            document.getElementById("course-image").style.display = 'block';
            document.getElementById('file-icon').style.display = 'none';
        };

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    }
    console.log(imageFileInput.files);
})

addLevelBtn.addEventListener('click', function () {
    console.log('click');
    levelIndex += 1;
    let newLevel = document.createElement('li');
    newLevel.innerHTML = `
                            <div class="level">
                                <input class="input-title" name="titulo-nivel" type="text" placeholder="Nombre del nivel" style="margin-bottom: 0;" required>
                               <input name="up-cont-btn" type="button" id="upload-content-btn-${levelIndex}" onclick="tooglePopup()"
                                    style="display: none;">
                                <label for="upload-content-btn-${levelIndex}">
                                    <span id="icon" class="material-symbols-outlined">
                                        attach_file
                                    </span>
                                </label>
                                <div class ="div-price">
                                    <label class="precio" for="precio-${levelIndex}">Precio:</label>
                                                                        <h5>$</h5>
                                    <input name="precio" id="precio-${levelIndex}" class="precio" type="text" placeholder="00.00"
                                        style="width: 100px; height: 25px;">
                                </div>
                                <div id=content-${levelIndex} class="level-content">
                                </div>
                            </div>
                        `;
    let list = document.getElementById('level-list');
    list.appendChild(newLevel);
    //agregamos botón y actualizamos eventos
    let newButton = document.getElementById(`upload-content-btn-${levelIndex}`)
    levelButtons.push(newButton);
    filesArray.push([]);
    amountFiles.push(0);
    checkButtonIndex();
});

formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

levelFileInput.addEventListener('click', function () {
    this.value = ''; // Vacía el valor antes de abrir el selector de archivos
});

levelFileInput.addEventListener('change', function () {
    console.log('archivo subido')
    addFile(levelFileInput.files[0]);
    tooglePopup();
})

urlInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        urlInput.setCustomValidity('');

        if (urlInput.value == '') {
            urlInput.setCustomValidity('Campo vacío');
            urlInput.reportValidity();
        } else {
            if (urlInput.checkValidity()) {
                console.log('url subida');
                tooglePopup();
            }
            else {
                urlInput.setCustomValidity('URL no valida');
                urlInput.reportValidity();

            }

        }

    }
})

function uploadCourse() {
    levelNamesInputs = document.getElementsByName('titulo-nivel');
    console.log(levelNamesInputs.length);

    levelPriceInputs = document.getElementsByName('precio');
    // console.log(levelPriceInputs.length);


    if (!validateCourse()) {
        return;
    }



    sendRequestCreate();
}

function validateCourse() {
    //limpiamos las validaciones
    for (var i = 0, length = levelNamesInputs.length; i < length; i++) {
        levelNamesInputs[i].setCustomValidity('');
    }

    for (var i = 0, length = levelPriceInputs.length; i < length; i++) {
        levelPriceInputs[i].setCustomValidity('');
    }

    tituloInput.setCustomValidity('');
    descripcionInput.setCustomValidity('');
    priceInput.setCustomValidity('');

    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        console.log('validaciones generales no validas')
        formulario.reportValidity();
        return false;
    }

    console.log('primer filtro pasado');

    //Validaciones del nivel
    if (!validateLevels()) {
        console.log('Error de nivel');
        return false;
    }

    //Validacion del titulo
    if (tituloInput.value.length > 80) {
        tituloInput.setCustomValidity('El titulo no puede exceder de 80 caracteres');
        tituloInput.reportValidity();
        return false;
    }

    //validacion de la descripcion
    if (descripcionInput.value.length > 200) {
        descripcionInput.setCustomValidity('La descripcion no puede exceder de 200 caracteres');
        descripcionInput.reportValidity();
        return false;
    }

    //validacion de la imagen del curso
    if (!validateImage()) {
        return false;
    }

    //validacion precio
    if (!validatePrice(priceInput)) {
        return false;
    }

    return true;
}

function validateLevels() {
    let validate = true;

    //Revisamos cada uno de los inputs de nombre
    for (var i = 0, length = levelNamesInputs.length; i < length; i++) {
        if (levelNamesInputs[i].value.length > 80) {
            levelNamesInputs[i].setCustomValidity('El titulo no puede exceder de 80 caracteres');
            levelNamesInputs[i].reportValidity();
            validate = false;
        }
    }

    let j = 0;
    filesArray.forEach((levelArray) => {
        i++;
        if (levelArray.length < 1) {
            levelNamesInputs[j].setCustomValidity('Cada nivel debe de tener al menos 1 recurso');
            levelNamesInputs[j].reportValidity();
            validate = false;
        }
    });

    //Revisamos cada uno de los inputs de precio
    for (var i = 0, length = levelPriceInputs.length; i < length; i++) {
        if (!validatePrice(levelPriceInputs[i])) {
            console.log('error precio de nivel')
            validate = false;
        }
        console.log('error precio de nivel')
    }
    return validate;
}

function validateImage() {

    if (!imageFileInput.files.length) {
        alert('No se ha subido una imagen de curso');
        return false;
    }
    return true;
}

function validatePrice(_priceInput) {


    //verificamos si está vacío
    if (_priceInput.value === "") {
        _priceInput.value = '0.0';
        console.log('0.0');
    }

    //verificamos que sea numero
    if (isNaN(_priceInput.value)) {
        console.log("no es un numero")
        _priceInput.setCustomValidity('Precio no válido, el precio debe de ser un número')
        return false;
    }

    return true;

}

let pop1active = false;
function tooglePopup() {
    if (pop1active) {
        document.getElementById('popup-1').classList.remove('active');
        pop1active = false;
        console.log('active')
        return;
    }
    console.log('no active')
    document.getElementById('popup-1').classList.add('active');
    pop1active = true;
    return;
}

function checkButtonIndex() {
    levelButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            let cadena = btn.id;
            let partes = cadena.split('-');
            cadena = partes[3];
            currentLevel = Number(cadena);
        });
    });
}

function addFile(file) {
    console.log(filesArray);

    amountFiles[currentLevel - 1] += 1;
    //se empieza desde la posicion 0
    let primerIndice = currentLevel - 1;

    console.log(primerIndice);

    const level = document.getElementById(`content-${currentLevel}`);

    let newResource = document.createElement('div');
    newResource.classList.add('content-element');
    newResource.id = currentLevel;
    newResource.innerHTML = `<a>
                                <h6>${file.name}</h6>
                            </a>`;
    level.appendChild(newResource);

    newResource.addEventListener('click', (e) => {
        // console.log(e.target.textContent);
        let currentIndex = newResource.id - 1;
        filesArray[currentIndex] = filesArray[currentIndex].filter(file => file.name !== e.target.textContent);
        amountFiles[currentIndex] -= 1;
        newResource.remove();
        console.log(filesArray);
    });

    filesArray[primerIndice].push(file);

    console.log('En el nivel: ' + (primerIndice + 1) + ' hay: ' + amountFiles[currentLevel - 1] + ' archivos');

}

function sendRequestCreate() {
    let data = new FormData();
    // data.append('idInstructor',); //por sesion
    data.append('nombre', tituloInput.value);
    data.append('cantNiveles', levelIndex);
    data.append('costo', priceInput.value);
    data.append('descripcion', descripcionInput.value);
    data.append('PorNivel', porNivel);
    data.append('nombreNiv', false);
    data.append('image', imageFileInput.files[0]);

    selectedValues.forEach((value) => {
        data.append('categorias[]', value);
    });

    levelNamesInputs.forEach((input) => {
        data.append('nombreNiveles[]', input.value);
    });

    levelPriceInputs.forEach((input) => {
        // console.log(input.value);
        data.append('precioNiveles[]', input.value)
    });

    filesArray.forEach((levelArray, levelIndex) => {
        levelArray.forEach((levelFile, fileIndex) => {
            // Añade cada archivo al FormData con nombres estructurados para $_FILES
            data.append(`archivosNiveles[${levelIndex}][${fileIndex}]`, levelFile);
        });
    });

    fetch('http://localhost:80/DiGITAL/subirCurso/create', {
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
        alert(response['msg']);
        console.log(response['data']);
    }).catch((error) => {
        console.log(error);
        alert(error['msg']);
    });
}


function sendRequestGet() {
    let data = [];
    fetch('http://localhost:80/DiGITAL/admin/category/getAll', {
        method: 'GET',
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        data = response['data'];
        renderCategories(data);
    }).catch((error) => {
        console.log(error);
    });
}

function renderCategories(data) {
    data.forEach(element => {
        let option = document.createElement('option');
        option.id = element.idCategoria;
        option.innerHTML = element.nombre;
        categorySelect.appendChild(option);
        categories.push(element);
    });
}

const style = document.createElement('style');
style.id = 'precioEstilo';
style.innerHTML = `
     .div-price {
        display:none;
    }
  `;
document.head.appendChild(style);

sendRequestGet();