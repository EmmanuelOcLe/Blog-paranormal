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
        <a href="mis_datos.php" class="boton boton-naranja">{Mis datos}</a>
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
        <div class="alerta alerta-exito">
            {Se registro correctamente}
        </div>
        <div class="alerta alerta-error">
            {Error en algun dato}
        </div>
        
        <form action="registro.php" method="POST"> 
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