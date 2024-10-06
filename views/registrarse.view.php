<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="shortcut icon" href="img/icono por mientras.png" type="image/x-icon">
    <link rel="stylesheet" href="css/registrarse.css">
</head>

<body>
    <div class="register-container">
        <h2>Registrarse</h2>
        <form id="formulario">
            <input id="name" type="text" placeholder="Nombre Completo" required>
            <input id="email" type="email" placeholder="Correo Electrónico" required>
            <input id="password1" type="password" placeholder="Contraseña" required>
            <input id="password2" type="password" placeholder="Confirmar Contraseña" required>
            <div class="radio-container">
                <input id="estudiante" type="radio" value="estudiante" name="userType" required>
                <label for="estudiante">Estudiante</label>
                <input id="instructor" type="radio" value="instructor" name="userType" required>
                <label for="instructor">Instructor</label>
            </div>
            <button type="submit" onclick="validate()">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="inicioSesion.view.php">Inicia Sesión</a></p>
    </div>
</body>
<script src="js/validUs.js"></script>
<script src="js/registrarse.js"></script>

</html>