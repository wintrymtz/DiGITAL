let radioStars = document.getElementsByName('rating1');
console.log(radioStars);
let starsOver = false;
let canVote = true;
let finalRating = 0;

radioStars.forEach((rd) => {
    rd.addEventListener('mouseover', () => {
        if (canVote) {
            starsOver = true;
            checkRating(rd.id);
        }

    })
})


radioStars.forEach((rd) => {
    rd.addEventListener('mouseleave', () => {
        if (canVote) {
            starsOver = false;
            checkRating(rd.id);
        }
    })
})

radioStars.forEach((rd) => {
    rd.addEventListener('click', () => {
        if (canVote) {
            alert('Se ha mandado la calificacion');
            canVote = false;
        }

    })
})

function checkRating(calif) {
    console.log(starsOver);
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
            radioStars[0].style.color = "yellow";
            finalRating = 1;
            break;

        case '2':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            finalRating = 2;
            break;

        case '3':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            finalRating = 3;
            break;

        case '4':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            radioStars[3].style.color = "yellow";
            finalRating = 4;
            break;

        case '5':
            radioStars[0].style.color = "yellow";
            radioStars[1].style.color = "yellow";
            radioStars[2].style.color = "yellow";
            radioStars[3].style.color = "yellow";
            radioStars[4].style.color = "yellow";
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

console.log('over')
