let explorar = document.getElementsByName('imagenes');

explorar.forEach((ex) => {
    ex.addEventListener('click', () => {
        window.location.href = 'comprarCurso.view.php'
    })
})

document.querySelectorAll(".carousel").forEach(carousel => {

    const items = carousel.querySelectorAll(".carousel__item");
    const buttonsHtml = Array.from(items, () => {
        return `<span class="carousel__button"></span>`
    });

    carousel.insertAdjacentHTML("beforeend", `
        <div class="carousel__nav">
        <h2 style="color:white">Matemáticas para Videojuegos</h2>
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
            window.location.href = "./comprarCurso";
        })
    })

});