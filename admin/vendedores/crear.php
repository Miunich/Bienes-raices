<?php
require_once '../../includes/app.php';

use App\Vendedor;

estaAutenticado();
$vendedor = new Vendedor;

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // crear una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar que no haya campos vacios
    $errores = $vendedor->validar();

    if (empty($errores)) {
        $resultado = $vendedor->guardar();
    }

}

include '../../includes/templates/header.php';
?>
<main class="contenedor seccion">
    <h1>Ingresar Vendedor</h1>


    <a href="/admin" class="boton boton-verde"> Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>
        <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
    </form>
</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php
        include '../../includes/templates/footer.php';
        ?>
    </div>

    <p class="copyright">Todos los derechos Reservador 2024 &copy;</p>
</footer>
<script src="/build/js/bundle.min.js"></script>