<aside id="sidebar">
    <div id="buscador" class="bloque">
        <h3>Buscar</h3>
        <form action="buscar.php" method="POST"> 
            <input type="text" name="busqueda" />
            <input type="submit" value="Buscar" />
        </form>
    </div>
    
    <div id="usuario-logueado" class="bloque">
        <h3>Bienvenido, {Nombre Usuario}</h3>
        <!--botones-->
        <a href="crear-entradas.php" class="boton boton-verde">{Crear entradas}</a>
        <a href="crear-categoria.php" class="boton">{Crear categoria}</a>
        <a href="mis-datos.php" class="boton boton-naranja">{Mis datos}</a>
        <a href="cerrar.php" class="boton boton-rojo">{Cerrar sesión}</a>
    </div>
    
    <div id="login" class="bloque">
        <h3>Inicia Sesión</h3>
        <div class="alerta alerta-error">
            {Usuario no existe}
        </div>
        
        <form action="login.php" method="POST"> 
            <label for="email">Email</label>
            <input type="email" name="email" />
            
            <label for="password">Contraseña</label>
            <input type="password" name="password" />
            
            <input type="submit" value="Entrar" />
        </form>
    </div>
    
    <div id="register" class="bloque">
        <h3>Registrarse</h3>
        
        <!-- Mostrar errores -->
         <?php if (isset($_GET["register_state"])): ?>
            <?php if ($_GET["register_state"] == 1){ ?>
            <div class="alerta alerta-exito">
                Se registro correctamente
            </div>
            <?php }else if ($_GET["register_state"] == 2){ ?>
            <div class="alerta alerta-error">
                El email no es válido
            </div>
            <?php } else { ?>
            <div class="alerta alerta-error">
                El usuario ya existe
            </div>
            <?php } ?>
        <?php endif; ?>
        
        <form action="validar_registro.php" method="POST" id="formulario_registro"> 
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" />
            
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" />
            
            <label for="email">Email</label>
            <input type="email" name="email" />
            
            <label for="password">Contraseña</label>
            <input type="password" name="password" />
            
            <input type="submit" name="submit" value="Registrar" />
        </form>
    </div>
</aside>