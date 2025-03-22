<?php
    session_start();

    // Variable que se usa para que no puedan acceder a los includes por url
    $_SESSION["dasfssgddgsgfvgrdf2352"] = "";

    include 'includes/conexion.php';

    
    $id_usuario = $_SESSION["user_id"]; 


    $sql = "select nombre, apellidos, email, password from usuarios where id = $id_usuario";
    $resultado = $conexion->query($sql);

    if ($resultado === false) {
        die("Error en la consulta SQL: " . $conexion->error);
    }

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        die("No se encontraron datos de usuario.");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/mis_datos.css">
  <title>Inicio</title>
</head>
<body>

  
  <!-- Header -->
  <?php include 'includes/header.php' ?>
  <!-- Cuerpo -->
  <div id="contenedor">
      <div id="principal">
        <h1>
          Datos de usuario <img src="assets/usuario.png" alt="Imagen de usuario" id="icono-user">
        </h1>
          <h2>Estos son sus datos de usuario</h2><br>
            <article class="entrada">
                  <label><b>Nombre de usuario: </b></label>
                   <p><?php echo $usuario['nombre']; ?></p>
          </article><br>
          
            <article class="entrada">
                <label><b>Apellido: </b></label>
                <p><?php echo $usuario['apellidos']; ?></p>
            </article><br>
          
            <article class="entrada">
                <label><b>Correo electronico: </b></label>
                <p><?php echo $usuario['email']; ?></p>
            </article><br>

            <article class="entrada">
                <label><b>Contraseña: </b></label>
                <p><?php echo str_repeat('*', 8); ?></p>
            </article>
          
          <div id="ver-todas">
              <a href="modificar_datos.php">Modificar datos</a>
          </div>
      </div>
      
  </div>

  <!-- Footer -->
  <?php include 'includes/footer.php' ?>
</body>
</html>