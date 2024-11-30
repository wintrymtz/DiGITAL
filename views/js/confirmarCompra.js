var formulario = document.getElementById('formulario');
//var radio = document.getElementsByName('metodo-pago');
//var CreditCard = document.getElementById('information_pay_card');
let metodoPago = '';
let totalCost = 0;
formulario.addEventListener('submit', function (event) {
    event.preventDefault(); // Previene el envío automático del formulario
})


// radio.forEach((e) => {
//     e.addEventListener('click', () => {
//         // console.log('radio selected', e.value);
//         CreditCard.style.display = 'none';
//         isSelected = true;
//         switch (e.value) {
//             case "PayPal":
//                 break;

//             case "creditCard":
//                 CreditCard.style.display = 'block';
//                 break;
//         }

//         metodoPago = e.value;
//     })
// })

console.log("No se ha seleccionado metodo de pago");
console.log(metodoPago);

// Configurar botón de PayPal
function configurarBotonPayPal() {
    paypal.Buttons({

        fundingSource: paypal.FUNDING.PAYPAL, // Para el botón de PayPal
        createOrder: (data, actions) => {

            metodoPago = "Paypal";
            console.log(metodoPago);

            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalCost.toFixed(2)
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(function (details) {
                alert('Pago con PayPal exitoso.');
                confirmarCompra();
            });
        },
        onError: (err) => {
            console.error('Error con PayPal:', err);
            alert('Ocurrió un problema con PayPal.');
        }
    }).render('#paypal-button-container');

    // Configurar el botón para tarjeta de crédito
    paypal.Buttons({

        fundingSource: paypal.FUNDING.CARD, // Para el botón de tarjeta de crédito
        createOrder: (data, actions) => {

            metodoPago = "creditCard";
            console.log(metodoPago);

            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalCost.toFixed(2) // Costo total
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(function (details) {
                alert('Pago con tarjeta exitoso.');
                confirmarCompra();
            });
        },
        onError: (err) => {
            console.error('Error con tarjeta de crédito:', err);
            alert('Ocurrió un problema con la tarjeta.');
        }
    }).render('#paypal-button-container');
}

function confirmarCompra() {

    if (!validar()) {
        return;
    }

    sendRequestBuy(CursoId, totalCost, metodoPago, nivelesId, tipoCompra, nivelesCostos);
}

function validar() {

    // if (metodoPago === 'creditCard') {
    //     if (!formulario.checkValidity()) {
    //         formulario.reportValidity();
    //         return false;
    //     }
    // }

    if (metodoPago === '') {
        return false;
    }

    return true;
}

function sendRequestBuy(_idCurso, _pago, _metodoPago, _nivelesId, _buyType, _nivelesCostos) {

    data = {
        idCurso: _idCurso,
        pago: _pago,
        metodoPago: _metodoPago,
        nivelesId: _nivelesId,
        buyType: _buyType,
        nivelesCostos: _nivelesCostos
    }

    fetch('http://localhost:80/DiGITAL/courses/buyCourse', {
        method: 'POST',
        body: JSON.stringify(data)
    }).then(response => {
        if (!response.ok) {
            throw response.json();
        }
        return response.json();
    }).then(response => {
        console.log(response);
        alert(response['msg']);
        window.location.href = url + '/kardex';
    }).catch(response => {
        alert('error');
    })

}

const params = new URLSearchParams(window.location.search);

const CursoId = params.get('id');
const nombre = params.get('nombre');
const costo = params.get('costo');
const nivelesNombres = params.get('nivelesNombres')?.split(',').map(String) || [];
const nivelesId = params.get('nivelesId')?.split(',').map(Number) || [];
const nivelesCostos = params.get('nivelesCostos')?.split(',').map(Number) || [];

console.log(nombre);
console.log(costo);
console.log(nivelesNombres);
console.log(nivelesId);
console.log(nivelesCostos);
let tipoCompra = 0;

if (nivelesNombres.length > 0) {
    tipoCompra = 2;

    for (let i = 0; i < nivelesId.length; i++) {
        totalCost += nivelesCostos[i];

        let container = document.getElementById('item-container');
        let item = document.createElement('div');
        item.classList.add('item');
        item.innerHTML = `
                            <br>
                            <label id='product-name' style="margin-right: 30px;">${nivelesNombres[i]}
                            </label>
                            <label id='product-cost' style="font-weight: bold;">$${nivelesCostos[i]}</label>
                            <br>
                            <br>
                            <br>`;
        container.appendChild(item);
    }
} else {
    tipoCompra = 1;

    totalCost = costo;
    let container = document.getElementById('item-container');
    let item = document.createElement('div');
    item.classList.add('item');
    item.innerHTML = `
                        <br>
                        <label id='product-name' style="margin-right: 30px;">${nombre}
                        </label>
                        <label id='product-cost'style="font-weight: 600;">$${costo}</label>
                        <br>
                        <br>
                        <br>`;
    container.appendChild(item);
}


// Mostrar costo total en la vista
totalCost = parseFloat(totalCost);
document.getElementById('costo-total').innerText = `$${totalCost.toFixed(2)}`;

// Configurar el botón PayPal al cargar
configurarBotonPayPal();



