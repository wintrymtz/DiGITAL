<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$heading?></title>
    <link rel="shortcut icon" href="views/img/icono por mientras.png" type="image/x-icon">
    <!--navbar links-->
    <link rel="stylesheet" href="views/css/navbar.css">
    <?php  if(isset($css)) : ?> <link rel="stylesheet" href="<?= $css; ?>">  <?php endif; ?>
    <?php  if(isset($boostrap)) : ?><!--Boostrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">  <?php endif; ?>

    <link rel="stylesheet" href="views/css/navbar.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">

    

    
</head>
