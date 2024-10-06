<!DOCTYPE html>
<html lang="es">

<head>
    <title>Subir Curso</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/uploadCourse.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
<?php include('partials/nav.php') ?>

    <div class="main-container">
        <form id="formulario" class="upload-course-form">
            <div class="left-side">
                <div class="title">
                    <h4 class="main-title">Confirmar compra:</h4>
                </div>
                <br>
                <label id="metodo" for="n"> Método de pago:</label>
                <div class="pay_method_item">
                    <input type="radio" id="Paypal" name="metodo-pago" value="Paypal" required>Paypal
                </div>
                <div class="pay_method_item">
                    <input type="radio" id="creditCard" name="metodo-pago" value="creditCard" required>Tarjeta de
                    crédito
                </div>
                <!-- <input type="radio" id="oxxo" name="metodo-pago" value="oxxo">OXXO</radio> -->

                <div id="information_pay_card">
                    <div class="title">
                        <input class="input-title" type="text" placeholder="Nombre" style="width: 250px;  height: 25px;"
                            required>
                        <input class="input-title" type="text" placeholder="CURP" style="width: 250px; height: 25px;"
                            required>
                        <input class="input-title" type="text" placeholder="Numero de la tarjeta"
                            style="width: 580px;  height: 25px;" required>
                        <input class="input-title" type="text" placeholder="CVV/CVC"
                            style="width: 150px;  height: 25px;" required>
                        <label>Fecha de vencimiento</label>
                        <input class="input-title" type="text" style="width: 150px;  height: 25px;" placeholder="MM/YY"
                            required>
                    </div>
                </div>
            </div>
            <div class="right-side">
                <div class="right-side-up">
                    <label style="font-size: 20px; font-weight: bold;"> Costo Total:</label>
                    <label style="font-size: 20px; font-weight: bold;">$450.20</label>
                    <br>
                    <hr>
                    <label>Detalles:</label>
                    <br>
                    <br>
                    <br>
                    <div class="item">
                        <img src="img/FrontEnd.jpg" width="100  ">
                        <br>
                        <label style="margin-right: 30px;">Frontend para principiantes
                        </label>
                        <label>$250.20</label>
                        <br>
                        <br>
                        <br>
                    </div>
                    <input style="width: 250px;" type="submit" value="Confirmar compra" onclick="confirmarCompra()">
                </div>

            </div>
        </form>
    </div>
</body>

<style>
    #metodo {
        font-weight: bold;
        padding-left: 25px;
        margin-top: 100px;
    }

    .pay_method_item {
        border: solid gray 2px;
        width: 50%;
        margin-top: 20px;
        padding: 10px;
        margin-left: 25px;
        margin-bottom: 30px;
    }

    .title {
        margin-bottom: 20px;
    }

    #information_pay_card {
        display: none;
    }
</style>
<script src="js/confirmarCompra.js"></script>

</html>