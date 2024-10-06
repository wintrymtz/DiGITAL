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

formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

formPassword.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

function getUser() {
    //llenar los inputs automaticamente con los datos del usuario

    //valores dummy
    nameInput.value = 'Sergio';
    emailInput.value = 'correo@gmail.com';
    lastNameInput.value = 'Castañeda Mata';
    dateInput.value = '2000-02-01';
    formulario.gender[0].checked = true;
}

function updateUser() {

    if (!validateInfoForm()) {
        return;
    }

    console.log('Usuario actualizado');

}

function updatePassword() {
    if (!validatePassForm()) {
        return;
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
        return;
    }
    console.log('Contraseña actualizada');
    alert('Contraseña actualizada');
}

getUser();