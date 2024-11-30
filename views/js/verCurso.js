let AllLevels = [];
let MyLevels = [];
let currentLevel = 0;
let canCalif = false;
let commented = false;

function sendRequestGet(id) {
    fetch(`http://localhost:80/DiGITAL/courses/getBought?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response);
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
            console.log(response);
            response.data.forEach((level) => {
                MyLevels.push(level);
            })
        }).then(() => {
            currentLevel = MyLevels[0].numero;
            // console.log(currentLevel)

            console.log('myLevels', MyLevels);
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




    // en caso de que ya haya calificado
    if (course.calificacion != null) {
        document.getElementById("urlCalif").style.background = "gray";
        // document.getElementById("urlCalif").removeAttribute("href");
        // document.getElementById("urlCalif").addEventListener("click", () => {
        //     alert('Ya no puede calificar un curso después de haberlo calificado anteriormente')
        // })
        commented = true;
    }

    let progreso = parseFloat(course.progreso);

    if (progreso >= 100) {
        // console.log('progreso = ', progreso)
        // document.getElementById('urlCalif').href = NewSrc;
        canCalif = true;
    }

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
            // console.log(currentLevel)

            if (renderLevelData(item.id)) {
                document.querySelectorAll('.list-group-item').forEach(element => {
                    element.classList.remove('active');
                });
                item.classList.remove('mine');
                item.classList.add('active');
            }
            MyLevels.forEach((level) => {
                if (level.numero != currentLevel) {
                    // console.log('numero con mine', level.numero, currentLevel);
                    // console.log(document.getElementById(level.numero));
                    document.getElementById(level.numero).classList.add('mine')
                }
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
            if (a.videoPath == null) {
                a.videoPath = 0;
            }

            if (a.videoPath.length > 0) {
                let videoPath = "http://localhost" + a.videoPath.split('xampp2/htdocs')[1];

                document.getElementById("videoSource").src = videoPath;
                // document.getElementById("MyVideo").id = a.idArchivo;
                document.getElementById("MyVideo").load();
                document.getElementById("MyVideo").name = a.idNivel;
                document.getElementById('level-name').textContent = a.nombre;
                let archivo = document.createElement('li');
                archivo.innerHTML = `
                <a href="#" id="${a.idArchivo}" >${a.nombreArchivo}</a>`;

                lista.appendChild(archivo);

                // const video = iframeDocument.getElementById('myVideo').addEventListener('play', (e) => {
                //     console.log(currentLevel);

                //     if (currentLevel <= 0) {
                //         return;
                //     }

                //     console.log('play');
                // })

            } else {
                const mimeType = a.mimeType;
                const blob = base64ToBlob(a.archivo, mimeType);
                const url = URL.createObjectURL(blob);


                document.getElementById('level-name').textContent = a.nombre;
                let archivo = document.createElement('li');
                archivo.innerHTML = `
                <a href="${url}"  target="_blank">${a.nombreArchivo}</a>`;

                lista.appendChild(archivo);
            }

        }
    });
    return true;
}

const params = new URLSearchParams(window.location.search);
const id = params.get('id');
sendRequestGet(id);

// let NewSrc = document.getElementById('urlCalif').href;

const video = document.getElementById("MyVideo");
video.addEventListener('play', () => {
    console.log("se está reproduciendo el video: ", video.name);
    const idLevel = video.name;

    console.log('intentando completar el nivel:', idLevel);

    fetch(`http://localhost:80/DiGITAL/levels/completeLevel?id=${idLevel}`)
        .then((response) => {
            return response.json()
        }).then((response) => {
            console.log(response);
        })
})

document.getElementById('calif-button').addEventListener('click', () => {
    if (commented) {
        alert('Ya publicó su comentario, acción no válida');
        return;
    }

    if (!canCalif) {
        alert('requiere terminar el curso para poder calificarlo')
        return;
    }

    window.location.href = globalURL + '/calificarCurso' + "?id=" + id;

})

// const iframe = document.getElementById("video");
// const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
