<!DOCTYPE html>
<html lang="es">

<head>
    <title>Buscar curso</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/kardex.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
</head>

<body>
<?php include('partials/nav.php') ?>

    <section class="main-container">
        <div class="filter-section">
            <h3>Filtrar:</h3>
            <form>
                <span class="filter-option">
                    <label>Fecha de inscripción</label>
                    <input type="date">
                    <label>-</label>
                    <input type="date">
                </span>
                <span class="filter-option">
                    <select>
                        <option>categoria1</option>
                        <option>categoria2</option>
                        <option>categoria3</option>
                    </select>
                </span>
                <span class="filter-option">
                    <select>
                        <option>Terminado</option>
                        <option>Todos</option>
                    </select>
                </span>
                <span class="filter-option">
                    <select>
                        <option>Activos</option>
                        <option>Todos</option>
                    </select>
                </span>

                <span class="filter-option">
                    <input type="submit" value="Filtrar">
                </span>

            </form>
        </div>
        <div class="kardex-section  ">
            <div>
                <h4>Kardex</h4>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Progreso</th>
                        <th>Ultima fecha de ingreso</th>
                        <th>Fecha inscripción</th>
                        <th>Fecha terminado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="verCurso.view.php">Matematicas para Videojuegos</a></td>
                        <td>70%</td>
                        <td>15 SEP 2024</td>
                        <td>1 SEP 2024</td>
                        <td>13 SEP 2024</td>
                    </tr>
                    <tr>
                        <td><a href="verCurso.view.php">Frontend para principiantes</a></td>
                        <td>90%</td>
                        <td>20 NOV 2020</td>
                        <td>6 NOV 2020</td>
                        <td>17 NOV 2020</td>
                    </tr>
                    <tr>
                        <td><a href="verCurso.view.php">Curso de winAPI</a></td>
                        <td><a href="certificado/Diploma.html">100%</a></td>
                        <td>25 ENE 2015</td>
                        <td>15 ENE 2015</td>
                        <td>23 ENE 2015</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>