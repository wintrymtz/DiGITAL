let courses = [];

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

function filterCourses(data, filter1) {
    let filteredCourses = [];
    renderCourses(data);
}

function renderCourses(data) {
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

        element.innerHTML = `
        <tr>
            <td><a href="${url}">${course.Curso}</a></td>
            <td>${course.progreso}%</td>
            <td>${fechaUltimoIngreso}</td>
            <td>${fechaInicio}</td>
            <td>${fechaTerminado}</td>
        </tr>
        `;
        table.appendChild(element);
    });
}


function timeStampToDate(timeStamp) {
    if (timeStamp !== null) {
        const date = new Date(timeStamp.replace(' ', 'T') + 'Z'); // Convierte a formato ISO

        let year = date.getFullYear();
        let day = date.getDate();
        let month = date.toLocaleString('en-US', { month: 'short' }).toUpperCase();
        return day + ' ' + month + ' ' + year;
    } else {
        return 'No definido';
    }

}
sendRequestGet();