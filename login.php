<?php

// require 'includes/config/database.php';
require 'includes/app.php';
$db = conectarDB();
//Autenticar el usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo'<pre>';
    // var_dump($_POST);
    // echo '</pre>';

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = 'El email es obligatorio o no es valido';
    }
    if (!$password) {
        $errores[] = 'El password es obligatorio';
    }

    if (!$errores) {

        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);


        if ($resultado->num_rows > 0) {
            //Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);

            //Verificar si el password es correcto o no

            $auth = password_verify($password, $usuario["password"]);

            if ($auth) {
                //El usuario esta autenticado
                session_start();
                //Llenar el arreglo de la sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                
                header('Location: /admin');
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El Usuario no existe";
        }
    }
}


//Incluye el header
include 'includes/templates/header.php';
?>


<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>




    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="correo">Correo:</label>
            <input type="email" name="email" id="correo" placeholder="Tu Correo" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu Password" required>


        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>

<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <?php
        include 'includes/templates/footer.php';
        ?>
    </div>

    <p class="copyright">Todos los derechos Reservador 2024 &copy;</p>
</footer>
<script src="build/js/bundle.min.js"></script>
</body>

</html>