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
            <h2>Curso: Frontend para principiantes</h2>

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
                <tbody>
                    <tr>
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
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total de Ingresos</td>
                        <td colspan="2">$300.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>