const formulario = document.getElementById("formulario-datos");

const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const lastNameInput = document.getElementById('lastname');
const dateInput = document.getElementById('date');
const radiosInput = document.getElementsByName('gender');

//Formulario de contraseña
const formPassword = document.getElementById('formulario-pass')
const oldPasswordInput = document.getElementById('oldPassword');
const newPasswordInput = document.getElementById('newPassword');

//Formulario foto
const formImage = document.getElementById('formulario-foto');

let gb_email;

formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

formPassword.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

formImage.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

document.getElementById('avatar-input').addEventListener('change', (e) => {
    const file = document.getElementById('avatar-input').files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("avatar-img").src = e.target.result; // Asigna el contenido al src de la imagen
        };

        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
    }
})

async function getUser() {
    //llenar los inputs automaticamente con los datos del usuario

    // //valores dummy
    // nameInput.value = 'Sergio';
    // emailInput.value = 'correo@gmail.com';
    // lastNameInput.value = 'Castañeda Mata';
    // dateInput.value = '2000-02-01';
    // formulario.gender[0].checked = true;
    if (! await getSession()) {
        alert('Sesion no iniciada');
        window.location.href = '/DiGITAL';
    };

    let data = await sendRequest_getUser();
    let user = data['data'];
    console.log(data);

    nameInput.value = user['nombre'];
    emailInput.value = user['email'];
    lastNameInput.value = user['apellido'];
    dateInput.value = user['fechaNacimiento'];
    switch (user['genero']) {
        case 'hombre':
            formulario.gender[0].checked = true;
            break;
        case 'mujer':
            formulario.gender[1].checked = true;
            break;
        case 'otro':
            formulario.gender[2].checked = true;
            break;

        default:
            formulario.gender[0].checked = false;
            formulario.gender[1].checked = false;
    }

    document.getElementById("avatar-img").src = `data:${user.mimeType};base64,${user.foto}`;
}

async function getSession() {

    let request = false;

    await fetch('http://localhost:80/DiGITAL/session/getSession')
        .then(response => response.json())
        .then((user) => {
            console.log('sesion1:' + user);

            if (user === 'fail') {
                request = false;
            } else {
                request = true;
                gb_email = user;
            }

        });

    console.log(request);
    return request;
}

async function sendRequest_getUser() {

    let formBody = {
        email: gb_email
    }
    let requestState = false;
    let data = [];

    await fetch('http://localhost:80/DiGITAL/registrarse/show', {
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
        data = response;
    }).catch(async (error) => {
        const errorResponse = await error.json();
        alert(errorResponse['msg']);
    }).then(() => {
        console.log('terminó');
    });

    return data;
}

async function sendRequest_updateInfo() {
    //Obtenemos valores
    let name = nameInput.value;
    let lastName = lastNameInput.value;
    let email = emailInput.value;
    let date = dateInput.value;
    let gender;

    //Revisamos radio buttons
    for (var i = 0, length = radiosInput.length; i < length; i++) {
        if (radiosInput[i].checked) {
            gender = radiosInput[i].value;
            break;
        }
    }

    let formBody = {
        name: name,
        lastName: lastName,
        newEmail: email,
        oldEmail: gb_email,
        date: date,
        gender: gender
    }

    let requestState = false;

    await fetch('http://localhost:80/DiGITAL/registrarse/update-info', {
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
    }).catch(async (error) => {
        const errorResponse = await error.json();
        alert(errorResponse['errorDetails']);
    }).then(() => {
        console.log('terminó');
    });

    return requestState;
}

async function sendRequest_updatePassword() {

    //Obtenemos valores
    let newPassword = newPasswordInput.value;
    let oldPassword = oldPasswordInput.value;

    let formBody = {
        email: gb_email,
        oldPassword: oldPassword,
        newPassword: newPassword,
    }

    console.log(formBody);

    let requestState = false;
    let data = [];

    await fetch('http://localhost:80/DiGITAL/registrarse/update-password', {
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
        data = response;
    }).catch(async (error) => {
        const errorResponse = await error.json();
        alert(errorResponse['msg']);
    }).then(() => {
        console.log('terminó');
    });

    let result = data['msg'];
    alert(result['response']);

    return requestState;
}

function sendRequest_updatePhoto(image) {
    let formData = new FormData();
    formData.append('image', image);


    fetch('http://localhost:80/DiGITAL/user/update-photo', {
        method: 'POST',
        body: formData
    }).then((response) => {

        if (!response.ok) {
            requestState = false;
            throw response.json();
        } else {
            requestState = true;
        }
        return response.json()
    }).then((response) => {
        alert(response['msg']);
        // console.log('respuesta', response);
    }).catch((error) => {
        console.log('error', error);
    }).then(() => {
        console.log('terminó');
    });

}

async function updateUser() {

    if (!validateInfoForm()) {
        return;
    }

    if (await sendRequest_updateInfo()) {
        alert('se actualizó correctamente');
        location.reload();
    }
}

async function updatePassword() {
    if (!validatePassForm()) {
        return;
    }

    if (await sendRequest_updatePassword()) {
        location.reload();
    }
}

function validateInfoForm() {

    //limpiamos errores
    nameInput.setCustomValidity('');
    lastNameInput.setCustomValidity('');
    emailInput.setCustomValidity('');
    dateInput.setCustomValidity('');

    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        console.log('validaciones generales no validas')
        formulario.reportValidity();
        return false;
    }

    console.log('primer filtro pasado');

    //Validar nombre
    if (!validateName(nameInput)) {
        nameInput.reportValidity();
        console.log('false en nombre')

        return false;
    }

    //Validar apellido
    if (!validateLastName(lastNameInput)) {
        lastNameInput.reportValidity();
        console.log('false en apellido');

        return false;
    }

    //validar email
    if (!validateEmail(emailInput)) {
        emailInput.reportValidity();
        console.log('false en email')

        return false;
    }

    //validar fecha de nacimiento
    if (!validateDateOfBirth(dateInput)) {
        dateInput.reportValidity();
        console.log('false en date')
        return false;
    }

    return true;
}

function validatePassForm() {
    //limpiamos errores
    newPasswordInput.setCustomValidity('');
    oldPasswordInput.setCustomValidity('');

    //Validaciones generales (type, required)
    if (!formPassword.checkValidity()) {
        console.log('validaciones generales no validas')
        formPassword.reportValidity();
        return false;
    }
    console.log('primer filtro pasado');


    //Validar oldPassword***

    //Validamos nueva contraseña
    if (!validatePassword(newPasswordInput)) {
        newPasswordInput.reportValidity();
        return false;
    }

    return true;
}

function validatePhoto() {
    let file = document.getElementById('avatar-input').files[0];
    sendRequest_updatePhoto(file);
    document.getElementById('avatar-input').value = "";
}


getUser();