<?php 
$css = getFile('/buscar', 'css');
include('partials/head.php');
include('partials/nav.php');
?>

    <section class="body-container">
        <div class="title-container">
            <h2>Resultados de búsqueda: "<?php echo htmlspecialchars($_GET['query']); ?>"</h2>
        </div>
        <section class="filter-section">
            <div class="filter-word">
                <h4>Filtrar</h4>
            </div>
            <div class="filter">
                <label>Categorías: </label>
                <select id="categoryList">
                    <option>None</option>
                </select>
                <label>Desde: </label>
                <input id="firstDate" type="date"></input>
                <label>Hasta: </label>
                <input id="lastDate" type="date"></input>
            </div>
            <br>
            <div id="categories-container">
            </div>
        </section>
        <section id="results-container" class="results-container">
        </section>
    </section>


    <script>
            let select = document.getElementById('categoryList');
            let categories = [];
            let selectedCategories = [];
            let courses = [];
            let firstDateInput = document.getElementById('firstDate');
            let lastDateInput = document.getElementById('lastDate');

            let firstDate ="";
            let lastDate ="";

            firstDateInput.addEventListener('change',(e)=>{
                firstDate = new Date(firstDateInput.value);
                console.log(firstDate)
                filterCourses(courses, true, true)
            })

            lastDateInput.addEventListener('change',(e)=>{
                lastDate = new Date(lastDateInput.value);
                console.log(lastDate)
                filterCourses(courses, true, true)
            })

        function sendRequestSearch(busqueda){
            fetch('http://localhost:80/DiGITAL/courses/show', {
            method: 'POST',
            body: JSON.stringify({busqueda: busqueda})
            }).then((response) => {
                if (!response.ok) {
                    throw response.json();
                }
                return response.json();
            }).then((response) => {
                data = response['data'];
                // console.log(data);
                data.forEach((e)=>{
                    courses.push(e);
                });
                filterCourses(data, false, false);

            }).catch((error) => {
                console.log(error);
            });
        }


        function filterCourses(data, category, dateF){
            console.log(data);
            if(!category && !dateF){
                renderCourses(courses);
                return;
            } else{
                let filteredCourses = data;

                if(selectedCategories.length > 0){
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


                renderCourses(filteredCourses);
                return;
            }

            renderCourses(data);
        }

        function renderCourses(data, categories){
            let allOptions = document.getElementsByClassName('result');
            Array.from(allOptions).forEach(element => element.remove());


            let mainContainer = document.getElementById("results-container");
            data.forEach(element =>{
                let chatURL = "<?= getProjectRoot('/chat') ?>?id=" + element.idInstructor;

                let result = document.createElement('div');
                result.classList.add('result');
                let html;
                html = `
                <div class="rc">
                <div class="image-container">
                    <img height="180" width="320" alt="imagen del curso" src="data:${element.mimeType};base64,${element.foto}">
                </div>
                <div class="description-container">
                    <h3>${element.nombreCurso}</h3>
                    <p>${element.descripcion}
                    </p>
                    <div class="creator">
                        <a class="autor" href="${chatURL}">${element.nombreUsuario}
                        </a>
                    </div>
                    <div class="categories">`
                    element.categorias.forEach(categoria=>{
                        html += `
                        <div class="category">
                            <label>${categoria.nombre}</label>
                        </div>
                        `
                    })
                    html +=
                    `
                        </div>
                    </div>
                     </div>
                    <div class="cost-container">
                        <h2>$${element.costo}</h2>
                    </div>
                    `;
                    result.innerHTML = html;
                    result.id= element.idCurso;
                    mainContainer.appendChild(result);

                    result.addEventListener("click", function () {
                    
                window.location.href = "<?= getProjectRoot('/comprarCurso') ?>?id=" + result.id;
             });
            })
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

        function renderCategories(data){
            let select = document.getElementById('categoryList');
            data.forEach(element => {
                let option = document.createElement('option');
                option.id = element.idCategoria;
                option.innerHTML = element.nombre;
                select.appendChild(option);
                categories.push(element);
            });
        }

        
        select.addEventListener('change', (e) => {
            if (e.target.value === 'None') {
                newCategoryNameInput.value = '';
                newCategoryDescInput.value = '';
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
            filterCourses(courses, true);

            category.addEventListener('click', (e)=>{
                console.log('current selected categories:', selectedCategories)
                selectedCategories = selectedCategories.filter(cat => cat.idCategoria != e.target.id);
                console.log(e.target.id)
                
                console.log('Updated selectedCategories:', selectedCategories);
                e.target.remove();
                filterCourses(courses, true);
            })
        });

        const searchQuery = "<?php echo htmlspecialchars($_GET['query']); ?>";
        sendRequestSearch(searchQuery);
        sendRequestGet();

    </script>
</body>

</html>