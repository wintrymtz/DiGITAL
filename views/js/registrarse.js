var formulario = document.getElementById('formulario');

formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

class user {
    constructor(name, lastName, email, password) {
        this.name = name;
        this.lastName = lastName;
        this.email = email;
        this.password = password;
    }
}

function validate() {

    //se obtienen los inputs
    let nameInput = document.getElementById('name');
    let emailInput = document.getElementById('email');
    let password1Input = document.getElementById('password1');
    let password2Input = document.getElementById('password2');

    //Limpiamos validaciones
    // ** cuando se crea una customValidity, la validacion se almacena, de esta forma las validaciones generales no funcionarán debido a que ya tiene una validacion almacenada por lo que hay que limpiarla
    password1Input.setCustomValidity('');
    password2Input.setCustomValidity('');


    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        console.log('validaciones iniciales no validas')
        formulario.reportValidity();
        return;
    }

    console.log('primer filtro pasado');

    //Validar contraseña
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

    //Validar email
    if (!validateEmail(emailInput)) {
        emailInput.reportValidity();
        return;
    }

    //se almacena el valor de cada input
    let name = nameInput.value;
    let email = emailInput.value;
    let password1 = password1Input.value;
    let password2 = password2Input.value;
    let lastName;

    console.log("Registro correcto");
    let newUsers = new user(name, lastName, email, password1);
    window.location.replace("./iniciarSesion");
}