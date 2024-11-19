<?php 
$css = getFile('/ventasCurso', "css");
include('partials/nav.php');
include('partials/head.php');
?>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Título de la página -->
        <h1>Detalle de Alumnos por Curso</h1>

        <!-- Información detallada de cada alumno inscrito en un curso -->
        <div class="course-details">
            <h2 id="nombre">Curso: Frontend para principiantes</h2>

            <table>
                <thead>
                    <tr>
                        <th>Nombre del Alumno</th>
                        <th>Fecha de Inscripción</th>
                        <th>Nivel de Avance</th>
                        <th>Precio Pagado</th>
                        <th>Forma de Pago</th>
                    </tr>
                </thead>
                <tbody id="table">
                    <!-- <tr>
                        <td>Juan Pérez</td>
                        <td>01 Ene 2024</td>
                        <td>3</td>
                        <td>$100.00</td>
                        <td>Tarjeta</td>
                    </tr>
                    <tr>
                        <td>María López</td>
                        <td>05 Ene 2024</td>
                        <td>2</td>
                        <td>$100.00</td>
                        <td>PayPal</td>
                    </tr>
                    <tr>
                        <td>Carlos González</td>
                        <td>10 Ene 2024</td>
                        <td>3</td>
                        <td>$100.00</td>
                        <td>Tarjeta</td>
                    </tr> -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total de Ingresos</td>
                        <td id="total" colspan="2">$000.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
<script src="<?=getFile('/validUs','js')?>"></script>

<script>

const url = "<?=getProjectRoot(null)?>";
let students =[];

const params = new URLSearchParams(window.location.search);
const cursoID = params.get('id');
const cursoNombre = params.get('nombre');
    
function getCourses(id){
    
    fetch(`http://localhost:80/DiGITAL/courses/show-one-created?id=${id}`)
        .then((response) => {
            return response.json()
        }).then((response) => {
            console.log(response);
            students = response.data;
            renderData(students);
        })
}


function filterData(data){
    renderData(data);
}

function renderData(data){
    const table = document.getElementById("table");
    console.log(data);
    let finalTotal = 0;

    data.forEach((alumno) =>{
        let precioPagado = parseFloat(alumno.PrecioPagado);

        finalTotal += precioPagado;

        let fechaInscripcion = timeStampToDate(alumno.FechaInscripcion);
       

        let item = document.createElement("tr");
        let itemURL = url+'/ventasCurso?id=' + alumno.idCurso;
        let chatURL = url + "/chat?id=" + alumno.idUsuario;
        item.innerHTML = `
                     <tr>
                        <td><a href=${chatURL}>${alumno.Alumno}</a></td>
                        <td>${fechaInscripcion}</td>
                        <td>%${alumno.progreso}</td>
                        <td>$${alumno.PrecioPagado}</td>
                        <td>${alumno.metodoPago}</td>
                    </tr>
        `;
        table.appendChild(item);
    })

    document.getElementById("total").textContent = '$'+ finalTotal.toFixed(2);
}

getCourses(cursoID);
document.getElementById("nombre").textContent ="Curso: "+ cursoNombre;
</script>
</html>