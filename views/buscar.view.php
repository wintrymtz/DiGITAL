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
            let firstDate = document.getElementById('firstDate');
            let lastDate = document.getElementById('lastDate');

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
                filterCourses(data, false);

            }).catch((error) => {
                console.log(error);
            });
        }


        function filterCourses(data, category){
            if(!category){
                renderCourses(courses);
                return;
            } else{
                if(selectedCategories.length <= 0){
                    renderCourses(courses);
                return;
                }
                let filteredCourses = courses.filter(course => {
                    // Verifica si al menos una categoría del curso coincide con las seleccionadas
                    return course.categorias.some(courseCategory => {
                        return selectedCategories.some(selectedCategory => selectedCategory.idCategoria === courseCategory.idCategoria);
                    });
                });
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
                        <a class="autor" href="chat.view.php">${element.nombreUsuario}
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