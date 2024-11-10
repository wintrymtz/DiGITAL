var formulario = document.getElementById('formulario');
var radio = document.getElementsByName('metodo-pago');
var CreditCard = document.getElementById('information_pay_card');
let metodoPago = '';
let totalCost = 0;
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

    sendRequestBuy(CursoId, totalCost, metodoPago, nivelesId, tipoCompra, nivelesCostos);
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
