
var format = /[()¡"#$%&\/='?¿:;,.\-_+*\[\]{}]/; //caracteres especiales (Regular expression)

function validatePassword(pInput) {
    let pass = pInput.value;

    //Validar caracteres especiales
    if (format.test(pass) != true) {
        pInput.setCustomValidity(`La contraseña debe contener un caracter especial como: [()¡"#$%&/= ?¿':;,.-_ +*[]{ }]/`);
        return false;
    }

    //Validar 8 caracteres minimo
    if (pass.length < 8) {
        pInput.setCustomValidity('La contraseña debe tener 8 caracteres o más');
        return false;
    }

    //Validar que tenga minimo una mayuscula
    if (!/[A-Z]/.test(pass)) {
        pInput.setCustomValidity('La contraseña debe de tener al menos una mayuscula');
        return false;
    }

    //Validar que tenga un numero entero
    if (!/\d/.test(pass)) {
        pInput.setCustomValidity('La contraseña debe de tener al menos un numero');
        return false;
    }

    pInput.setCustomValidity('');
    return true;
}

function validateName(nameInput) {

    if (nameInput.value.length > 20) {
        nameInput.setCustomValidity('No se permite más de 20 caracteres en el nombre');
        return false;
    }

    //Validar numeros
    if (/\d/.test(nameInput.value)) {
        nameInput.setCustomValidity('No se permiten numeros en el nombre')
        return false;
    }

    return true;
}

function validateLastName(lastnameInput) {
    //Validar longitud
    if (lastnameInput.value.length > 30) {
        lastnameInput.setCustomValidity('No se permite más de 30 caracteres en el apellido');
        return false;
    }

    //Validar numeros
    if (/\d/.test(lastnameInput.value)) {
        lastnameInput.setCustomValidity('No se permiten numeros en el apellido')
        return false;
    }

    return true;
}

function validateEmail(emailInput) {
    if (emailInput.value.length > 320) {
        nameInput.setCustomValidity('No se permite más de 320 caracteres en la dirección');
        return false;
    }
    return true;
}

function validateDateOfBirth(dateInput) {
    let today = new Date();
    let userDate = new Date(dateInput.value);

    if (userDate > today) {
        dateInput.setCustomValidity('La fecha no puede ser del futuro');
        return false;
    }
    return true;
}