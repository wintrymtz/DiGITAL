let comments = document.getElementsByName('comentario');

comments.forEach(function (c) {
    c.addEventListener('click', function () {
        prompt('Razón por la que se elimina:')
    });
});

function eliminarCurso() {
    if (confirm('Está a punto de eliminar un curso, no se podrá deshacer la acción ¿Está seguro?')) {
        //dar de baja
    }
}

function buyCourse() {
    window.location.href = 'confirmarCompra.view.php';
}