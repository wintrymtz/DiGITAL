let formulario = document.getElementById('sesionForm');


formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario debido a que no redirige por el submit
})

function iniciarSesion() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (validar(email, password)) {
        console.log('hola');
        window.location.replace("./");
    }
}

function validar(email, pass) {

    //Validaciones generales (type, required)
    if (!formulario.checkValidity()) {
        formulario.reportValidity();
        return false;
    }

    return true;
}