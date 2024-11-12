let radioStars = document.getElementsByName('rating1');
console.log(radioStars);
let starsOver = false;
let canVote = true;
let finalRating = 0;
let AllLevels = [];
let MyLevels = [];
let currentLevel = 0;

radioStars.forEach((rd) => {
    rd.addEventListener('mouseover', () => {
        if (canVote) {
            starsOver = true;
            checkRating(rd.id);
        }

    })
})


radioStars.forEach((rd) => {
    rd.addEventListener('mouseleave', () => {
        if (canVote) {
            starsOver = false;
            checkRating(rd.id);
        }
    })
})

radioStars.forEach((rd) => {
    rd.addEventListener('click', () => {
        if (canVote) {
            alert('Se ha mandado la calificacion');
            canVote = false;
        }

    })
})

function checkRating(calif) {
    console.log(starsOver);
    switch (calif) {
        case '0':
            radioStars[0].style.color = "black";
            radioStars[1].style.color = "black";
            radioStars[2].style.color = "black";
            radioStars[3].style.color = "black";
            radioStars[4].style.color = "black";
            finalRating = 0;
            break;
        case '1':
            radioStars[0].style.color = "yellow";
            finalRating = 1;
            break;

        case '2':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            finalRating = 2;
            break;

        case '3':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            finalRating = 3;
            break;

        case '4':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            radioStars[3].style.color = "yellow";
            finalRating = 4;
            break;

        case '5':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            radioStars[3].style.color = "yellow";
            radioStars[4].style.color = "yellow";
            finalRating = 5;
            break;
    }

    if (!starsOver) {
        radioStars[0].style.color = "black";
        radioStars[1].style.color = "black";
        radioStars[2].style.color = "black";
        radioStars[3].style.color = "black";
        radioStars[4].style.color = "black";
    }
}

function sendRequestGet(id) {
    fetch(`http://localhost:80/DiGITAL/courses/get?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response['data']);
            return {
                id: id,
                curso: response['data'].curso,
                niveles: response['data'].niveles,
            }
        }).then((data) => {
            sendRequestGetMyLevels(data.id);
            return data;
        }).then(data => {
            renderInformation(data.curso, data.niveles);
        })
}

function sendRequestGetMyLevels(idCurso) {
    fetch(`http://localhost:80/DiGITAL/levels/get?id=${idCurso}`)
        .then(response => {
            return response.json();
        }).then(response => {
            response.data.forEach((level) => {
                MyLevels.push(level);
            })
        }).then(() => {
            currentLevel = MyLevels[0].numero;
            console.log(currentLevel)

            console.log(MyLevels);
            renderLevelData(currentLevel);
        }).then(() => {
            MyLevels.forEach((level) => {
                document.getElementById(level.numero).classList.add('mine');
            });
        })
}

function renderInformation(course, _levels) {
    document.getElementById('course-name').textContent = course.nombre;
    let instrctorElement = document.getElementById('instructor-name');
    instrctorElement.textContent = course.nombreInstructor;
    instrctorElement.id = course.idInstructor;
    instrctorElement.href = urlChat + '?id=' + course.idInstructor;

    const container = document.getElementById('levels-container');

    _levels.forEach((level) => {
        let item = document.createElement('a');
        item.classList.add("list-group-item");
        item.classList.add("list-group-item-action");
        item.id = level.numero;
        item.textContent = `Nivel ${level.numero}:` + ' ' + level.nombre;
        AllLevels.push(level);


        container.appendChild(item);



        item.addEventListener('click', () => {
            currentLevel = item.id;
            console.log(currentLevel)

            if (renderLevelData(item.id)) {
                document.querySelectorAll('.list-group-item').forEach(element => {
                    element.classList.remove('active');
                });
                item.classList.remove('mine');
                item.classList.add('active');
            }
            MyLevels.forEach((level) => {
                if (level.numero != currentLevel)
                    document.getElementById(level.numero).classList.add('mine');
            });
        });
    })
}

function base64ToBlob(base64, mimeType) {
    const binaryString = window.atob(base64);  // Decodificar base64
    const len = binaryString.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    return new Blob([bytes], { type: mimeType });
}

function renderLevelData(index) {
    let lista = document.getElementById('materiales');

    const existe = MyLevels.some(level => level.numero == index);

    if (!existe) {
        alert('Requiere comprar este nivel para poder revisarlo');
        return false;
    }


    document.querySelectorAll('#materiales li').forEach(element => {
        element.remove();
    });

    MyLevels.forEach((a) => {

        if (a.numero == index) {

            const mimeType = a.mimeType;
            const blob = base64ToBlob(a.archivo, mimeType);
            const url = URL.createObjectURL(blob);


            document.getElementById('level-name').textContent = a.nombre;
            let archivo = document.createElement('li');
            archivo.innerHTML = `
            <a href="${url}"  target="_blank">${a.nombreArchivo}</a>`;

            lista.appendChild(archivo);
        }
    });
    return true;
}

const params = new URLSearchParams(window.location.search);
const id = params.get('id');
sendRequestGet(id);
console.log('over')
