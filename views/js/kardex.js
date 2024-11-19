let courses = [];
let selectedCourses = [];
let categories = [];
let selectedCategories = [];

categorySelect = document.getElementById('category-select');
let selectStatus = document.getElementById('status');

//inputs de fechas
let firstDateInput = document.getElementById('firstDate');
let lastDateInput = document.getElementById('lastDate');
let firstDate = "";
let lastDate = "";

//estatus
let statusOption = 0;

getCategories();

selectStatus.addEventListener('change', (e) => {
    console.log(e.target.value);
    statusOption = e.target.value;
    filterCourses(courses, true)
});

firstDateInput.addEventListener('change', (e) => {
    firstDate = new Date(firstDateInput.value);
    console.log(firstDate)
    filterCourses(courses, true)
});

lastDateInput.addEventListener('change', (e) => {
    lastDate = new Date(lastDateInput.value);
    console.log(lastDate)
    filterCourses(courses, true)
});


categorySelect.addEventListener('change', (e) => {
    if (e.target.value === 'Todas') {
        return;
    }
    const id = categorySelect.options[categorySelect.selectedIndex].id;
    const result = categories.filter(category => category.idCategoria == id);
    // console.log(result)
    currentCategoryId = id;
    selectedCategories.push(result[0]);

    let categoriesContainer = document.getElementById('categories-container');
    let category = document.createElement('span');
    category.classList.add('category');
    category.id = result[0].idCategoria;
    category.innerHTML = result[0].nombre;
    categoriesContainer.appendChild(category);
    filterCourses(courses, true);

    category.addEventListener('click', (e) => {
        // console.log('current selected categories:', selectedCategories)
        selectedCategories = selectedCategories.filter(cat => cat.idCategoria != e.target.id);
        // console.log(e.target.id)

        // console.log('Updated selectedCategories:', selectedCategories);
        e.target.remove();
        filterCourses(courses, true);
    })
});

function getCourses() {

    fetch(`http://localhost:80/DiGITAL/courses/show-created`)
        .then((response) => {
            return response.json()
        }).then((response) => {
            console.log(response);
            courses = response.data;
            filterData(courses, false);
            getCategories();
        })
}

function getCategories() {
    fetch('http://localhost:80/DiGITAL/admin/category/getAll', {
        method: 'GET',
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        data = response['data'];
        categories = data;
        console.log('categorias:', categories);
        renderCategories();
    }).catch((error) => {
        console.log(error);
    });
}


function renderCategories() {

    categories.forEach(element => {
        let option = document.createElement('option');
        option.id = element.idCategoria;
        option.innerHTML = element.nombre;
        categorySelect.appendChild(option);
    });
}

function sendRequestGet() {
    fetch('http://localhost:80/DiGITAL/courses/kardex')
        .then((response) => {
            if (!response.ok) {
                throw response.json();
            }
            return response.json();
        }).then((response) => {
            data = response['data'];
            console.log(data);
            data.forEach((e) => {
                courses.push(e);
            });
            filterCourses(data, false);

        }).catch((error) => {
            console.log(error);
        });
}

function filterCourses(data, filter) {

    if (!filter) {
        renderCourses(data);
        return;
    }
    let filteredCourses = data;

    if (selectedCategories.length > 0) {

        filteredCourses = filteredCourses.filter(course => {
            // Verifica si al menos una categoría del curso coincide con las seleccionadas
            return course.categorias.some(courseCategory => {
                return selectedCategories.some(selectedCategory => selectedCategory.idCategoria === courseCategory.idCategoria);
            });
        });
    }


    if (firstDate != "") {
        filteredCourses = filteredCourses.filter(course => {
            let fechaCreado = new Date(course.fechaInicio);
            return fechaCreado >= firstDate;
        });
    }

    if (lastDate != "") {
        filteredCourses = filteredCourses.filter(course => {
            let fechaCreado = new Date(course.fechaInicio);
            return fechaCreado < lastDate;
        });
    }

    if (statusOption == 1) {
        filteredCourses = filteredCourses.filter(course => {
            let progreso = parseFloat(course.progreso);
            return progreso >= 100;
        });
    }

    renderCourses(filteredCourses);
}

function renderCourses(data) {
    let allOptions = document.getElementsByClassName('result');
    Array.from(allOptions).forEach(element => element.remove());

    const table = document.getElementById('table-body');
    data.forEach(course => {

        let element = document.createElement('tr');
        element.id = course.idCurso;

        const mysqlTimestamp = course.fechaInicio;
        let fechaInicio = timeStampToDate(mysqlTimestamp);


        const mysqlTimestamp2 = course.fechaUltimoIngreso;
        let fechaUltimoIngreso = timeStampToDate(mysqlTimestamp2);

        const mysqlTimestamp3 = course.fechaTerminado;
        let fechaTerminado = timeStampToDate(mysqlTimestamp3)
        let url = baseUrl + course.idCurso;

        element.classList.add("result");

        element.innerHTML = `
        <tr>
            <td><a href="${url}">${course.Curso}</a></td>
            `
        if (course.progreso >= 100) {
            let certificateURL = ProjectURL + '/courses-certificate?nombreCurso=' + course.Curso +
                '&fechaTerminado=' + course.fechaTerminado +
                '&nombreInstructor=' + course.nombreInstructor;
            element.innerHTML += ` <td><a href="${certificateURL}">${course.progreso}%</a></td>`;
        } else {
            element.innerHTML += ` <td>${course.progreso}%</td>`;
        }
        element.innerHTML += `
            <td>${fechaUltimoIngreso}</td>
            <td>${fechaInicio}</td>
            <td>${fechaTerminado}</td>
        </tr>
        `;
        table.appendChild(element);
    });
}

sendRequestGet();