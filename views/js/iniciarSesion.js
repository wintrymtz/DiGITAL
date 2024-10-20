let formulario = document.getElementById('sesionForm');


formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

async function iniciarSesion() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (!validar(email, password)) {
        return;
    }

    if (await sendRequest(email, password)) {
        window.location.replace("./");
        return;
    }
    document.getElementById('password').value = '';
}

function validar(email, pass) {

    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        formulario.reportValidity();
        return false;
    }

    return true;
}

async function sendRequest(email, password) {
    let formBody = {
        email: email,
        password: password
    };

    let requestState = false;

    await fetch('http://localhost:80/DiGITAL/registrarse/login', {
        method: 'POST',
        body: JSON.stringify(formBody)
    }).then((response) => {

        if (!response.ok) {
            requestState = false;
            throw response;
        } else {
            requestState = true;
        }
        return response.json()
    }).then((response) => {
        alert(response['msg']);
    }).catch(async (error) => {
        const errorResponse = await error.json();
        alert(errorResponse['msg']);
    }).then(() => {
        console.log('terminó');
    });

    console.log(requestState);
    return requestState;
}