<?php


require '../includes/funciones.php';
$auth = estaAutenticado();


if(!$auth){
    header('Location: /');
}

//importar la conexion
require '../includes/config/database.php';
$db = conectarDB();

//Escribir el query
$query = "SELECT * FROM propiedades";

//Consultar la base de datos
$resultadoConsulta = mysqli_query($db, $query);

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;



//incluye un template

include '../includes/templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
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
    <?php endif ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde"> Nueva Propiedad</a>

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
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo $propiedad['id']; ?></td>
                    <td><?php echo $propiedad['titulo']; ?></td>
                    <td> <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="" class="imagen-tabla"></td>
                    <td>$ <?php echo $propiedad['precio']; ?></td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?= $propiedad['id']; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
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