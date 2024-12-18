<?php 
$boostrap = true;  

$css = getFile('/verCurso', 'css');
include('partials/head.php');
include('partials/nav.php');
 ?>
<!--
  Este archivo HTML representa la estructura de la ventana de vista del curso para estudiantes.
  Se utiliza el framework de CSS Bootstrap 5 para el diseño y la responsividad.
-->

  <!-- Contenedor principal -->
  <div class="container-fluid">
    <div class="row">
      <!-- Barra lateral con el contenido del curso -->
      <div class="col-md-3 bg-light sidebar">
        <div class="list-group">
          <!-- Título del curso -->
          <h4 id="course-name" class="mt-4 mb-3 text-center">Frontend para principiantes</h4>
          <!-- Lista de módulos o secciones -->
          <div id="levels-container">
            <!-- <a href="#" class="list-group-item list-group-item-action">Nivel 1: Conceptos Básicos</a>
            <a href="#" class="list-group-item list-group-item-action">Nivel 2: Aplicaciones</a>
            <a href="#" class="list-group-item list-group-item-action">Nivel 3: Avanzado</a>
            <a href="#" class="list-group-item list-group-item-action">Conclusión</a> -->
          </div>
        </div>
      </div>

      <!-- Área de contenido principal -->
      <div class="col-md-9 main-content">
        <!-- Contenedor del video -->
        <div class="embed-responsive embed-responsive-16by9 mt-4">
          <video  id="MyVideo" class="embed-responsive-item" controls>
          <source id="videoSource" src="" type="video/mp4">
            Error al cargar video
          </video>
          <!-- <iframe id="video" class="embed-responsive-item" src=""
            allowfullscreen></iframe> -->
        </div>
        <!-- Descripción y materiales adicionales -->
        <div class="mt-4">
          <label>Instructor:</label><a id="instructor-name">Isaac Nehemías Mata Dominguez</a>

          <h2 id='level-name'>Principios Básicos</h2>
          <!-- <p> -->
            <!-- Descripción de la lección -->
            <!-- En este nivel se se enseñará como funciona de manera básica la programación web.
          </p> -->
          <!-- Materiales de descarga -->
          <h5>Materiales Adicionales:</h5>
          <ul id='materiales'>
            <!-- <li><a href="#">documentacion.pdf</a></li>
            <li><a href="#">ejercicios.txt</a></li>
            <li><a href="#">ejemplo.txt</a></li> -->
          </ul>
        </div>

                <!-- Botón para calificar -->
        <div id='calif-button' class="mt-4">
          <a id="urlCalif" class="btn btn-primary">Calificar curso</a>
        </div>

        <div class="rating-css" style="display:none" >
          <h4>Calificar curso</h4>
          <div class="star-icon">
            <input class="radio-star" type="radio">
            <label for="rating1" class="star" name="rating1" id="1">★</label>
            <input class="radio-star" type="radio">
            <label for="rating2" class="star" name="rating1" id="2">★</label>
            <input class="radio-star" type="radio">
            <label for="rating3" class="star" name="rating1" id="3">★</label>
            <input class="radio-star" type="radio">
            <label for="rating4" class="star" name="rating1" id="4">★</label>
            <input class="radio-star" type="radio">
            <label for="rating5" class="star" name="rating1" id="5">★</label>
          </div>
        </div>
        <div class="mt-5" style="display:none">
          <h4>Comentarios</h4>
          <!-- Formulario para agregar un nuevo comentario -->
          <form>
            <div class="mb-3">
              <label for="comentario" class="form-label">Agregar un comentario:</label>
              <textarea class="form-control" id="comentario" rows="3"
                placeholder="Escribe tu comentario aquí..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
          <!-- Lista de comentarios existentes -->
          <div class="mt-4">
            <div class="card mb-3">
              <div class="card-body">
                <h6 class="card-title">Usuario 1</h6>
                <p class="card-text">Este video fue muy informativo, gracias.</p>
                <p class="card-text"><small class="text-muted">Hace 2 horas</small></p>
              </div>
            </div>
            <div class="card mb-3">
              <div class="card-body">
                <h6 class="card-title">Usuario 2</h6>
                <p class="card-text">Tengo una duda sobre el tema explicado en el minuto 5.</p>
                <p class="card-text"><small class="text-muted">Hace 1 día</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Enlaces a los scripts de Bootstrap 5 -->
   <script>
    const urlChat = "<?=getProjectRoot('/chat')?>";
    const globalURL= "<?=getProjectRoot(null)?>"
   </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?=getFile('/verCurso', 'js')?>"></script>
</body>

</html>