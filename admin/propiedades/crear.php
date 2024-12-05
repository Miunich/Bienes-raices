<?php
//Base de datos
// require '../../includes/config/database.php';
require '../../includes/app.php';

use App\Propiedad;
// $propiedad = new propiedad();

// debuguear($propiedad);

$db = conectarDB();
// $auth = estaAutenticado();
estaAutenticado();


// if (!$auth) {
//     header('Location: /');
// }

//Consultar para obtener vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedor_id = '';

//Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $propiedad = new Propiedad($_POST);

    $propiedad->guardar();

    // debuguear($propiedad);
    


    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedor_id = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //Asignar files hacia una variable
    $imagen = $_FILES['imagen'];



    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripción y no debe ser menor a 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "Debes añadir el número de habitaciones";
    }
    if (!$wc) {
        $errores[] = "Debes añadir el número de baños";
    }
    if (!$estacionamiento) {
        $errores[] = "Debes añadir el número de estacionamientos";
    }
    if (!$vendedor_id) {
        $errores[] = "Debes añadir un vendedor";
    }

    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "La imagen es obligatoria";
    }

    //Validar por tamaño (1mb maximo)
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

   

    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        //Subida de archivos


        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        //Subir la imagen

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $imagen['name']);
        $imagen = $imagen['name'];


        

        // echo $query;
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }
}

include '../../includes/templates/header.php';
$queryVendedores = "SELECT vendedor_id, nombre, apellido FROM vendedores";
$resultadoVendedores = mysqli_query($db, $queryVendedores);
?>


<main class="contenedor seccion">
    <h1>Crear</h1>


    <a href="/admin" class="boton boton-verde"> Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset>

            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" value="<?php echo $habitaciones; ?>">
            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej. 2" min="1" max="3" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 2" min="1" max="3" value="<?php echo $estacionamiento; ?>">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor_id" id="vendedor">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultadoVendedores)) : ?>
                    <option value="<?php echo $vendedor['vendedor_id']; ?>" <?php echo $vendedor_id == $vendedor['vendedor_id'] ? 'selected' : ''; ?>>
                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

        </fieldset>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
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
</body>

</html>