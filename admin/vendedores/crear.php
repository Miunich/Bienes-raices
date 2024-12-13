<?php
require_once '../../includes/app.php';

use App\Vendedor;

// Establecer conexión a la base de datos
$db = conectarDB();
Vendedor::setDB($db);

// Verificar autenticación
estaAutenticado();

// Inicializar variables
$vendedor = new Vendedor;
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Crear una nueva instancia con los datos del formulario
    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar que no haya campos vacíos
    $errores = $vendedor->validar();

    if (empty($errores)) {
        // Guardar en la base de datos
        $resultado = $vendedor->guardar();

        if ($resultado) {
            // Redirigir al usuario tras guardar
            header('Location: /admin?resultado=6');
            exit;
        }
    }
}

include '../../includes/templates/header.php';
?>
<main class="contenedor seccion">
    <h1>Ingresar Vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- Mostrar errores si los hay -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>

    <!-- Formulario -->
    <form action="/admin/vendedores/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>
        <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
    </form>
</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php include '../../includes/templates/footer.php'; ?>
    </div>
    <p class="copyright">Todos los derechos reservados 2024 &copy;</p>
</footer>
<script src="/build/js/bundle.min.js"></script>
