const form = document.getElementById('form');

const usCombo = document.getElementById('tipo-usuario');
const estTable = document.getElementById('estudiante-tabla');
const insTable = document.getElementById('instructor-tabla');
let select = document.getElementById('categoryList');

let newCategoryNameInput = document.getElementById('newCategory');
let newCategoryDescInput = document.getElementById('newCategoryDesc');
let categories = [];
let currentCategoryId = -1;

usCombo.addEventListener('change', function () {
    console.log(this.value);
    // let thead = document.getElementById('thead-table')
    // let columns = document.createElement('tr');

    switch (this.value) {
        case 'Instructor':
            insTable.style.display = 'block';
            estTable.style.display = 'none';
            break;

        case 'Estudiante':
            estTable.style.display = 'block';
            insTable.style.display = 'none';
            break;
    }
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
});

function validate() {
    let newCaetgoryN = newCategoryNameInput.value;
    let newCaetgoryD = newCategoryDescInput.value;

    console.log(newCaetgoryD);

    let nueva = false;

    if (newCaetgoryN !== '') {
        nueva = true;
    }

    if (newCaetgoryD.length == 0) {
        newCategoryDescInput.setCustomValidity('Ingrese una descripcion valida')
    } else {
        newCategoryDescInput.setCustomValidity('');
    }

    if (nueva) {
        sendRequestCreate(newCaetgoryN, newCaetgoryD);
    }

    if (currentCategoryId != -1 && !nueva) {
        const result = categories.filter(category => category.idCategoria == currentCategoryId);
        console.log(result);
        sendRequestUpdate(result[0].nombre, newCaetgoryD, currentCategoryId);
    }
}


function sendRequestUpdate(nombre, desc, idCategoria) {
    fetch('http://localhost:80/DiGITAL/admin/category/update', {
        method: 'POST',
        body: JSON.stringify({ nombre: nombre, descripcion: desc, idCategoria: idCategoria })
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        alert(response['msg']);
        window.location.reload();
    }).catch((error) => {
        console.log(error);
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

function sendRequestCreate(nombre, desc) {
    fetch('http://localhost:80/DiGITAL/admin/category/store', {
        method: 'POST',
        body: JSON.stringify({ nombre: nombre, descripcion: desc })
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        alert(response['msg']);
        window.location.reload();
    }).catch((error) => {
        console.log(error);
    });
}

function renderCategories(data) {
    let select = document.getElementById('categoryList');
    console.log(data);
    data.forEach(element => {
        let option = document.createElement('option');
        option.id = element.idCategoria;
        option.innerHTML = element.nombre;
        select.appendChild(option);
        categories.push(element);
    });
}

sendRequestGet();

select.addEventListener('change', (e) => {
    if (e.target.value === 'None') {
        newCategoryNameInput.value = '';
        newCategoryDescInput.value = '';
        return;
    }
    const id = select.options[select.selectedIndex].id;
    const result = categories.filter(category => category.idCategoria == id);
    console.log(result)
    currentCategoryId = id;

    newCategoryNameInput.value = '';
    newCategoryDescInput.value = result[0].descripcion;
    console.log('clicked')
})