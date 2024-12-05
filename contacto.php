<?php
include 'includes/templates/header.php';
require 'includes/app.php';
?>


<main class="contenedor seccion">
    <h1>Contacto</h1>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jgep">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>
    <h2>Llene el formulario de Contacto</h2>

    <form action="" class="formulario">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" placeholder="Tu Nombre">

            <label for="correo">Correo:</label>
            <input type="email" id="correo" placeholder="Tu Correo">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" placeholder="Tu Teléfono">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <label for="opciones"> Vende o Compra</label>
            <select name="" id="opciones">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto">
        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <p>¿Cómo desea ser contactado?</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" name="contacto" id="contactar-telefono" value="telefono">

                <label for="contactar-email">E-mail</label>
                <input type="radio" name="contacto" id="contactar-email" value="email">
            </div>
            <p> Si eligió teléfono, elija la fecha y la hora para ser contactado</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00">
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
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