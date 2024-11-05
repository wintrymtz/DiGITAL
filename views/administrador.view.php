    <?php
    $css = getFile('/administrador', 'css');
    include('partials/head.php');
    include('partials/nav.php');
     ?>
    <section class="main-container">
        <div class="filter-section">
            <h3>REPORTES DE USUARIOS:</h3>
            <form>
                <span class="filter-option">
                    <select id="tipo-usuario">
                        <option>Instructor</option>
                        <option>Estudiante</option>
                    </select>
                </span>

                <!-- <span class="filter-option">
                    <input type="submit" value="Filtrar">
                </span> -->

            </form>
        </div>
        <div class="reports-section  ">
            <table id="estudiante-tabla" style="display: none;">
                <thead id="thead-table">
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Fecha de ingreso</th>
                        <th>Cursos inscritos</th>
                        <th>%Cursos terminados</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>erick@gmail.com</td>
                        <td>Erick Mauricio Castañeda Garza</td>
                        <td>10-ENE-2010</td>
                        <td>10</td>
                        <td>75%</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                    <tr>
                        <td>isaac@gmail.com</td>
                        <td>Isaac Antonio Dominguez</td>
                        <td>10-SEP-2015</td>
                        <td>3</td>
                        <td>33%</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                    <tr>
                        <td>miCorreoUni@gmail.com</td>
                        <td>Sergio Guerrero Castañeda</td>
                        <td>10-ENE-2024</td>
                        <td>3</td>
                        <td>75%</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                </tbody>
            </table>

            <table id="instructor-tabla" style="display: block;">
                <thead id="thead-table">
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Fecha de ingreso</th>
                        <th>Cursos ofrecidos</th>
                        <th>Total de ganancias</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>maestro1@gmail.com</td>
                        <td>Erick Mauricio Castañeda Garza</td>
                        <td>10-ENE-2010</td>
                        <td>10</td>
                        <td>$200</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                    <tr>
                        <td>maestro2@gmail.com</td>
                        <td>Isaac Antonio Dominguez</td>
                        <td>10-SEP-2015</td>
                        <td>3</td>
                        <td>$1440</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                    <tr>
                        <td>maestro3@gmail.com</td>
                        <td>Sergio Guerrero Castañeda</td>
                        <td>10-ENE-2024</td>
                        <td>3</td>
                        <td>$750</td>
                        <td style="color:red; padding: 10px; cursor: pointer">bloquear<td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="categories-section">
            <h3>ADMINISTRAR CATEGORÍAS:</h3>
            <br>
            <form id='form'>
                <div>
                    <label>Editar categoría:</label>
                    <select id='categoryList'>
                        <option>None</option>
                    </select>
                    <label>o Añadir una nueva:</label>
                    <input id='newCategory' class="textInput" type="text" placeholder="Categoría">
                </div>
                <br>
                <textarea id='newCategoryDesc' class="textArea" placeholder="Descripcion"></textarea>
                <br>
                <input type="submit" onclick='validate()'>
            </form>
        </div>
    </section>
    <script src="<?=getFile('/administrador', 'js') ?>"></script>
</body>