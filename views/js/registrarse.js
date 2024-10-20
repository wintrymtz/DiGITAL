var formulario = document.getElementById('formulario');

formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

// class user {
//     constructor(name, lastName, email, password) {
//         this.name = name;
//         this.lastName = lastName;
//         this.email = email;
//         this.password = password;
//     }
// }

async function validate() {

    //se obtienen los inputs
    let nameInput = document.getElementById('name');
    let lastnameInput = document.getElementById('lastname');
    let emailInput = document.getElementById('email');

    let password1Input = document.getElementById('password1');
    let password2Input = document.getElementById('password2');

    let userType = document.querySelector('input[name="userType"]:checked').value;


    //Limpiamos validaciones
    // ** cuando se crea una customValidity, la validacion se almacena, de esta forma las validaciones generales no funcionarán debido a que ya tiene una validacion almacenada por lo que hay que limpiarla
    nameInput.setCustomValidity('');
    lastnameInput.setCustomValidity('');
    emailInput.setCustomValidity('');

    password1Input.setCustomValidity('');
    password2Input.setCustomValidity('');


    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        console.log('validaciones iniciales no validas')
        formulario.reportValidity();
        return;
    }

    console.log('primer filtro pasado');

    //Validar nombre
    if (!validateName(nameInput)) {
        nameInput.reportValidity();
        nameInput.style.borderColor = "red"
        return;
    }

    //Validar apellidos
    if (!validateLastName(lastnameInput)) {
        lastnameInput.reportValidity();
        lastnameInput.style.borderColor = "red"
        return;
    }

    //Validar email
    if (!validateEmail(emailInput)) {
        emailInput.reportValidity();
        return;
    }

    // Validar contraseña
    if (!validatePassword(password1Input)) {
        password1Input.reportValidity();
        password1Input.style.borderColor = "red"
        return;
    }

    if (password1Input.value !== password2Input.value) {
        password2Input.setCustomValidity('Las contraseñas no son iguales');
        password2Input.reportValidity();
        password2Input.style.borderColor = "red"
        return;
    }



    //se almacena el valor de cada input
    let name = nameInput.value;
    let lastName = lastnameInput.value;
    let email = emailInput.value;
    let password1 = password1Input.value;
    // let password2 = password2Input.value;

    if (await sendRequest(name, lastName, email, password1, userType)) {
        console.log("Registro correcto");
        window.location.href = './iniciarSesion';
    }
}

async function sendRequest(name, lastName, email, password, userType) {
    let formBody = {
        name: name,
        lastName: lastName,
        email: email,
        password: password,
        role: userType
    };

    let requestState = false;

    await fetch('http://localhost:80/DiGITAL/registrarse/store', {
        method: 'POST',
        body: JSON.stringify(formBody)
    }).then((response) => {

        if (!response.ok) {
            throw response;
        } else {
            requestState = true;
        }
        return response.json()
    }).then((response) => {
        alert(response['msg']);
    }).catch(async (error) => {
        const errorResponse = await error.json();
        if (errorResponse['errorCode'] == '23000') {
            alert('ERROR. Usuario ya existente');
        }
        console.log(errorResponse['msg']);
    }).then(() => {
        console.log('terminó');
    });

    console.log(requestState);
    return requestState;
}