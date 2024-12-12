<?php
//Base de datos
// require '../../includes/config/database.php';
require_once '../../includes/app.php';

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

// $titulo = '';
// $precio = '';
// $descripcion = '';
// $habitaciones = '';
// $wc = '';
// $estacionamiento = '';
// $vendedor_id = '';

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

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>
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
