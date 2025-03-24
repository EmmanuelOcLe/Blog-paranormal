<?php 
    
    // Si ingresan directamente, se redirecciona al index
    if (!isset($_SESSION["dasfssgddgsgfvgrdf2352"])) {
        header("Location: ../index.php");
        exit();
    }
?>

<aside id="sidebar">
    <div id="buscador" class="bloque">
        <h3>Buscar</h3>
        <form action="buscar.php" method="GET"> 
            <input type="text" name="busqueda" required />
            <input type="submit" value="Buscar" />
        </form>
    </div>
    
    <?php if (isset($_SESSION["user_email"])): ?>
        <div id="usuario-logueado" class="bloque">
            <h3>Bienvenido/a, <?php echo htmlspecialchars($_SESSION["user_name"] ?? 'Usuario'); ?></h3>
            <a href="crear_entradas.php" class="boton boton-verde">Gestionar entradas</a>
            <a href="crear-categoria.php" class="boton">Gestionar categoría</a>
            <a href="mis_datos.php" class="boton boton-naranja">Mis datos</a>
            <a href="cerrar_sesion.php" class="boton boton-rojo">Cerrar sesión</a>
        </div>
    <?php else: ?>
        <div id="login" class="bloque">
            <h3>Inicia Sesión</h3>
            <?php 
                if (isset($_GET["login_status"])) {
                    $mensajes = [
                        "0" => "El usuario especificado no existe",
                        "2" => "Debe ingresar un correo válido",
                        "3" => "Ocurrió un error inesperado"
                    ];
                    if (array_key_exists($_GET["login_status"], $mensajes)) {
                        echo '<div class="alerta alerta-error">' . htmlspecialchars($mensajes[$_GET["login_status"]]) . '</div>';
                    }
                }
            ?>
            <form action="validar_login.php" method="POST"> 
                <label for="email">Email</label>
                <input type="email" name="email" required />
                
                <label for="password">Contraseña</label>
                <input type="password" name="password" required />
                
                <input type="submit" value="Entrar" />
            </form>
        </div>

        <div id="register" class="bloque">
            <h3>Registrarse</h3>
            <?php 
                if (isset($_GET["register_state"])) {
                    $mensajes_registro = [
                        "1" => "Se registró correctamente",
                        "2" => "El email no es válido",
                        "3" => "El usuario ya existe"
                    ];
                    $tipo_alerta = ($_GET["register_state"] == "1") ? "alerta-exito" : "alerta-error";
                    if (array_key_exists($_GET["register_state"], $mensajes_registro)) {
                        echo '<div class="alerta ' . $tipo_alerta . '">' . htmlspecialchars($mensajes_registro[$_GET["register_state"]]) . '</div>';
                    }
                }
            ?>
            <form action="validar_registro.php" method="POST" id="formulario_registro"> 
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required />
                
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" required />
                
                <label for="email">Email</label>
                <input type="email" name="email" required />
                
                <label for="password">Contraseña</label>
                <input type="password" name="password" required />
                
                <input type="submit" name="submit" value="Registrar" />
            </form>
        </div>
    <?php endif; ?>
</aside>
