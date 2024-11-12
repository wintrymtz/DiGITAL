const params = new URLSearchParams(window.location.search);
const User2Id = params.get('id');
let userData;


function sendMessage() {
    let message = document.getElementById("message-input").value;
    let date = new Date();
    let newDate = formatTime(date);

    const container = document.getElementById("chat-body");

    let messageDiv = document.createElement("div");
    messageDiv.classList.add("message");
    messageDiv.classList.add("right");
    messageDiv.innerHTML = `
                    <div class="message-content">
                        <p>${message}</p>
                        <span class="timestamp">${newDate}</span>
                    </div>
                    <span class="image-container">
                        <img class="avatar-image" src="${profileImage}">
                    </span>
                    `;
    container.appendChild(messageDiv);

    if (User2Id !== undefined) {
        sendRequestSendMessage(message);
        document.getElementById("message-input").value = "";
    }
}

function formatTime(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';

    // Convertir a formato 12 horas
    hours = hours % 12;
    hours = hours ? hours : 12; // El ‘0’ en horas debería ser ‘12’

    // Añadir un cero delante si los minutos son menores a 10
    minutes = minutes < 10 ? '0' + minutes : minutes;

    // Combinar todo
    return `${hours}:${minutes} ${ampm}`;
}

function sendRequestSendMessage(mensaje) {
    fetch('http://localhost:80/DiGITAL/message/send', {
        method: 'POST',
        body: JSON.stringify({ idUsuario2: User2Id, mensaje: mensaje })
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        console.log(response['msg']);
        // window.location.reload();
    }).catch((error) => {
        console.log(error);
    });
}

function sendRequestGetMessages(User2) {
    fetch('http://localhost:80/DiGITAL/message/get', {
        method: 'POST',
        body: JSON.stringify({ idUsuario2: User2 })
    }).then((response) => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then((response) => {
        console.log(response);
        userData = response.user;
        renderAllMessages(response["data"]);
        document.getElementById('instructor-name').textContent = userData.nombre;
        // window.location.reload();
    }).catch((error) => {
        console.log(error);
    });
}

function renderAllMessages(data) {

    data.forEach(message => {
        let timeStamp = message.fechaMensaje;
        const date = new Date(timeStamp.replace(' ', 'T') + 'Z'); // Convierte a formato ISO

        if (message.idUsuario2 == User2Id) {
            renderMessage(message.Mensaje, true, date);
        } else {
            renderMessage(message.Mensaje, false, date);
        }
    });
}

function renderMessage(message, mine, date) {
    let newDate = formatTime(date);
    const container = document.getElementById("chat-body");
    let messageDiv = document.createElement("div");

    if (mine) {
        messageDiv.classList.add("message");
        messageDiv.classList.add("right");
        messageDiv.innerHTML = `
                        <div class="message-content">
                            <p>${message}</p>
                            <span class="timestamp">${newDate}</span>
                        </div>
                        <span class="image-container">
                            <img class="avatar-image" src="${profileImage}">
                        </span>
                        `;
    } else {
        messageDiv.classList.add("message");
        messageDiv.classList.add("left");
        messageDiv.innerHTML = `
                        <div class="message left">
                            <span class="image-container">
                                <img class="avatar-image" src="data:${userData.mimeType};base64,${userData.foto}">
                            </span>
                            <div class="message-content">
                                <p>${message}</p>
                                <span class="timestamp">${newDate}</span>
                            </div>
                        </div>
                        `;
    }
    container.appendChild(messageDiv);
}

sendRequestGetMessages(User2Id);
