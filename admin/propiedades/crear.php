<?php
//Base de datos
// require '../../includes/config/database.php';
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\GD\Driver;

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
$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedor_id = '';

//Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $propiedad = new Propiedad($_POST);
    $imagen = $_FILES['imagen'];
    $imagen = $imagen['name'];
    if($_FILES['imagen']['tmp_name']){
        $manager = new Image(Driver::class);
        $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
        $propiedad->setImagen($imagen);
        
        
    }


    $errores = $propiedad->validar();
    
   
   

    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        
        //Asignar files hacia una variable
        // $imagen = $_FILES['imagen'];
        $manager = new Image(Driver::class);
        $imagen = $manager->read($_FILES['imagen']['tmp_name']);
        
        //Generar un nombre unico para cada imagen
        $nombreImagen = uniqid() . ".jpg";
        //Crear carpeta
        // $carpetaImagenes = '../../imagenes/';
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }
        
        // Asignar el nombre de la imagen al objeto Propiedad
        $propiedad->setImagen($nombreImagen); // Pasa solo el nombre del archivo
        // debuguear($propiedad);
        //Guarda la imagen en el servidor
        
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        $resultado = $propiedad->guardar();
        if($resultado){
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