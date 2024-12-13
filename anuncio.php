<?php

require 'includes/app.php';

use App\Propiedad;

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (empty($id)) {
    header('Location: /');
    exit;
}

$propiedad = Propiedad::find($id);


// require 'includes/funciones.php';
include 'includes/templates/header.php';
?>


<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo; ?></h1>
    
    <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $propiedad->precio; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad->wc; ?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad->estacionamiento; ?></p>
            </li>
            <li>
                <img loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>
        <p><?php echo htmlspecialchars($propiedad->descripcion); ?></p>
    </div>
</main>


<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php
        include 'includes/templates/footer.php';
        ?>
    </div>

    <p class="copyright">Todos los derechos Reservador 2024 &copy;</p>
</footer>
<script src="build/js/bundle.min.js"></script>
</body>

</html>

