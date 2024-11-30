<?php 
$css = getFile('/DIPLOMA 6', 'css');
include('partials/head.php');
include('partials/nav.php');
?>


<div class ='main'>
    <div class="diploma-container">
        <div class="diploma-border">
            <div class="diploma-header">
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Certificado de Finalización</h1>
                <p class="sub-header">Este certificado se otorga con orgullo a:</p>
            </div>
            <div class="diploma-body">
                <h2 class="student-name"><?= $nombreUsuario.' '.$apeliidoUsuario?></h2>
                <p>Por haber completado satisfactoriamente el curso:</p>
                <h3 class="course-name"><?= $nombreCurso ?></h3>
                <p class="completion-date" id="date">Fecha de terminación: </p>
            </div>
            <div class="diploma-footer">
                <div class="instructor-signature">
                    <p style='text-decoration: underline;'><?= $nombreInstructor ?></p>
                    <p>Nombre del Instructor</p>
                </div>
            </div>
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
