<?php
require_once '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

// Validar para que sea un ID válido
$id = $_GET['id'] ?? null;
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
    exit;
}

// Conectar a la base de datos
$db = conectarDB();

// Obtener los datos del vendedor
$consulta = "SELECT * FROM vendedores WHERE vendedor_id = $id";
$resultado = mysqli_query($db, $consulta);
$vendedor = mysqli_fetch_assoc($resultado);

if (!$vendedor) {
    header('Location: /admin');
    exit;
}

// Inicializar errores
$errores = [];

// Variables con los datos actuales del vendedor
$nombre = $vendedor['nombre'] ?? '';
$apellido = $vendedor['apellido'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y asignar los datos enviados por el usuario
    $nombre = mysqli_real_escape_string($db, trim($_POST['nombre'] ?? ''));
    $apellido = mysqli_real_escape_string($db, trim($_POST['apellido'] ?? ''));

    // Validar campos
    if (empty($nombre)) {
        $errores[] = "Debes añadir un nombre";
    }

    if (empty($apellido)) {
        $errores[] = "Debes añadir un apellido";
    }

    // Si no hay errores, actualizar los datos en la base de datos
    if (empty($errores)) {
        $query = "UPDATE vendedores SET nombre = '$nombre', apellido = '$apellido' WHERE vendedor_id = $id";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?resultado=5');
            exit;
        } else {
            $errores[] = "Hubo un error al actualizar el vendedor";
        }
    }
}

include '../../includes/templates/header.php';
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>

    <form action="" class="formulario" method="POST">
        <fieldset>
            <legend>Información General</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del Vendedor" value="<?php echo htmlspecialchars($nombre); ?>">

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" placeholder="Apellido del Vendedor" value="<?php echo htmlspecialchars($apellido); ?>">
        </fieldset>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php include '../../includes/templates/footer.php'; ?>
    </div>
    <p class="copyright">Todos los derechos Reservados 2024 &copy;</p>
</footer>
<script src="/build/js/bundle.min.js"></script>