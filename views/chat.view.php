<?php 
$css = getFile('/chat', 'css');
include('partials/head.php');
include('partials/nav.php');
 ?>
    <div class="main-container">
        <div class="chat-container">
            <!-- Encabezado del chat, mostrando el nombre del maestro -->
            <div class="chat-header">
                <h2>Chat</h2>
                <p id="instructor-name">Nombre del instructor (Instructor)</p>
            </div>

            <!-- Cuerpo del chat, donde se muestran los mensajes -->
            <div id="chat-body" class="chat-body">
                <!-- Mensaje del maestro -->
                <!-- <div class="message left">
                    <span class="image-container">
                        <img class="avatar-image" src="img/face1.jpg">
                    </span>
                    <div class="message-content">
                        <p>Hola, ¿cómo puedo ayudarte hoy?</p>
                        <span class="timestamp">10:00 AM</span>
                    </div>
                </div> -->

                <!-- Mensaje del estudiante -->
                <!-- <div class="message right">
                    <div class="message-content">
                        <p>Buenos días, tengo una duda sobre la tarea de matemáticas.</p>
                        <span class="timestamp">10:02 AM</span>
                    </div>
                    <span class="image-container">
                        <img class="avatar-image">
                    </span>
                </div> -->

                <!-- Otro mensaje del maestro -->
                <!-- <div class="message left">
                    <span class="image-container">
                        <img class="avatar-image" src="img/face1.jpg">
                    </span>
                    <div class="message-content">
                        <p>Claro, ¿qué te gustaría saber?</p>
                        <span class="timestamp">10:03 AM</span>
                    </div>
                </div> -->
            </div>

            <!-- Pie de página del chat, donde el estudiante puede escribir su mensaje -->
            <div class="chat-footer">
                <input id="message-input" type="text" placeholder="Escribe tu mensaje aquí..." />
                <button onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>
</body>
<script>
    const profileImage = "data:<?=$_SESSION['mimeType'] ?>;base64,<?=$_SESSION['foto'] ?>"
</script>
<script src="<?=getFile('/chat','js')?>"></script>

</html>