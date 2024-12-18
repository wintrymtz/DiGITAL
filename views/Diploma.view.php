<?php 
include('partials/head.php');
include('partials/nav.php');
?>

<style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #eaeaea;
        }

        .main-container{
            padding: 60px;
        }

        .diploma-container {
            border: 10px solid #4a4a4a;
            border-radius: 20px;
            background-color: #fff;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            text-align: center;
        }
        h1 {
            font-size: 48px;
            color: #2c3e50;
            margin: 0;
            font-weight: 600;
        }
        h2 {
            font-size: 24px;
            color: #7f8c8d;
            margin: 10px 0;
            font-style: italic;
        }
        .recipient-name {
            font-family: 'Brush Script MT', cursive;
            font-size: 42px;
            color: #c0392b;
            margin: 30px 0;
            text-transform: uppercase;
        }
        .course-title {
            font-size: 22px;
            font-weight: 500;
            color: #34495e;
            margin: 20px 0;
            border-top: 2px solid #34495e;
            border-bottom: 2px solid #34495e;
            padding: 10px 0;
        }
        .date {
            font-size: 18px;
            color: #7f8c8d;
            margin: 20px 0;
        }
        .image-container {
            margin: 20px 0;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            padding: 0 60px;
        }
        .signature {
            text-align: center;
            color: #34495e;
        }
        .signature img {
            width: 140px;
            height: auto;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #95a5a6;
        }
        /* Estilos para los listones decorativos */
        .ribbon {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            height: 40px;
            background-color: #ffca28;
            color: #fff;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            transform: rotate(-10deg);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .ribbon::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: #ffca28 transparent transparent transparent;
        }
    </style>

<div class='main-container'>
    <div class="diploma-container">
        
        <h1>Certificado de Finalización</h1>
        <h2>Otorgado por el Portal de Cursos Online</h2>
        
        <p>Se otorga a</p>
        <p class="recipient-name"><?= $nombreUsuario.' '.$apeliidoUsuario?></p>
        <p>por haber completado satisfactoriamente el curso</p>
        <p class="course-title"><?= $nombreCurso ?></p>
        <p>Emitido el:</p>
        <p id='date' class="date"></p>

        
        <div class="image-container">
            <img src="https://png.pngtree.com/png-vector/20221119/ourmid/pngtree-medal-design-with-golden-ribbon-png-image_6470028.png" alt="Imagen decorativa" style="width: 300px; height: auto;">
        </div>
        
        <div class="signature-section">
            <div class="signature">
                <!-- <img src="firma.png" alt="Firma"> -->
                <p><?= $nombreInstructor ?></p>
                <p>Instructor del Curso</p>
            </div>
            <div class="signature">
                <p>_________________________</p>
                <p>DiGITAL</p>
                <p>Director del Programa</p>
            </div>
        </div>
        
        <div class="footer">
            <p>Certificado emitido por DiGITAL | /DiGITAL/</p>
        </div>
    </div>
    </div>
</body>
<script src="<?=getFile('/validUs', 'js')?>"></script>
<script> 
    let fecha ="<?= $fechaTerminado?>";
    fecha = timeStampToDate(fecha);
    document.getElementById('date').textContent += ' '+fecha;
</script>
</html>
