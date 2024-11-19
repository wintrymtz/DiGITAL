const form = document.getElementById('form');

const usCombo = document.getElementById('tipo-usuario');
const estTable = document.getElementById('estudiante-tabla');
const insTable = document.getElementById('instructor-tabla');
let select = document.getElementById('categoryList');

let newCategoryNameInput = document.getElementById('newCategory');
let newCategoryDescInput = document.getElementById('newCategoryDesc');
let categories = [];
let currentCategoryId = -1;

function getReport(rol) {
    console.log('enviando')
    fetch(`http://localhost:80/DiGITAL/admin/user/getUsers?rol=${rol}`)
        .then((response) => {
            return response.json()
        }).then((response) => {
            console.log(response);
            renderReport(response.data, rol);
        })
}

function renderReport(data, rol) {

    if (rol == 0) { //estudiante
        const table = document.getElementById("student-table");
        data.forEach((e) => {
            const mysqlTimestamp = e.fechaCreacion;
            let fecha = timeStampToDate(mysqlTimestamp)
            let state = "";
            if (e.estado == 1) {
                state = `<td name="eliminar-estudiante" id=${e.idUsuario} style="color:red; padding: 10px; cursor: pointer">bloquear<td>`
            } else {
                state = `<td  name="activar-estudiante" id=${e.idUsuario} style="color:green; padding: 10px; cursor: pointer">Activar<td>`
            }

            let item = document.createElement('tr');
            item.id = e.idUsuario;
            item.innerHTML = ` <tr>
                        <td>${e.email}</td>
                        <td>${e.nombre}</td>
                        <td>${fecha}</td>
                        <td>${e.Inscritos}</td>
                        <td>${e.Terminados}%</td>
                        ${state}
                    </tr>`;
            table.appendChild(item);
        });

        let buttons = document.getElementsByName('eliminar-estudiante');
        buttons.forEach((e) => {
            e.addEventListener('click', () => {
                if (confirm(`seguro que quiere eliminar el usuario ${e.id}`)) {
                    requestChangeStatus(false, e.id)
                }
            })
        })

        let buttons2 = document.getElementsByName('activar-estudiante');
        buttons2.forEach((e) => {
            e.addEventListener('click', () => {
                if (confirm(`seguro que quiere activar el usuario ${e.id}`)) {
                    requestChangeStatus(true, e.id)
                }
            })
        })
    } else { //instructor
        const table = document.getElementById("instructor-table");
        data.forEach((e) => {
            const mysqlTimestamp = e.fechaCreacion;
            let fecha = timeStampToDate(mysqlTimestamp)
            let state = "";
            if (e.estado == 1) {
                state = `<td  name="eliminar-instructor" id=${e.idUsuario} style="color:red; padding: 10px; cursor: pointer">bloquear<td>`
            } else {
                state = `<td  name="activar-instructor" id=${e.idUsuario} style="color:green; padding: 10px; cursor: pointer">Activar<td>`
            }

            let item = document.createElement('tr');
            item.id = e.idUsuario;
            item.innerHTML = ` <tr>
                        <td>${e.email}</td>
                        <td>${e.nombre}</td>
                        <td>${fecha}</td>
                        <td>${e.cursosCreados}</td>
                        <td>$${e.ingresosTotales}</td>
                        ${state}
                    </tr>`;
            table.appendChild(item);
        })
        let buttons = document.getElementsByName('eliminar-instructor');
        buttons.forEach((e) => {
            e.addEventListener('click', () => {
                if (confirm(`seguro que quiere eliminar el usuario ${e.id}`)) {
                    requestChangeStatus(false, e.id)
                }
            })
        })

        let buttons2 = document.getElementsByName('activar-instructor');
        buttons2.forEach((e) => {
            e.addEventListener('click', () => {
                if (confirm(`seguro que quiere activar el usuario ${e.id}`)) {
                    requestChangeStatus(true, e.id)
                }
            })
        })
    }
}

function requestChangeStatus(status, idUsuario) {
    fetch('http://localhost:80/DiGITAL/user/change-status', {
        method: 'POST',
        body: JSON.stringify({
            idUsuario: idUsuario,
            status: status,
        })
    }).then((response) => {
        return response.json();
    }).then((response) => {
        console.log(response);
        window.location.reload();
    }).catch((error) => {
        console.log(error);
    });
}


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
        currentCategoryId = -1;
        return;
    }
    const id = select.options[select.selectedIndex].id;
    const result = categories.filter(category => category.idCategoria == id);
    currentCategoryId = id;

    newCategoryNameInput.value = '';
    newCategoryDescInput.value = result[0].descripcion;
})

function eliminar() {
    console.log(currentCategoryId)


    if (currentCategoryId != -1) {
        fetch(`http://localhost:80/DiGITAL/admin/category/delete?id=${currentCategoryId}`)
            .then(response => {
                return response.json();
            }).then(response => {
                alert(response.msg);
                window.location.reload();
            })
    } else {
        alert('No valido, seleccionar una categoria');
    }
}

getReport(0);
getReport(1);