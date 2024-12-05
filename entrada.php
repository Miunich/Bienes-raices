<?php
include 'includes/templates/header.php';
?>


<main class="contenedor seccion contenido-centrado">
    <h1>Guía para la decoracion de tu hogar</h1>
    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
    </picture>
    <p class="informacion-meta">Escrito el :<span>8/11/2024 </span> por: <span>Admin</span></p>

    <div class="resumen-propiedad">

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem laudantium architecto distinctio,
            reprehenderit neque molestias excepturi iure sit voluptatem. Numquam excepturi ratione iure et obcaecati
            illo natus laborum facilis animi!</p>

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