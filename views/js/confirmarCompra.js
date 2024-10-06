var formulario = document.getElementById('formulario');
var radio = document.getElementsByName('metodo-pago');
var CreditCard = document.getElementById('information_pay_card');
let metodoPago = '';
formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario
})


radio.forEach((e) => {
    e.addEventListener('click', () => {
        // console.log('radio selected', e.value);
        CreditCard.style.display = 'none';
        isSelected = true;
        switch (e.value) {
            case "PayPal":
                break;

            case "creditCard":
                CreditCard.style.display = 'block';
                break;
        }

        metodoPago = e.value;
    })
})

function confirmarCompra() {

    if (!validar()) {
        return;
    }

    alert('Compra realizada con exito');
    window.location.href = 'home.view.php';
}

function validar() {

    if (metodoPago === 'creditCard') {
        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return false;
        }
    }

    if (metodoPago === '') {
        return false;
    }

    return true;
}