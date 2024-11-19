let explorar = document.getElementsByName('imagenes');


function sendRequestGet() {
    fetch('http://localhost:80/DiGITAL/courses/show-specials', {
    }).then((response) => {
        return response.json();
    }).then((response) => {
        data = response;
        renderCourses(data.calificacion, data.recientes, data.vendidos);
        console.log(data);
    }).catch((error) => {
        console.log(error);
    });
}

function renderCourses(calificaciones, recientes, vendidos) {
    const contenedorCalificacion = document.getElementById("valorados-carousel");
    const contenedorRecientes = document.getElementById("recientes-carousel");
    const contenedorVendidos = document.getElementById("vendidos-carousel");

    calificaciones.forEach((e) => {
        let item = document.createElement('div');
        item.classList.add("carousel__item");
        item.id = e.idCurso;
        item.innerHTML = `
        <h2 class="carousel-txt">${e.nombreCurso}</h2>
        <img class="carousel-img" src="data:${e.mimeType}; base64, ${e.foto} ">
        `;
        contenedorCalificacion.appendChild(item);
    });

    recientes.forEach((e) => {
        let item = document.createElement('div');
        item.classList.add("carousel__item");
        item.id = e.idCurso;
        item.innerHTML = `
                <h2 class="carousel-txt">${e.nombreCurso}</h2>
        <img class="carousel-img" src="data:${e.mimeType}; base64, ${e.foto} ">
        `;
        contenedorRecientes.appendChild(item);
    });

    vendidos.forEach((e) => {
        let item = document.createElement('div');
        item.classList.add("carousel__item");
        item.id = e.idCurso;
        item.innerHTML = `
                <h2 class="carousel-txt">${e.nombreCurso}</h2>
        <img class="carousel-img" src="data:${e.mimeType}; base64, ${e.foto} ">
        `;
        contenedorVendidos.appendChild(item);
    });

    update();
}



explorar.forEach((ex) => {
    ex.addEventListener('click', () => {
        window.location.href = 'comprarCurso.view.php'
    })
})

function update() {
    document.querySelectorAll(".carousel").forEach(carousel => {

        const items = carousel.querySelectorAll(".carousel__item");
        const buttonsHtml = Array.from(items, () => {
            return `<span class="carousel__button"></span>`
        });

        carousel.insertAdjacentHTML("beforeend", `
            <div class="carousel__nav">
            ${buttonsHtml.join("")}
            </div>
            `)

        const buttons = carousel.querySelectorAll(".carousel__button");

        buttons.forEach((button, i) => {
            button.addEventListener("click", () => {
                //unselect all the items
                items.forEach(item => item.classList.remove("carousel__item--selected"))
                buttons.forEach(button => button.classList.remove("carousel__button--selected"))

                items[i].classList.add("carousel__item--selected");
                buttons[i].classList.add("carousel__button--selected");

            })
        })

        //select first item
        items[0].classList.add("carousel__item--selected");
        buttons[0].classList.add("carousel__button--selected");

        items.forEach((item, i) => {
            item.addEventListener("click", () => {
                window.location.href = url + "/comprarCurso?id=" + item.id;
                console.log(item.id);
            })
        })

    });
}


sendRequestGet();