<?php
// session_start();

require '../../includes/funciones.php';
$auth = estaAutenticado();


if(!$auth){
    header('Location: /');
}

//Validar la URL por ID valido
$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

//Base de datos
require '../../includes/config/database.php';

$db = conectarDB();

//Obtener los datos de la propiedad
$consulta =  "SELECT * FROM propiedades WHERE id = $id";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_array($resultado);




//Consultar para obtener vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedor_id = $propiedad['vendedor_id'];
$imagenPropiedad = $propiedad['imagen'];

//Ejecutar el codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
  

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedor_id = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //Asignar files hacia una variable
    // $imagen = $_FILES['imagen'];
    $imagen = is_array($_FILES['imagen']) ? $_FILES['imagen']['name'] : ''; // Procesar archivo




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

    

    //Validar por tamaño (1mb maximo)
    $medida = 1000 * 1000;

    // if($imagen['size'] > $medida){
    //     $errores[] = "La imagen es muy pesada";
    // }
    $imagenNombre = $_FILES['imagen']['name'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen']; // Asignar el array completo del archivo subido
    
        // Verificar el tamaño del archivo
        if ($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }
    
        // Procesar la subida de la imagen (opcional)
        $rutaDestino = '../../imagenes/' . $imagen['name'];
        if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
            $errores[] = "Error al guardar la imagen en el servidor";
        }
    } 
    
    
    // Imprimir errores (si existen)
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
    } else {
        echo "Imagen procesada correctamente";
    }


    //Revisar que el arreglo de errores este vacio
    if(empty($errores)){
        // //Subida de archivos
        
        if($imagenNombre){
            
            //Eliminar la imagen previa
            unlink('../../imagenes/' . $propiedad['imagen']);            
        } 
        else {
                $imagenNombre = $propiedad['imagen'];

        } 

        
        //Insertar en la base de datos
        $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$imagenNombre', descripcion = '$descripcion', habitaciones = '$habitaciones', wc = '$wc', estacionamiento = '$estacionamiento', vendedor_id = '$vendedor_id' WHERE id = $id";
        
        
        // echo $query;
        $resultado = mysqli_query($db, $query);
    
        if($resultado){
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }

    }   


}

include '../../includes/templates/header.php';
?>


<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>


    <a href="/admin" class="boton boton-verde"> Volver</a>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <form action="" class="formulario" method="POST"  enctype="multipart/form-data" >

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad"value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <img src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="" class="imagen-small">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset>

            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej. 3" min="1" max="9"value="<?php echo $habitaciones; ?>">
            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej. 2" min="1" max="3" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej. 2" min="1" max="3" value="<?php echo $estacionamiento; ?>">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="vendedor" value="<?php echo $vendedor_id; ?>">
                <option value="">-- Seleccione --</option>
                <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedor_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>                
            </select>

        </fieldset>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
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