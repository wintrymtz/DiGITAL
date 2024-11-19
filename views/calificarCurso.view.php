<?php 
$boostrap = true;  

$css = getFile('/verCurso', 'css');
include('partials/head.php');
include('partials/nav.php');
 ?>
  <!-- Navbar y barra lateral si es necesario -->
  
  <div class="container mt-5">
    <h2>Califica el curso</h2>

    <!-- Sistema de estrellas -->
    <div class="rating-css">
      <!-- <h4>Calificación:</h4> -->
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

    <!-- Campo de comentarios -->
    <div class="mt-4">
      <h4>Comentarios:</h4>
      <form id='form'>
        <div class="mb-3">
          <textarea class="form-control" id="comentario" rows="4" placeholder="Escribe tu comentario aquí..."></textarea>
        </div>
        <button class="btn btn-primary" onclick="send()">Enviar calificación</button>
      </form>
    </div>
  </div>
</body>

<script>
let radioStars = document.getElementsByName('rating1');
console.log(radioStars);
let starsOver = false;
let canVote = true;
let finalRating = 0;

const params = new URLSearchParams(window.location.search);
const idCurso = params.get('id');

document.getElementById('form').addEventListener('submit',(e)=>{
    e.preventDefault();
})

radioStars.forEach((rd) => {
    rd.addEventListener('click', () => {
        console.log('on')
        if (canVote) {
            starsOver = true;
            checkRating(rd.id);
        }

    })
})


// radioStars.forEach((rd) => {
//     rd.addEventListener('mouseleave', () => {
//         if (canVote) {
//             starsOver = false;
//             checkRating(rd.id);
//         }
//     })
// })

// radioStars.forEach((rd) => {
//     rd.addEventListener('click', () => {
//         if (canVote) {
//             alert('Se ha mandado la calificacion');
//             canVote = false;
//         }

//     })
// })

function checkRating(calif) {
    console.log(starsOver);
    const colorSelected = "#7824b9";
    switch (calif) {
        case '0':
            radioStars[0].style.color = "black";
            radioStars[1].style.color = "black";
            radioStars[2].style.color = "black";
            radioStars[3].style.color = "black";
            radioStars[4].style.color = "black";
            finalRating = 0;
            break;
        case '1':
            radioStars[0].style.color = colorSelected;
            radioStars[1].style.color = "black";
            radioStars[2].style.color = "black";
            radioStars[3].style.color = "black";
            radioStars[4].style.color = "black";
            finalRating = 1;
            break;

        case '2':
            radioStars[0].style.color = colorSelected;
            radioStars[1].style.color = colorSelected;
            radioStars[2].style.color = "black";
            radioStars[3].style.color = "black";
            radioStars[4].style.color = "black";
            finalRating = 2;
            break;

        case '3':
            radioStars[0].style.color = colorSelected;
            radioStars[1].style.color = colorSelected;
            radioStars[2].style.color = colorSelected;
            radioStars[3].style.color = "black";
            radioStars[4].style.color = "black";
            finalRating = 3;
            break;

        case '4':
            radioStars[0].style.color = colorSelected;
            radioStars[1].style.color = colorSelected;
            radioStars[2].style.color = colorSelected;
            radioStars[3].style.color = colorSelected;
            radioStars[4].style.color = "black";
            finalRating = 4;
            break;

        case '5':
            radioStars[0].style.color = colorSelected;
            radioStars[1].style.color = colorSelected;
            radioStars[2].style.color = colorSelected;
            radioStars[3].style.color = colorSelected;
            radioStars[4].style.color = colorSelected;
            finalRating = 5;
            break;
    }

    if (!starsOver) {
        radioStars[0].style.color = "black";
        radioStars[1].style.color = "black";
        radioStars[2].style.color = "black";
        radioStars[3].style.color = "black";
        radioStars[4].style.color = "black";
    }
}

function send(){
    let commentInput = document.getElementById('comentario');
    let comment = commentInput.value;

    commentInput.setCustomValidity('');

    if(finalRating === 0 || comment.length < 1){
        commentInput.setCustomValidity('Debe de seleccionar una calificacion y escribir un comentario'); 
        commentInput.reportValidity(); 
    } else{
    console.log('comentario: ',comment)
    console.log('calif: ',finalRating)

    requestComment(comment, finalRating);
    }
}

function requestComment(text, rating){

    let data ={
            comentario: text,
            calificacion: rating,
            idCurso: idCurso
    }
    console.log(data);

    fetch('http://localhost:80/DiGITAL/comments/create',
    {
        method: 'POST',
        body: JSON.stringify(data)
    }).then((response) => {
        return response.json()
    }).then((response) => {
        console.log(response);
        alert('se publicó correctamente su comentario');
        let url = "<?=getProjectRoot('/verCurso')?>";
        window.location.href = url + "?id=" + idCurso;
    });
}

</script>
</html>
