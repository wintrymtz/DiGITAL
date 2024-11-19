<?php
 $css = getFile('/ventasGeneral', 'css');
 include('partials/nav.php');
 include('partials/head.php');

 ?>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Título de la página -->
        <h1>Reporte de Ingresos por Cursos</h1>

        <!-- Filtros para la obtención de reportes -->
        <div class="filters">
            <label for="dateRange">Rango de Fechas:</label>
            <input type="date" id="firstDate">
            <input type="date" id="lastDate">

            <label for="category">Categoría:</label>
            <select id="categoryList">
                <option>Todas</option>
                <!-- <option value="programacion">Programación</option>
                <option value="diseño">Diseño</option>
                <option value="marketing">Marketing</option> -->
            </select>

            <label for="status">Estado del Curso:</label>
            <select id="status">
                <option value="active">Activos</option>
                <option value="all">Todos</option>
            </select>
        </div>
    <div id="categories-container">
    </div>
        <!-- Lista de cursos con detalles de ingresos -->
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Alumnos Inscritos</th>
                    <th>Nivel Promedio</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody id="table">
                <!-- <tr>
                    <td> <a href="">Matemáticas para Videojuegos</a></td>
                    <td>50</td>
                    <td>3</td>
                    <td>$300.00</td>
                </tr>

                <tr>
                    <td>Frontend para principiantes</td>
                    <td>30</td>
                    <td>4</td>
                    <td>$3,000.00</td>
                </tr>
                <tr>
                    <td>Curso de WinAPI</td>
                    <td>40</td>
                    <td>5</td>
                    <td>$4,500.00</td>
                </tr> -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total de Ingresos</td>
                    <!-- <td id="total">$12,500.00</td> -->
                    <td id="total">$00.00</td>
                </tr>
                <!-- Desglose por forma de pago -->
                <tr>
                    <td colspan="3">Ingresos por Tarjeta</td>
                    <td id="tarjeta">$00.00</td>
                </tr>
                <tr>
                    <td colspan="3">Ingresos por PayPal</td>
                    <td id="paypal">$00.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
<script src="<?=getFile('/validUs', 'js')?>"></script>
<script>
const url = "<?=getProjectRoot(null)?>";
let courses = [];
let categories = [];
let selectedCategories = [];
let select = document.getElementById('categoryList');
let selectStatus = document.getElementById('status');

//inputs de fechas
let firstDateInput = document.getElementById('firstDate');
let lastDateInput = document.getElementById('lastDate');
let firstDate = "";
let lastDate = "";

let statusOption ="all";


firstDateInput.addEventListener('change',(e)=>{
    firstDate = new Date(firstDateInput.value);
    console.log(firstDate)
    filterData(courses, true, true)
});

lastDateInput.addEventListener('change',(e)=>{
    lastDate = new Date(lastDateInput.value);
    console.log(lastDate)
    filterData(courses, true, true)
});

selectStatus.addEventListener('change', (e)=>{
    console.log(e.target.value);
    statusOption = e.target.value;
    filterData(courses, true, true)
});

select.addEventListener('change', (e) => {
            if (e.target.value === 'Todas') {
                return;
            }
            const id = select.options[select.selectedIndex].id;
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
            filterData(courses, true);

            category.addEventListener('click', (e)=>{
                // console.log('current selected categories:', selectedCategories)
                selectedCategories = selectedCategories.filter(cat => cat.idCategoria != e.target.id);
                // console.log(e.target.id)
                
                // console.log('Updated selectedCategories:', selectedCategories);
                e.target.remove();
                filterData(courses, true);
            })
        });

function getCourses(){
    
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

function filterData(data, filter){
    if(!filter){
        renderData(data);
        return;  
    } 
        let filteredCourses = data;

        if(selectedCategories.length > 0){
            // console.log(1,filteredCourses);
            // console.log(2,selectedCategories);

        filteredCourses = filteredCourses.filter(course => {
        // Verifica si al menos una categoría del curso coincide con las seleccionadas
        return course.categorias.some(courseCategory => {
            return selectedCategories.some(selectedCategory => selectedCategory.idCategoria === courseCategory.idCategoria);
                });
            });
        }             

        if(firstDate != ""){
            filteredCourses = filteredCourses.filter(course =>{
                let fechaCreado = new Date(course.fechaCreacion);
                return fechaCreado >= firstDate;
            });
        }

        if(lastDate != ""){
            filteredCourses = filteredCourses.filter(course =>{
                let fechaCreado = new Date(course.fechaCreacion);
                return fechaCreado < lastDate;
            });
        }
        if(statusOption === 'active'){
            filteredCourses = filteredCourses.filter(course =>{
                return course.estado == 1;
        });
        }

        

        renderData(filteredCourses);
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

function renderCategories(){
    
    categories.forEach(element => {
        let option = document.createElement('option');
        option.id = element.idCategoria;
        option.innerHTML = element.nombre;
        select.appendChild(option);
    });
}

function renderData(data){
    let allOptions = document.getElementsByClassName('result');
    Array.from(allOptions).forEach(element => element.remove());

    const table = document.getElementById("table");
    // console.log(data);
    let finalTotal = 0;
    let finalTarjeta = 0;
    let finalPaypal = 0;

    data.forEach((curso) =>{
        let paypal = parseFloat(curso.ingresosPayPal);
        let total = parseFloat(curso.ingresosTotales);
        let tarjeta = parseFloat(curso.ingresosCreditCard);

        finalTotal += total;
        finalTarjeta += tarjeta;
        finalPaypal += paypal;
        
        let promedio = 0;

        if(curso.Promedio !== null){
            promedio =curso.Promedio;
        }


        let item = document.createElement("tr");
        let nombreURL = encodeURIComponent(curso.Curso);
        let itemURL = url+'/ventasCurso?id=' + curso.idCurso + '&nombre=' + nombreURL;
        item.classList.add('result');
        let editURL = url + '/editarCurso?id=' + curso.idCurso;
        item.innerHTML = `
                    <td> <a href="${itemURL}">${curso.Curso}</a></td>
                    <td>${curso.AlumnosInscritos}</td>
                    <td>%${promedio}</td>
                    <td>$${curso.ingresosTotales}</td>
                    <td> <a href='${editURL}'>Editar</a><td>
        `;
        table.appendChild(item);
    })

    document.getElementById("total").textContent = '$'+ finalTotal.toFixed(2);
    document.getElementById("tarjeta").textContent = '$'+ finalTarjeta.toFixed(2);
    document.getElementById("paypal").textContent = '$'+ finalPaypal.toFixed(2);
}

getCourses();

</script>

</html>