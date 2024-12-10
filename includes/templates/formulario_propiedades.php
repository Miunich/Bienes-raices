<?php

require_once '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\GD\Driver;
$db = conectarDB();


$queryVendedores = "SELECT vendedor_id, nombre, apellido FROM vendedores";
$resultadoVendedores = mysqli_query($db, $queryVendedores);
$propiedad = new Propiedad($_POST);

//Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $vendedor_id = $_POST['vendedor_id'] ?? '';
    
    // $imagen = $_FILES['imagen'];
    // $imagen = $imagen['name'];
    // if($_FILES['imagen']['tmp_name']){
    //     $manager = new Image(Driver::class);
    //     $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
    //     $propiedad->setImagen($imagen);
        
        
    // }


    $errores = $propiedad->validar();
    
   
   

    //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {
        
        //Asignar files hacia una variable
        // $imagen = $_FILES['imagen'];
        $manager = new Image(Driver::class);
        // // $imagen = $manager->read($_FILES['imagen']['tmp_name']);
        
        // //Generar un nombre unico para cada imagen
        // $nombreImagen = uniqid() . ".jpg";
        // //Crear carpeta
        // // $carpetaImagenes = '../../imagenes/';
        // if (!is_dir(CARPETA_IMAGENES)) {
        //     mkdir(CARPETA_IMAGENES);
        // }
        
        // // Asignar el nombre de la imagen al objeto Propiedad
        // $propiedad->setImagen($nombreImagen); // Pasa solo el nombre del archivo
        // // debuguear($propiedad);
        // //Guarda la imagen en el servidor
        
        // $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        // $resultado = $propiedad->guardar();
        // if($resultado){
        //     header('Location: /admin?resultado=1');
        // }
    }
}
?>
<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>

</fieldset>

<fieldset>

    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">
    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="wc" placeholder="Ej. 2" min="1" max="3" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 2" min="1" max="3" value="<?php echo s($propiedad->estacionamiento); ?>">

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