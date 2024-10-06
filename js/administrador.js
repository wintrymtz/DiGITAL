const usCombo = document.getElementById('tipo-usuario');
const estTable = document.getElementById('estudiante-tabla');
const insTable = document.getElementById('instructor-tabla');

usCombo.addEventListener('change', function () {
    console.log(this.value);
    // let thead = document.getElementById('thead-table')
    // let columns = document.createElement('tr');

    switch (this.value) {
        case 'Instructor':
            insTable.style.display = 'block';
            estTable.style.display = 'none';
            break;

        case 'Estudiante':
            estTable.style.display = 'block';
            insTable.style.display = 'none';
            break;
    }
})