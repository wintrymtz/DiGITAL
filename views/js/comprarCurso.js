let comments = document.getElementsByName('comentario');
let cursoData;
let nivelesData = [];
let nivelesSeleccionados = [];

comments.forEach(function (c) {
    c.addEventListener('click', function () {
        prompt('Razón por la que se elimina:')
    });
});

function eliminarCurso() {
    if (confirm('Está a punto de eliminar un curso, no se podrá deshacer la acción ¿Está seguro?')) {
        if (id != undefined && id != null) {
            fetch(`http://localhost:80/DiGITAL/courses/disable?id=${id}`).
                then(response => {
                    return response.json();
                }).then(response => {
                    alert(response['msg']);
                    window.history.back();
                })
        }
        //dar de baja
    }
}

function buyCourseComplete(path) {
    let idArray = [];
    nivelesData.forEach((nivel) => {
        idArray.push(nivel.idNivel);
    })


    window.location.href = path +
        '?id=' + encodeURIComponent(id) +
        '&nombre=' + encodeURIComponent(cursoData.nombre) +
        '&costo=' + encodeURIComponent(cursoData.costo) +
        '&nivelesId=' + encodeURIComponent(idArray.join(','));
}

function buyLevels(path) {

    if (nivelesSeleccionados.length < 1) {
        alert('Requiere seleccionar al menos un nivel');
        return;
    }

    let namesArray = [];
    let costsArray = [];
    let idArray = [];

    nivelesData.forEach((nivel) => {
        if (nivelesSeleccionados.includes(String(nivel.idNivel))) {
            costsArray.push(nivel.costo);
            namesArray.push(nivel.nombre);
            idArray.push(nivel.idNivel);
        }
    })

    console.log(nivelesSeleccionados, nivelesData);
    console.log(idArray);

    window.location.href = path +
        '?id=' + encodeURIComponent(id) +
        '&nombre=' + encodeURIComponent(cursoData.nombre) +
        '&nivelesNombres=' + encodeURIComponent(namesArray.join(',')) +
        '&nivelesCostos=' + encodeURIComponent(costsArray.join(',')) +
        '&nivelesId=' + encodeURIComponent(idArray.join(','));

}

function sendRequestGet(id) {
    fetch(`http://localhost:80/DiGITAL/courses/get?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response['data']);
            renderInformation(response['data'].curso, response['data'].niveles);
        }).then(() => {
            console.log('terminó');
        })
}

function sendRequestGetComments(id) {
    fetch(`http://localhost:80/DiGITAL/comments/getAll?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response['data']);
            renderComments(response['data'])
        }).then(() => {
            console.log('terminó');
        })
}

function renderInformation(curso, niveles) {

    document.getElementById('course-title').textContent = curso['nombre'];
    document.getElementById('description').textContent = curso['descripcion'];
    document.getElementById('inidividual-cost').textContent = curso['costo'];
    document.getElementById('course-image').src = `data:${curso.mimeType};base64,${curso.foto}`;

    if (curso.PorNivel === 0) {
        document.getElementById("buyIndividual").style.display = "none";
    } else {
        document.getElementById("buyComplete").style.display = "none";
    }

    let califcacion = parseFloat(curso.calificacion);
    califcacion = califcacion.toFixed(1);
    let calif = Math.round(califcacion);
    let textInput = document.getElementById("calif");
    let text = 'Calificación general: ';
    let stars = "";
    switch (calif) {
        case 1:
            stars = '★☆☆☆☆';
            break;

        case 2:
            stars = '★★☆☆☆';
            break;

        case 3:
            stars = '★★★☆☆';
            break;

        case 4:
            stars = '★★★★☆';
            break;

        case 5:
            stars = '★★★★★';
            break;

        default:
            stars = 'aún no calificado';
            break;
    }
    textInput.textContent = 'Calificación general: ' + stars + " " + `${califcacion}/5`;

    cursoData = curso;

    let levelList = document.getElementById('level-list');
    niveles.forEach((nivel) => {
        nivelesData.push(nivel);

        let liNivel = document.createElement('li');
        liNivel.id = nivel.idNivel;
        if (curso.PorNivel == 0) {
            liNivel.innerHTML = `
            <a class="active" href="#">Nivel ${nivel.numero}: ${nivel.nombre}     </a>
            `;
        } else {
            liNivel.innerHTML = `
            <a href="#">Nivel ${nivel.numero}: ${nivel.nombre}     <label style="color:black">$${nivel.costo}</label> <input type="checkbox"></a>
            `;

            liNivel.addEventListener('click', () => {
                let a = liNivel.querySelector('a');
                let input = liNivel.querySelector('input');

                if (a.classList.contains("active")) {
                    liNivel.querySelector('a').classList.remove("active");
                    input.removeAttribute('checked');

                    let indice = nivelesSeleccionados.indexOf(liNivel.id);
                    if (indice !== -1) {
                        nivelesSeleccionados.splice(indice, 1);
                    }

                } else {
                    liNivel.querySelector('a').classList.add("active");
                    input.setAttribute('checked', '');

                    nivelesSeleccionados.push(liNivel.id)
                }
            });
        }
        levelList.appendChild(liNivel);
    })


}

/* <label class="fecha">10-sep-2012 12:35</label>`; */


function renderComments(data) {
    const commentList = document.getElementById("comment-list");

    data.forEach((e) => {
        let item = document.createElement("li");

        if (e.estadoComentario == 1) {
            item.name = "comentario";
            item.id = e.idUsuario;
            item.innerHTML = `
            <label>${e.nombre}: ${e.comentario}</label>
            <label class="fecha">${e.fechaComentario}</label>`;
        } else {
            item.id = 0;
            item.innerHTML = `<i>Mensaje Eliminado por un Administrador</i>
                `;

        }
        commentList.appendChild(item);

        item.addEventListener(('click'), (e) => {
            let causa = prompt('Razón por la que se elimina:');
            let idUsuario = item.id;
            if (confirm("¿Seguro que quiere dar de baja este comentario?")) {
                fetch(`http://localhost:80/DiGITAL/comments/delete`, {
                    method: "POST",
                    body: JSON.stringify({
                        idComentario: idUsuario,
                        idCurso: id,
                        causa: causa
                    })
                })
                    .then(response => {
                        return response.json();
                    }).then(response => {
                        console.log(response);
                    }).then(() => {
                        console.log('terminó');
                    })
            }
        })

    })

}

function deleteComment(id) {
    fetch(`http://localhost:80/DiGITAL/comments/getAll?id=${id}`)
        .then(response => {
            return response.json();
        }).then(response => {
            console.log(response['data']);
            renderComments(response['data'])
        }).then(() => {
            console.log('terminó');
        })
}
const params = new URLSearchParams(window.location.search);
const id = params.get('id');

console.log('id', id);
sendRequestGet(id);
sendRequestGetComments(id);