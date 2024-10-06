<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <link rel="shortcut icon" href="img/icono por mientras.png" type="image/x-icon">
    <link rel="stylesheet" href="css/InicioSesion.css">
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form id="sesionForm">
            <input id="email" type="email" placeholder="Correo Electrónico" required>
            <input id="password" type="password" placeholder="Contraseña" required>
            <button type="submit" onclick="iniciarSesion()">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registrarse.view.php">Regístrate aquí</a></p>
    </div>

    <script src="js/inicioSesion.js"></script>
</body>

</html>