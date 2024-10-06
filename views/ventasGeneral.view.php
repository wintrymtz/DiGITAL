<?php
 $css = getFile('/ventasGeneral', 'css');
 include('partials/nav.php');
 include('partials/head.php');

 ?>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Título de la página -->
        <h1>Reporte de Ingresos por Cursos</h1>

        <!-- Filtros para la obtención de reportes -->
        <div class="filters">
            <label for="dateRange">Rango de Fechas:</label>
            <input type="date" id="dateRangeStart">
            <input type="date" id="dateRangeEnd">

            <label for="category">Categoría:</label>
            <select id="category">
                <option value="all">Todas</option>
                <option value="programacion">Programación</option>
                <option value="diseño">Diseño</option>
                <option value="marketing">Marketing</option>
            </select>

            <label for="status">Estado del Curso:</label>
            <select id="status">
                <option value="active">Activos</option>
                <option value="all">Todos</option>
            </select>
        </div>

        <!-- Lista de cursos con detalles de ingresos -->
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Alumnos Inscritos</th>
                    <th>Nivel Promedio</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <a href="<?=getProjectRoot('/ventasCurso')?>">Matemáticas para Videojuegos</a></td>
                    <td>50</td>
                    <td>3</td>
                    <td>$300.00</td>
                </tr>

                <tr>
                    <td>Frontend para principiantes</td>
                    <td>30</td>
                    <td>4</td>
                    <td>$3,000.00</td>
                </tr>
                <tr>
                    <td>Curso de WinAPI</td>
                    <td>40</td>
                    <td>5</td>
                    <td>$4,500.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total de Ingresos</td>
                    <td>$12,500.00</td>
                </tr>
                <!-- Desglose por forma de pago -->
                <tr>
                    <td colspan="3">Ingresos por Tarjeta</td>
                    <td>$7,500.00</td>
                </tr>
                <tr>
                    <td colspan="3">Ingresos por PayPal</td>
                    <td>$5,000.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>