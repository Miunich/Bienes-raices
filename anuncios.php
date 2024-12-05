<?php
include 'includes/templates/header.php';
require 'includes/app.php';
?>

<main class="contenedor seccion">
    <section class="section contenedor">
        <h2>Casas y Depas en Venta</h2>

        <?php

             $limite = 9;  
             include 'includes/templates/anuncios.php';
        ?>

</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php
        include 'includes/templates/footer.php';
        ?>
    </div>

    <p class="copyright">Todos los derechos Reservados 2024 &copy;</p>
</footer>
<script src="build/js/bundle.min.js"></script>
</body>

</html>