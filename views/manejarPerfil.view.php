
<?php 
$css = getFile('/manejarPerfil', 'css');
include('partials/head.php');
include('partials/nav.php');
 ?>
    <div class="main-container" >

        <section class="right-side">
            <h2>Cuenta</h2>
            <div class="avatar-inf">
                <h4>Avatar</h4>
                <form class="img-form" id="formulario-foto">
                    <img id="avatar-img" src="https://i.pinimg.com/564x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg" alt="avatar-icon"
                        width="200" height="200" style="border-radius: 50%"></img>
                    <br>

                    <button class="button-type" type="button">
                        <label for="avatar-input">Actualizar Imagen</label>
                    </button>
                    <input id="avatar-input" type="file" style="display: none;" accept=".jpg,.png"></input>

                    <input type="submit" value="Confirmar" onclick="validatePhoto()">
                </form>

            </div>
            <div class="personal-inf">
                <h4>Información personal</h4>
                <form id="formulario-datos" class="personal-form">
                    <div class="name-input">
                        <input id="name" type="text" placeholder="Nombre" required>
                    </div>

                    <div class="lastname-input">
                        <input id="lastname" type="text" placeholder="Apellidos" required>
                    </div>
                    <div class="email-input">
                        <input id="email" type="email" placeholder="Correo electrónico" required>
                    </div>
                    <div class="date-input">
                        <label>Fecha de nacimiento:</label>
                        <input id="date" type="date" required>
                    </div>
                    <div class="gender-input">

                        <div>
                            <label>Género:</label>
                            <input type="radio" id="hombre" name="gender" value="hombre" required>
                            <label for="hombre">Hombre</label>

                            <input type="radio" id="mujer" name="gender" value="mujer" required>
                            <label for="mujer">Mujer</label>

                            <input type="radio" id="otro" name="gender" value="otro" required>
                            <label for="otro">Otro</label>
                        </div>
                    </div>
                    <input type="submit" onclick="updateUser()">
                </form>
            </div>
            <div class="password-inf">
                <h4>Cambiar contraseña</h4>
                <form id="formulario-pass" class="password-form">
                    <div class="password-input">
                        <input id="oldPassword" type="password" placeholder="Contraseña actual" required>
                    </div>
                    <div class="password-input">

                        <input id="newPassword" type="password" placeholder="Nueva contraseña" required>
                    </div>
                    <input type="submit" onclick="updatePassword()">
                </form>
            </div>
        </section>

    </div>
    <script src="<?=getFile('/validUs', 'js')?>"></script>
    <script src="<?=getFile('/manejarPerfil', 'js')?>"></script>
</body>

</html>