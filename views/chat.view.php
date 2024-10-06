<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="css/chat.css">


    <!--navbar links-->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">

</head>

<body>
<?php include('partials/nav.php') ?>

    <div class="main-container">
        <div class="chat-container">
            <!-- Encabezado del chat, mostrando el nombre del maestro -->
            <div class="chat-header">
                <h2>Chat</h2>
                <p>Isaac Nehemías Mata Dominguez (Instructor)</p>
            </div>

            <!-- Cuerpo del chat, donde se muestran los mensajes -->
            <div class="chat-body">
                <!-- Mensaje del maestro -->
                <div class="message left">
                    <span class="image-container">
                        <img class="avatar-image" src="img/face1.jpg">
                    </span>
                    <div class="message-content">
                        <p>Hola, ¿cómo puedo ayudarte hoy?</p>
                        <span class="timestamp">10:00 AM</span>
                    </div>
                </div>

                <!-- Mensaje del estudiante -->
                <div class="message right">
                    <div class="message-content">
                        <p>Buenos días, tengo una duda sobre la tarea de matemáticas.</p>
                        <span class="timestamp">10:02 AM</span>
                    </div>
                    <span class="image-container">
                        <img class="avatar-image" src="img/face2.jpg">
                    </span>
                </div>

                <!-- Otro mensaje del maestro -->
                <div class="message left">
                    <span class="image-container">
                        <img class="avatar-image" src="img/face1.jpg">
                    </span>
                    <div class="message-content">
                        <p>Claro, ¿qué te gustaría saber?</p>
                        <span class="timestamp">10:03 AM</span>
                    </div>
                </div>
            </div>

            <!-- Pie de página del chat, donde el estudiante puede escribir su mensaje -->
            <div class="chat-footer">
                <input type="text" placeholder="Escribe tu mensaje aquí..." />
                <button>Enviar</button>
            </div>
        </div>
    </div>
</body>

</html>