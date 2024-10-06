
<?php 
$css = getFile('/iniciarSesion', 'css');
include('partials/head.php'); 
?>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form id="sesionForm">
            <input id="email" type="email" placeholder="Correo Electrónico" required>
            <input id="password" type="password" placeholder="Contraseña" required>
            <button type="submit" onclick="iniciarSesion()">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="<?= getProjectRoot('/registrarse') ?>">Regístrate aquí</a></p>
    </div>

    <script src="<?= getFile('/iniciarSesion', 'js') ?>"></script>
</body>

</html>