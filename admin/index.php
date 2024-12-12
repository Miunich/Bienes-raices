<?php


require '../includes/app.php';
require '../classes/vendedor.php';
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

// Configurar conexión a la base de datos
$db = conectarDB();

// Pasar la conexión a la clase vendedor
vendedor::setDB($db);

//Implementar un método para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();


$resultado = $_GET['resultado'] ?? null;



//incluye un template

include '../includes/templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['id'] ?? null;

    if ($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {

            $tipo = $_POST['tipo'];

            if (validarTipoContenido($tipo)) {
                //compara lo que vamos a eliminar
                if ($tipo === 'vendedor') {
                    // Obtener el vendedor antes de eliminar
                    // $querySelect = "SELECT imagen FROM vendedores WHERE vendedor_id = $id";
                    // No intentamos obtener 'imagen' porque no existe en la tabla vendedores
                    $queryDelete = "DELETE FROM vendedores WHERE vendedor_id = $id";
                    $resultadoConsulta = mysqli_query($db, $queryDelete);

                    if ($resultadoConsulta) {
                        header('Location: /admin?resultado=4');
                    } else {
                        echo "Error al eliminar vendedor " . mysqli_error($db);
                    }
                    // Actualizar el vendedor
                    $queryUpdate = "UPDATE vendedores  WHERE vendedor_id = $id";
                    $resultadoConsultaUpdate = mysqli_query($db, $queryUpdate);
                    if ($resultadoConsultaUpdate) {
                        header('Location: /admin?resultado=5');
                    } else {
                        echo "Error al actualizar vendedor " . mysqli_error($db);
                    }

                } else if ($tipo === 'propiedad') {

                    // Obtener la propiedad antes de eliminar
                    $querySelect = "SELECT imagen FROM propiedades WHERE id = $id";
                    $resultadoSelect = mysqli_query($db, $querySelect);

                    if ($resultadoSelect && $propiedad = mysqli_fetch_assoc($resultadoSelect)) {
                        $imagen = $propiedad['imagen'];
                        if ($imagen && file_exists("../imagenes/" . $imagen)) {
                            unlink("../imagenes/" . $imagen);
                        }

                        // Eliminar la propiedad
                        $queryDelete = "DELETE FROM propiedades WHERE id = $id";
                        $resultadoConsulta = mysqli_query($db, $queryDelete);

                        if ($resultadoConsulta) {
                            header('Location: /admin?resultado=3');
                        } else {
                            echo "Error al eliminar la propiedad: " . mysqli_error($db);
                        }
                    } else {
                        echo "No se encontró la propiedad.";
                    }
                }
            }
        } else {
            echo "ID no válido.";
        }
    } else {
        echo "No se recibió el ID.";
    }
}

$query = "SELECT * FROM propiedades";
$resultadoConsulta = mysqli_query($db, $query);

if (!$resultadoConsulta) {
    die("Error al realizar la consulta: " . mysqli_error($db));
}


?>


<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php if ($resultado == '1'): ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif ($resultado == '2'): ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php elseif ($resultado == '3'): ?>
        <p class="alerta error">Anuncio Borrado correctamente</p>
    <?php elseif ($resultado == '4'): ?>
        <p class="alerta error">Vendedor Borrado correctamente</p>
    <?php elseif ($resultado == '5'): ?>
        <p class="alerta error">Vendedor Actualizado correctamente</p>
    <?php endif ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde"> Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo"> Nuevo(a) vendedor</a>

    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody><!--Mostrar los resultados-->
            <!-- recorrer los resultados -->
            <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-tabla"></td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?= $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody><!--Mostrar los resultados-->
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->vendedor_id; ?></td>
                    <!-- quiero mostrar el nombre y apellido del vendedor de una sola vez
                      -->
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    
                    <td> <!-- Acciones -->
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?= $vendedor->vendedor_id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="vendedores/actualizar.php?id=<?php echo $vendedor->vendedor_id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php
        include '../includes/templates/footer.php';
        ?>
    </div>

    <p class="copyright">Todos los derechos Reservador 2024 &copy;</p>
</footer>
<script src="/build/js/bundle.min.js"></script>
<?php
//Cerrar la conexion
mysqli_close($db);
?>