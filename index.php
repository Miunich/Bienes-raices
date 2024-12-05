<?php

    require 'includes/app.php';

    
    incluirTemplate('header',$inicio = true);
?>

    <main class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores sed adipisci, iusto possimus eaque
                    maxime modi maiores minima aliquid earum in quo voluptatibus nostrum. Tempore omnis repellat fugit.
                    Impedit, nam!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores sed adipisci, iusto possimus eaque
                    maxime modi maiores minima aliquid earum in quo voluptatibus nostrum. Tempore omnis repellat fugit.
                    Impedit, nam!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores sed adipisci, iusto possimus eaque
                    maxime modi maiores minima aliquid earum in quo voluptatibus nostrum. Tempore omnis repellat fugit.
                    Impedit, nam!</p>
            </div>
        </div>
    </main>

    <section class="section contenedor">
        <h2>Casas y Depas en Venta</h2>
        <?php

            $limite = 3;
             include'includes/templates/anuncios.php';
        ?>
        
        <div class="alinear-derecha">
            <a href="anuncios.html" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>
        <a href="contacto.html" class="boton-amarillo">Contactános</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpg">
                        <img loading="lazy" src="build/img/blog1.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>Terraza en el techo de tu Casa</h4>
                        <p class="informacion-meta">Escrito el: <span>7/11/2024</span> Por <span>Admin</span></p>

                        <p>
                            Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando
                            dinero
                        </p>
                    </a>
                </div>
            </article>
            
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpg">
                        <img loading="lazy" src="build/img/blog2.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>Guía para la decoración de hogar</h4>
                        <p class="informacion-meta">Escrito el: <span>7/11/2024</span> Por <span>Admin</span></p>

                        <p>
                            Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores para darle vida a tu espacio
                        </p>
                    </a>
                </div>
            </article>
        </section>
        <section class="testimoniales">
            <h3>Testimoniales</h3>

            <div class="testimonial">
                <blockquote>
                    El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas.
                </blockquote>
                <p> - Sergio Espinoza </p>
            </div>
        </section>
    </div>

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